<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kode Verifikasi Akun</title>
</head>

<body>
    <p>Halo {{ $user->name }},</p>
    <p>Terima kasih telah mendaftar. Berikut kode verifikasi akun Anda:</p>
    <h2>{{ $user->verification_code }}</h2>
    <p>Masukkan kode ini di aplikasi untuk mengaktifkan akun Anda.</p>
</body>

</html>
