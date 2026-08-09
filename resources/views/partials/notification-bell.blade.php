<!-- resources/views/partials/notification-bell.blade.php -->
<div x-data="notificationBell()" class="relative" @click.away="open = false">
    <button @click="open = !open" class="p-2 rounded-full hover:bg-gray-100 focus:outline-none">
        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        <span x-show="unreadCount > 0" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center animate-pulse" x-text="unreadCount"></span>
    </button>

    <div x-show="open" x-transition class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-md shadow-lg z-50 overflow-hidden">
        <div class="p-2 border-b border-gray-200 dark:border-gray-700 font-semibold text-gray-800 dark:text-gray-200">
            Notifikasi
        </div>
        <template x-if="notifications.length === 0">
            <div class="p-4 text-center text-gray-500 dark:text-gray-400">Tidak ada notifikasi.</div>
        </template>
        <ul class="max-h-64 overflow-y-auto">
            <template x-for="note in notifications" :key="note.id">
                <li class="px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer flex justify-between items-start" @click="markAsRead(note.id)">
                    <div class="flex-1">
                        <div class="text-sm font-medium" x-text="note.data.title"></div>
                        <div class="text-xs text-gray-500 dark:text-gray-400" x-text="note.created_at"></div>
                    </div>
                    <svg x-show="!note.read_at" class="w-3 h-3 text-blue-500 mt-1" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="4"/></svg>
                </li>
            </template>
        </ul>
        <div class="border-t border-gray-200 dark:border-gray-700 p-2 text-center">
            <button @click="markAllAsRead()" class="text-xs text-blue-600 hover:underline">Baca semua</button>
        </div>
    </div>
</div>

<script>
function notificationBell() {
    return {
        notifications: [],
        unreadCount: 0,
        open: false,
        fetch() {
            fetch('/notifications')
                .then(r => r.json())
                .then(data => {
                    this.notifications = data;
                    this.unreadCount = data.filter(n => !n.read_at).length;
                });
        },
        markAsRead(id) {
            fetch(`/notifications/${id}/read`, { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content } })
                .then(() => this.fetch());
        },
        markAllAsRead() {
            fetch(`/notifications/read-all`, { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content } })
                .then(() => this.fetch());
        },
        init() {
            this.fetch();
            setInterval(() => this.fetch(), 30000);
        }
    };
}
</script>
