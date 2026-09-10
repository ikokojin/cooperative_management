<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password</title>
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
                <h2>Create a New Password</h2>
                <p>Choose a new password for your account. It must be at least 8 characters.</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" class="form-control"
                        value="{{ $email }}" required autocomplete="email">
                </div>

                <div class="form-group mt-3">
                    <label for="password">New Password</label>
                    <input type="password" name="password" id="password" class="form-control"
                        required autocomplete="new-password">
                    <small class="form-text text-muted">At least 8 characters.</small>
                </div>

                <div class="form-group mt-3">
                    <label for="password_confirmation">Confirm New Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="form-control" required autocomplete="new-password">
                </div>

                <button type="submit" class="btn btn-primary w-100 mt-4">Reset Password</button>
            </form>
        </div>
    </div>

</body>

</html>