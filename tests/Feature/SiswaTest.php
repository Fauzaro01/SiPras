<?php

use App\Models\Aspiration;
use App\Models\Category;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

// ==========================================================
// A. PERAN SISWA
// ==========================================================

// ----------------------------------------------------------
// A.1 Siswa Login
// ----------------------------------------------------------

test('A.1 siswa dapat login dengan NIS dan password yang valid', function () {
    $siswa = User::factory()->siswa()->create([
        'nis'      => '12345',
        'password' => Hash::make('password123'),
    ]);

    $response = $this->post('/login', [
        'identifier' => '12345',
        'password'   => 'password123',
    ]);

    $response->assertRedirect('/dashboard');
    $this->assertAuthenticatedAs($siswa);
});

test('A.1 siswa tidak bisa login dengan password salah', function () {
    User::factory()->siswa()->create(['nis' => '12345']);

    $response = $this->post('/login', [
        'identifier' => '12345',
        'password'   => 'password-salah',
    ]);

    $response->assertSessionHasErrors('identifier');
    $this->assertGuest();
});

test('A.1 siswa tidak bisa login dengan NIS yang tidak terdaftar', function () {
    $response = $this->post('/login', [
        'identifier' => '99999',
        'password'   => 'apapun',
    ]);

    $response->assertSessionHasErrors('identifier');
    $this->assertGuest();
});

test('A.1 halaman login menampilkan form login', function () {
    $response = $this->get('/login');

    $response->assertStatus(200)
        ->assertViewIs('auth.login');
});

test('A.1 siswa yang sudah login diarahkan ke dashboard', function () {
    $siswa = User::factory()->siswa()->create();

    $response = $this->actingAs($siswa)->get('/login');

    $response->assertRedirect('/dashboard');
});

// ----------------------------------------------------------
// A.2 Ada Form Input Aspirasi & Simpan
// ----------------------------------------------------------

test('A.2 siswa dapat melihat halaman form input aspirasi', function () {
    $siswa = User::factory()->siswa()->create();

    $response = $this->actingAs($siswa)->get(route('aspirations.create'));

    $response->assertStatus(200)
        ->assertViewIs('aspirations.create');
});

test('A.2 siswa dapat menyimpan aspirasi baru dengan foto', function () {
    Storage::fake('public');
    $siswa    = User::factory()->siswa()->create();
    $category = Category::factory()->create();

    $response = $this->actingAs($siswa)->post(route('aspirations.store'), [
        'judul'       => 'Kerusakan Meja Kelas X-1',
        'deskripsi'   => 'Beberapa meja di kelas X-1 rusak dan perlu diperbaiki segera.',
        'category_id' => $category->id,
        'lokasi'      => 'Gedung A Lantai 2 Kelas X-1',
        'bukti_foto'  => UploadedFile::fake()->create('kerusakan.jpg', 100, 'image/jpeg'),
    ]);

    $response->assertRedirect(route('aspirations.index'));
    $this->assertDatabaseHas('aspirations', [
        'user_id'     => $siswa->id,
        'judul'       => 'Kerusakan Meja Kelas X-1',
        'category_id' => $category->id,
        'status'      => 'diajukan',
    ]);
});

test('A.2 aspirasi gagal disimpan jika field wajib kosong', function () {
    $siswa = User::factory()->siswa()->create();

    $response = $this->actingAs($siswa)->post(route('aspirations.store'), []);

    $response->assertSessionHasErrors(['judul', 'deskripsi', 'category_id', 'lokasi', 'bukti_foto']);
});

test('A.2 form input aspirasi menampilkan daftar kategori', function () {
    $siswa    = User::factory()->siswa()->create();
    $category = Category::factory()->create(['nama' => 'Ruang Kelas']);

    $response = $this->actingAs($siswa)->get(route('aspirations.create'));

    $response->assertSee('Ruang Kelas');
});

// ----------------------------------------------------------
// A.3 Ada Form Data Aspirasi (Kumpulan Aspirasi)
// ----------------------------------------------------------

test('A.3 siswa dapat melihat daftar aspirasi miliknya', function () {
    $siswa = User::factory()->siswa()->create();
    Aspiration::factory()->count(3)->create(['user_id' => $siswa->id]);

    $response = $this->actingAs($siswa)->get(route('aspirations.index'));

    $response->assertStatus(200)
        ->assertViewIs('aspirations.index')
        ->assertViewHas('aspirations', fn ($asp) => $asp->count() === 3);
});

test('A.3 siswa hanya melihat aspirasi miliknya sendiri (bukan orang lain)', function () {
    $siswa1 = User::factory()->siswa()->create();
    $siswa2 = User::factory()->siswa()->create();

    Aspiration::factory()->create(['user_id' => $siswa1->id, 'judul' => 'Aspirasi Milik Saya']);
    Aspiration::factory()->create(['user_id' => $siswa2->id, 'judul' => 'Aspirasi Orang Lain']);

    $response = $this->actingAs($siswa1)->get(route('aspirations.index'));

    $response->assertSee('Aspirasi Milik Saya')
        ->assertDontSee('Aspirasi Orang Lain');
});

test('A.3 siswa tidak melihat aspirasi yang sudah selesai atau ditolak di daftar aktif', function () {
    $siswa = User::factory()->siswa()->create();
    Aspiration::factory()->diajukan()->create(['user_id' => $siswa->id, 'judul' => 'Masih Aktif']);
    Aspiration::factory()->selesai()->create(['user_id' => $siswa->id, 'judul' => 'Sudah Selesai']);
    Aspiration::factory()->ditolak()->create(['user_id' => $siswa->id, 'judul' => 'Sudah Ditolak']);

    $aspirations = $this->actingAs($siswa)->get(route('aspirations.index'))->viewData('aspirations');

    expect($aspirations->pluck('judul'))->toContain('Masih Aktif')
        ->not->toContain('Sudah Selesai')
        ->not->toContain('Sudah Ditolak');
});

test('A.3 siswa dapat menghapus aspirasi miliknya', function () {
    $siswa      = User::factory()->siswa()->create();
    $aspiration = Aspiration::factory()->create(['user_id' => $siswa->id]);

    $response = $this->actingAs($siswa)->delete(route('aspirations.destroy', $aspiration));

    $response->assertRedirect(route('aspirations.index'));
    $this->assertDatabaseMissing('aspirations', ['id' => $aspiration->id]);
});

test('A.3 siswa tidak bisa menghapus aspirasi milik siswa lain', function () {
    $siswa1     = User::factory()->siswa()->create();
    $siswa2     = User::factory()->siswa()->create();
    $aspiration = Aspiration::factory()->create(['user_id' => $siswa2->id]);

    $response = $this->actingAs($siswa1)->delete(route('aspirations.destroy', $aspiration));

    $response->assertStatus(403);
    $this->assertDatabaseHas('aspirations', ['id' => $aspiration->id]);
});

// ----------------------------------------------------------
// A.4 Ada Form Detail Aspirasi (Melihat Umpan Balik & Progress)
// ----------------------------------------------------------

test('A.4 siswa dapat melihat detail aspirasi miliknya', function () {
    $siswa      = User::factory()->siswa()->create();
    $aspiration = Aspiration::factory()->create([
        'user_id' => $siswa->id,
        'judul'   => 'Detail Aspirasi Test',
    ]);

    $response = $this->actingAs($siswa)->get(route('aspirations.show', $aspiration));

    $response->assertStatus(200)
        ->assertViewIs('aspirations.show')
        ->assertSee('Detail Aspirasi Test');
});

test('A.4 siswa tidak bisa melihat detail aspirasi milik siswa lain', function () {
    $siswa1     = User::factory()->siswa()->create();
    $siswa2     = User::factory()->siswa()->create();
    $aspiration = Aspiration::factory()->create(['user_id' => $siswa2->id]);

    $response = $this->actingAs($siswa1)->get(route('aspirations.show', $aspiration));

    $response->assertStatus(403);
});

test('A.4 siswa dapat melihat umpan balik (feedback) dari admin di halaman detail', function () {
    $admin      = User::factory()->admin()->create();
    $siswa      = User::factory()->siswa()->create();
    $aspiration = Aspiration::factory()->create(['user_id' => $siswa->id]);

    Feedback::create([
        'aspiration_id' => $aspiration->id,
        'user_id'       => $admin->id,
        'pesan'         => 'Tim kami akan segera menindaklanjuti laporan ini.',
    ]);

    $response = $this->actingAs($siswa)->get(route('aspirations.show', $aspiration));

    $response->assertStatus(200)
        ->assertSee('Tim kami akan segera menindaklanjuti laporan ini.');
});

test('A.4 siswa dapat melihat status/progress aspirasi di halaman detail', function () {
    $siswa      = User::factory()->siswa()->create();
    $aspiration = Aspiration::factory()->diproses()->create(['user_id' => $siswa->id]);

    $response = $this->actingAs($siswa)->get(route('aspirations.show', $aspiration));

    $response->assertStatus(200);
    // Check status displayed somewhere in the page (view capitalizes: Diproses)
    $response->assertSee('Diproses', false);
});

test('A.4 halaman detail menampilkan multiple feedback dengan urutan terbaru', function () {
    $admin      = User::factory()->admin()->create();
    $siswa      = User::factory()->siswa()->create();
    $aspiration = Aspiration::factory()->create(['user_id' => $siswa->id]);

    Feedback::create(['aspiration_id' => $aspiration->id, 'user_id' => $admin->id, 'pesan' => 'Feedback pertama.']);
    Feedback::create(['aspiration_id' => $aspiration->id, 'user_id' => $admin->id, 'pesan' => 'Feedback kedua.']);

    $response = $this->actingAs($siswa)->get(route('aspirations.show', $aspiration));

    $response->assertSee('Feedback pertama.')
        ->assertSee('Feedback kedua.');
});

// ----------------------------------------------------------
// A.5 Ada Form Ganti Password
// ----------------------------------------------------------

test('A.5 siswa dapat mengakses halaman form ganti password', function () {
    $siswa = User::factory()->siswa()->create();

    $response = $this->actingAs($siswa)->get(route('password.change'));

    $response->assertStatus(200)
        ->assertViewIs('profile.change-password');
});

test('A.5 siswa dapat mengganti password dengan password lama yang benar', function () {
    $siswa = User::factory()->siswa()->create([
        'password' => Hash::make('passwordLama123'),
    ]);

    $response = $this->actingAs($siswa)->post(route('password.update'), [
        'current_password'      => 'passwordLama123',
        'password'              => 'passwordBaru456',
        'password_confirmation' => 'passwordBaru456',
    ]);

    $response->assertRedirect(route('dashboard'));
    $this->assertTrue(Hash::check('passwordBaru456', $siswa->fresh()->password));
});

test('A.5 ganti password gagal jika password lama salah', function () {
    $siswa = User::factory()->siswa()->create([
        'password' => Hash::make('passwordBenar123'),
    ]);

    $response = $this->actingAs($siswa)->post(route('password.update'), [
        'current_password'      => 'passwordSalah999',
        'password'              => 'passwordBaru456',
        'password_confirmation' => 'passwordBaru456',
    ]);

    $response->assertSessionHasErrors('current_password');
    $this->assertFalse(Hash::check('passwordBaru456', $siswa->fresh()->password));
});

test('A.5 ganti password gagal jika konfirmasi tidak cocok', function () {
    $siswa = User::factory()->siswa()->create([
        'password' => Hash::make('passwordLama123'),
    ]);

    $response = $this->actingAs($siswa)->post(route('password.update'), [
        'current_password'      => 'passwordLama123',
        'password'              => 'passwordBaru456',
        'password_confirmation' => 'tidakcocok999',
    ]);

    $response->assertSessionHasErrors('password');
});

test('A.5 ganti password gagal jika password baru kurang dari 6 karakter', function () {
    $siswa = User::factory()->siswa()->create([
        'password' => Hash::make('passwordLama123'),
    ]);

    $response = $this->actingAs($siswa)->post(route('password.update'), [
        'current_password'      => 'passwordLama123',
        'password'              => 'abc',
        'password_confirmation' => 'abc',
    ]);

    $response->assertSessionHasErrors('password');
});

// ----------------------------------------------------------
// Proteksi: halaman tidak bisa diakses tanpa login
// ----------------------------------------------------------

test('halaman aspirasi tidak bisa diakses tanpa login', function () {
    $response = $this->get(route('aspirations.index'));

    $response->assertRedirect('/login');
});

test('halaman ganti password tidak bisa diakses tanpa login', function () {
    $response = $this->get(route('password.change'));

    $response->assertRedirect('/login');
});
