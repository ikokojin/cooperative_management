<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forgot Password</title>
    <link rel="icon" href="images/websitelogo.png" type="image/png">

    <link rel="stylesheet" href="css_folder/login.css">
    <link rel="stylesheet" href="css_folder/loading.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="font-awesome-icon/css/all.min.css">
</head>

<body class="auth-shell">

    <div class="container-fluid d-flex align-items-center justify-content-center min-vh-100">
        <div class="auth-card">
            <div class="auth-card-head">
                <h2>Forgot Password</h2>
                <p>Enter the email linked to your cooperative account and we will send you a reset link.</p>
            </div>

            @if (session('status'))
                <div class="alert alert-info">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" class="form-control"
                        value="{{ old('email') }}" required autofocus autocomplete="email">
                </div>

                <button type="submit" class="btn btn-primary w-100 mt-3">Send Reset Link</button>
            </form>

            <div class="text-center mt-3">
                <a href="{{ route('login') }}">Back to sign in</a>
            </div>
        </div>
    </div>

</body>

</html>