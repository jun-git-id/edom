<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login form 2 </title>
    <link rel="stylesheet" type="text/css" href="<?= url('/login-form2/css/style.css') ?>">
</head>

<body>
    <section class="login-page">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="box">
                <div class="form-head">
                    <h2 id="judul">Sistem Informasi Evaluasi Dosen oleh Mahasiswa(EDOM)</h2>
                    <h2>Login</h2>
                </div>
                <div class="form-body">
                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus placeholder="Username / NIM / Nomor Induk">
                    @error('username')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-footer">
                    <input type="checkbox" name="remember" id="" {{ old('remember') ? 'checked' : '' }}> <span class="remember-me">Remember me</span>
                    <br>
                    <br><br>
                    <button type="submit">Sign In</button>
                </div>
            </div>

        </form>

    </section>


</body>

</html>
