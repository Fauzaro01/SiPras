<?php

use App\Models\Aspiration;
use App\Models\Category;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

// ==========================================================
// B. PERAN ADMIN (STAF SARANA DAN PRASARANA)
// ==========================================================

// ----------------------------------------------------------
// B.1 Admin Login
// ----------------------------------------------------------

test('B.1 admin dapat login dengan username dan password yang valid', function () {
    $admin = User::factory()->admin()->create([
        'username' => 'admintest',
        'password' => Hash::make('admin123'),
    ]);

    $response = $this->post('/login', [
        'identifier' => 'admintest',
        'password' => 'admin123',
    ]);

    $response->assertRedirect('/dashboard');
    $this->assertAuthenticatedAs($admin);
});

test('B.1 admin tidak bisa login dengan password salah', function () {
    User::factory()->admin()->create(['username' => 'admintest']);

    $response = $this->post('/login', [
        'identifier' => 'admintest',
        'password' => 'salah123',
    ]);

    $response->assertSessionHasErrors('identifier');
    $this->assertGuest();
});

test('B.1 admin tidak bisa login dengan username yang tidak terdaftar', function () {
    $response = $this->post('/login', [
        'identifier' => 'tidakada',
        'password' => 'apapun',
    ]);

    $response->assertSessionHasErrors('identifier');
    $this->assertGuest();
});

// ----------------------------------------------------------
// B.2 Admin Dapat Melihat List Aspirasi (diajukan & diproses)
// ----------------------------------------------------------

test('B.2 admin dapat melihat halaman daftar aspirasi', function () {
    $admin = User::factory()->admin()->create();
    $siswa = User::factory()->siswa()->create();
    Aspiration::factory()->count(3)->diajukan()->create(['user_id' => $siswa->id]);

    $response = $this->actingAs($admin)->get(route('aspirations.index'));

    $response->assertStatus(200)
        ->assertViewIs('aspirations.index')
        ->assertViewHas('aspirations');
});

test('B.2 daftar aspirasi admin hanya menampilkan status diajukan dan diproses', function () {
    $admin = User::factory()->admin()->create();
    $siswa = User::factory()->siswa()->create();

    Aspiration::factory()->diajukan()->create(['user_id' => $siswa->id, 'judul' => 'Diajukan Item']);
    Aspiration::factory()->diproses()->create(['user_id' => $siswa->id, 'judul' => 'Diproses Item']);
    Aspiration::factory()->selesai()->create(['user_id' => $siswa->id, 'judul' => 'Selesai Item']);
    Aspiration::factory()->ditolak()->create(['user_id' => $siswa->id, 'judul' => 'Ditolak Item']);

    $aspirations = $this->actingAs($admin)->get(route('aspirations.index'))->viewData('aspirations');

    $statuses = $aspirations->pluck('status')->unique()->toArray();
    expect($statuses)->each->toBeIn(['diajukan', 'diproses']);
    expect($aspirations->pluck('judul'))->not->toContain('Selesai Item')
        ->not->toContain('Ditolak Item');
});

test('B.2 admin dapat melihat semua aspirasi dari semua siswa', function () {
    $admin = User::factory()->admin()->create();
    $siswa1 = User::factory()->siswa()->create();
    $siswa2 = User::factory()->siswa()->create();

    Aspiration::factory()->create(['user_id' => $siswa1->id, 'judul' => 'Aspirasi dari Siswa 1']);
    Aspiration::factory()->create(['user_id' => $siswa2->id, 'judul' => 'Aspirasi dari Siswa 2']);

    $aspirations = $this->actingAs($admin)->get(route('aspirations.index'))->viewData('aspirations');

    expect($aspirations->count())->toBe(2);
});

test('B.2 daftar aspirasi admin memprioritaskan yang diajukan terlebih dahulu', function () {
    $admin = User::factory()->admin()->create();
    $siswa = User::factory()->siswa()->create();

    Aspiration::factory()->diproses()->create(['user_id' => $siswa->id]);
    Aspiration::factory()->diajukan()->create(['user_id' => $siswa->id]);

    $aspirations = $this->actingAs($admin)->get(route('aspirations.index'))->viewData('aspirations');

    // First item should be 'diajukan'
    expect($aspirations->first()->status)->toBe('diajukan');
});

// ----------------------------------------------------------
// B.3 Admin Dapat Memberi Umpan Balik (Feedback)
// ----------------------------------------------------------

test('B.3 admin dapat menambahkan feedback pada aspirasi', function () {
    $admin = User::factory()->admin()->create();
    $siswa = User::factory()->siswa()->create();
    $aspiration = Aspiration::factory()->create(['user_id' => $siswa->id]);

    $response = $this->actingAs($admin)->post(route('feedbacks.store', $aspiration), [
        'pesan' => 'Laporan sudah kami terima dan akan segera ditindaklanjuti.',
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('feedbacks', [
        'aspiration_id' => $aspiration->id,
        'user_id' => $admin->id,
        'pesan' => 'Laporan sudah kami terima dan akan segera ditindaklanjuti.',
    ]);
});

test('B.3 admin dapat menambahkan beberapa feedback pada satu aspirasi', function () {
    $admin = User::factory()->admin()->create();
    $aspiration = Aspiration::factory()->create();

    $this->actingAs($admin)->post(route('feedbacks.store', $aspiration), ['pesan' => 'Feedback 1.']);
    $this->actingAs($admin)->post(route('feedbacks.store', $aspiration), ['pesan' => 'Feedback 2.']);

    expect($aspiration->feedbacks()->count())->toBe(2);
});

test('B.3 admin dapat menghapus feedback', function () {
    $admin = User::factory()->admin()->create();
    $aspiration = Aspiration::factory()->create();
    $feedback = Feedback::create([
        'aspiration_id' => $aspiration->id,
        'user_id' => $admin->id,
        'pesan' => 'Feedback yang akan dihapus.',
    ]);

    $response = $this->actingAs($admin)->delete(route('feedbacks.destroy', [$aspiration, $feedback]));

    $response->assertRedirect();
    $this->assertDatabaseMissing('feedbacks', ['id' => $feedback->id]);
});

test('B.3 siswa tidak dapat menambahkan feedback', function () {
    $siswa = User::factory()->siswa()->create();
    $aspiration = Aspiration::factory()->create(['user_id' => $siswa->id]);

    $response = $this->actingAs($siswa)->post(route('feedbacks.store', $aspiration), [
        'pesan' => 'Percobaan feedback dari siswa.',
    ]);

    $response->assertStatus(403);
    $this->assertDatabaseCount('feedbacks', 0);
});

test('B.3 feedback wajib diisi (tidak boleh kosong)', function () {
    $admin = User::factory()->admin()->create();
    $aspiration = Aspiration::factory()->create();

    $response = $this->actingAs($admin)->post(route('feedbacks.store', $aspiration), ['pesan' => '']);

    $response->assertSessionHasErrors('pesan');
});

// ----------------------------------------------------------
// B.4 Admin Dapat Merubah Status Penyelesaian
// ----------------------------------------------------------

test('B.4 admin dapat mengubah status aspirasi ke diproses', function () {
    $admin = User::factory()->admin()->create();
    $aspiration = Aspiration::factory()->diajukan()->create();

    $this->actingAs($admin)->post(route('aspirations.update-status', $aspiration), [
        'status' => 'diproses',
    ]);

    expect($aspiration->fresh()->status)->toBe('diproses');
});

test('B.4 admin dapat mengubah status aspirasi ke selesai', function () {
    $admin = User::factory()->admin()->create();
    $aspiration = Aspiration::factory()->diproses()->create();

    $this->actingAs($admin)->post(route('aspirations.update-status', $aspiration), [
        'status' => 'selesai',
    ]);

    expect($aspiration->fresh()->status)->toBe('selesai');
});

test('B.4 admin dapat mengubah status aspirasi ke ditolak', function () {
    $admin = User::factory()->admin()->create();
    $aspiration = Aspiration::factory()->diajukan()->create();

    $this->actingAs($admin)->post(route('aspirations.update-status', $aspiration), [
        'status' => 'ditolak',
    ]);

    expect($aspiration->fresh()->status)->toBe('ditolak');
});

test('B.4 siswa tidak dapat mengubah status aspirasi', function () {
    $siswa = User::factory()->siswa()->create();
    $aspiration = Aspiration::factory()->diajukan()->create(['user_id' => $siswa->id]);

    $response = $this->actingAs($siswa)->post(route('aspirations.update-status', $aspiration), [
        'status' => 'selesai',
    ]);

    $response->assertStatus(403);
    expect($aspiration->fresh()->status)->toBe('diajukan');
});

test('B.4 status tidak valid akan divalidasi dan ditolak', function () {
    $admin = User::factory()->admin()->create();
    $aspiration = Aspiration::factory()->create();

    $response = $this->actingAs($admin)->post(route('aspirations.update-status', $aspiration), [
        'status' => 'status-tidak-valid',
    ]);

    $response->assertSessionHasErrors('status');
});

// ----------------------------------------------------------
// B.5 Admin Dapat Melihat Histori Aspirasi
// ----------------------------------------------------------

test('B.5 admin dapat mengakses halaman histori aspirasi', function () {
    $admin = User::factory()->admin()->create();

    $response = $this->actingAs($admin)->get(route('aspirations.histori'));

    $response->assertStatus(200)
        ->assertViewIs('aspirations.histori');
});

test('B.5 histori aspirasi admin menampilkan semua aspirasi selesai dan ditolak dari semua siswa', function () {
    $admin = User::factory()->admin()->create();
    $siswa1 = User::factory()->siswa()->create();
    $siswa2 = User::factory()->siswa()->create();

    Aspiration::factory()->selesai()->create(['user_id' => $siswa1->id, 'judul' => 'Selesai dari Siswa 1']);
    Aspiration::factory()->ditolak()->create(['user_id' => $siswa2->id, 'judul' => 'Ditolak dari Siswa 2']);
    Aspiration::factory()->diajukan()->create(['user_id' => $siswa1->id, 'judul' => 'Masih Aktif']);

    $aspirations = $this->actingAs($admin)->get(route('aspirations.histori'))->viewData('aspirations');

    expect($aspirations->count())->toBe(2);
    expect($aspirations->pluck('judul'))->toContain('Selesai dari Siswa 1')
        ->toContain('Ditolak dari Siswa 2')
        ->not->toContain('Masih Aktif');
});

test('B.5 histori hanya menampilkan status selesai dan ditolak', function () {
    $admin = User::factory()->admin()->create();
    $siswa = User::factory()->siswa()->create();

    Aspiration::factory()->selesai()->create(['user_id' => $siswa->id]);
    Aspiration::factory()->ditolak()->create(['user_id' => $siswa->id]);

    $aspirations = $this->actingAs($admin)->get(route('aspirations.histori'))->viewData('aspirations');

    foreach ($aspirations as $aspiration) {
        expect($aspiration->status)->toBeIn(['selesai', 'ditolak']);
    }
});

// ----------------------------------------------------------
// B.6 Admin Dapat Menambahkan Data Siswa (Form Input Siswa)
// ----------------------------------------------------------

test('B.6 admin dapat mengakses halaman tambah pengguna baru', function () {
    $admin = User::factory()->admin()->create();

    $response = $this->actingAs($admin)->get(route('users.create'));

    $response->assertStatus(200)
        ->assertViewIs('users.create');
});

test('B.6 admin dapat menambahkan siswa baru', function () {
    $admin = User::factory()->admin()->create();

    $response = $this->actingAs($admin)->post(route('users.store'), [
        'name' => 'Siswa Baru Tes',
        'role' => 'siswa',
        'nis' => '98765',
        'kelas' => 'X-4',
        'password' => 'siswa123',
        'password_confirmation' => 'siswa123',
    ]);

    $response->assertRedirect(route('users.index'));
    $this->assertDatabaseHas('users', [
        'name' => 'Siswa Baru Tes',
        'nis' => '98765',
        'kelas' => 'X-4',
        'role' => 'siswa',
    ]);
});

test('B.6 admin dapat menambahkan admin baru', function () {
    $admin = User::factory()->admin()->create();

    $response = $this->actingAs($admin)->post(route('users.store'), [
        'name' => 'Admin Baru Tes',
        'role' => 'admin',
        'username' => 'adminbaru',
        'password' => 'admin123',
        'password_confirmation' => 'admin123',
    ]);

    $response->assertRedirect(route('users.index'));
    $this->assertDatabaseHas('users', [
        'name' => 'Admin Baru Tes',
        'username' => 'adminbaru',
        'role' => 'admin',
    ]);
});

test('B.6 tambah siswa gagal jika NIS sudah dipakai', function () {
    $admin = User::factory()->admin()->create();
    User::factory()->siswa()->create(['nis' => '11111']);

    $response = $this->actingAs($admin)->post(route('users.store'), [
        'name' => 'Siswa Duplikat',
        'role' => 'siswa',
        'nis' => '11111',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertSessionHasErrors('nis');
});

test('B.6 siswa tidak dapat mengakses halaman tambah pengguna', function () {
    $siswa = User::factory()->siswa()->create();

    $response = $this->actingAs($siswa)->get(route('users.create'));

    $response->assertStatus(403);
});

// ----------------------------------------------------------
// B.7 Admin Dapat Melihat, Edit, dan Hapus Data Siswa
// ----------------------------------------------------------

test('B.7 admin dapat melihat daftar pengguna', function () {
    $admin = User::factory()->admin()->create();
    User::factory()->siswa()->count(3)->create();

    $response = $this->actingAs($admin)->get(route('users.index'));

    $response->assertStatus(200)
        ->assertViewIs('users.index')
        ->assertViewHas('users', fn ($users) => $users->count() >= 3);
});

test('B.7 admin dapat mengedit data pengguna', function () {
    $admin = User::factory()->admin()->create();
    $siswa = User::factory()->siswa()->create(['kelas' => 'X-1']);

    $response = $this->actingAs($admin)->put(route('users.update', $siswa), [
        'name' => 'Nama Sudah Diubah',
        'kelas' => 'XII-2',
        'nis' => $siswa->nis,
    ]);

    $response->assertRedirect(route('users.index'));
    expect($siswa->fresh()->name)->toBe('Nama Sudah Diubah');
    expect($siswa->fresh()->kelas)->toBe('XII-2');
});

test('B.7 admin dapat mengganti password pengguna saat edit', function () {
    $admin = User::factory()->admin()->create();
    $siswa = User::factory()->siswa()->create();

    $this->actingAs($admin)->put(route('users.update', $siswa), [
        'name' => $siswa->name,
        'nis' => $siswa->nis,
        'password' => 'newpassword123',
        'password_confirmation' => 'newpassword123',
    ]);

    $this->assertTrue(Hash::check('newpassword123', $siswa->fresh()->password));
});

test('B.7 admin dapat menghapus pengguna', function () {
    $admin = User::factory()->admin()->create();
    $siswa = User::factory()->siswa()->create();

    $response = $this->actingAs($admin)->delete(route('users.destroy', $siswa));

    $response->assertRedirect(route('users.index'));
    $this->assertDatabaseMissing('users', ['id' => $siswa->id]);
});

test('B.7 admin tidak dapat menghapus dirinya sendiri', function () {
    $admin = User::factory()->admin()->create();

    $response = $this->actingAs($admin)->delete(route('users.destroy', $admin));

    $response->assertRedirect(route('users.index'));
    $this->assertDatabaseHas('users', ['id' => $admin->id]);
});

test('B.7 siswa tidak dapat mengakses halaman pengguna', function () {
    $siswa = User::factory()->siswa()->create();

    $response = $this->actingAs($siswa)->get(route('users.index'));

    $response->assertStatus(403);
});

// ----------------------------------------------------------
// B.8 Admin Dapat Menambahkan Data Kategori (Form Input Kategori)
// ----------------------------------------------------------

test('B.8 admin dapat mengakses halaman kategori', function () {
    $admin = User::factory()->admin()->create();

    $response = $this->actingAs($admin)->get(route('categories.index'));

    $response->assertStatus(200)
        ->assertViewIs('categories.index');
});

test('B.8 admin dapat menambahkan kategori baru', function () {
    $admin = User::factory()->admin()->create();

    $response = $this->actingAs($admin)->post(route('categories.store'), [
        'nama' => 'Fasilitas Olahraga',
        'deskripsi' => 'Aspirasi terkait fasilitas olahraga sekolah.',
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('categories', ['nama' => 'Fasilitas Olahraga']);
});

test('B.8 tambah kategori gagal jika nama sudah dipakai', function () {
    $admin = User::factory()->admin()->create();
    Category::factory()->create(['nama' => 'Ruang Kelas']);

    $response = $this->actingAs($admin)->post(route('categories.store'), [
        'nama' => 'Ruang Kelas',
        'deskripsi' => 'Duplikat.',
    ]);

    $response->assertSessionHasErrors('nama');
});

test('B.8 tambah kategori gagal jika nama kosong', function () {
    $admin = User::factory()->admin()->create();

    $response = $this->actingAs($admin)->post(route('categories.store'), [
        'nama' => '',
        'deskripsi' => 'Deskripsi ada.',
    ]);

    $response->assertSessionHasErrors('nama');
});

test('B.8 siswa tidak dapat menambahkan kategori', function () {
    $siswa = User::factory()->siswa()->create();

    $response = $this->actingAs($siswa)->post(route('categories.store'), [
        'nama' => 'Kategori Percobaan',
    ]);

    $response->assertStatus(403);
    $this->assertDatabaseCount('categories', 0);
});

// ----------------------------------------------------------
// B.9 Admin Dapat Melihat, Edit, dan Hapus Data Kategori
// ----------------------------------------------------------

test('B.9 admin dapat melihat daftar kategori', function () {
    $admin = User::factory()->admin()->create();
    Category::factory()->count(3)->create();

    $response = $this->actingAs($admin)->get(route('categories.index'));

    $response->assertStatus(200)
        ->assertViewHas('categories', fn ($cats) => $cats->count() === 3);
});

test('B.9 admin dapat mengubah data kategori', function () {
    $admin = User::factory()->admin()->create();
    $category = Category::factory()->create(['nama' => 'Kategori Lama']);

    $response = $this->actingAs($admin)->put(route('categories.update', $category), [
        'nama' => 'Kategori Baru Diperbarui',
        'deskripsi' => 'Deskripsi baru.',
    ]);

    $response->assertRedirect();
    expect($category->fresh()->nama)->toBe('Kategori Baru Diperbarui');
});

test('B.9 admin dapat menghapus kategori yang tidak memiliki aspirasi', function () {
    $admin = User::factory()->admin()->create();
    $category = Category::factory()->create();

    $response = $this->actingAs($admin)->delete(route('categories.destroy', $category));

    $response->assertRedirect();
    $this->assertDatabaseMissing('categories', ['id' => $category->id]);
});

test('B.9 admin tidak dapat menghapus kategori yang masih memiliki aspirasi', function () {
    $admin = User::factory()->admin()->create();
    $siswa = User::factory()->siswa()->create();
    $category = Category::factory()->create();
    Aspiration::factory()->create(['user_id' => $siswa->id, 'category_id' => $category->id]);

    $response = $this->actingAs($admin)->delete(route('categories.destroy', $category));

    $response->assertRedirect();
    $response->assertSessionHas('error');
    $this->assertDatabaseHas('categories', ['id' => $category->id]);
});

test('B.9 siswa tidak dapat mengubah kategori', function () {
    $siswa = User::factory()->siswa()->create();
    $category = Category::factory()->create(['nama' => 'Kategori Asli']);

    $response = $this->actingAs($siswa)->put(route('categories.update', $category), [
        'nama' => 'Coba Ubah',
    ]);

    $response->assertStatus(403);
    expect($category->fresh()->nama)->toBe('Kategori Asli');
});
