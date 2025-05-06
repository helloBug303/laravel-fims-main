<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('lib/images/invenLogo22.png') }}">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>


<body class="login-page-body">
    <div class="login-container">
        <div class="login-header">
        <img src="{{ asset('lib/images/invenLogo22.png') }}" alt="Francheska's IMS Logo" />
            <p>Please log in to continue</p>
        </div>

        @if ($errors->any())
            <ul class="error-msg">
                @foreach ($errors->all() as $error)
                    <li><strong>Error:</strong> {{ $error }} </li>
                @endforeach
            </ul>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="username" class="control-label">Username</label>
                <input type="text" class="form-control" name="username" id="username" value="{{ old('username') }}" placeholder="Enter your username" required autofocus>
            </div>

            <div class="form-group">
                <label for="password" class="control-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
            </div>

            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</body>
</html>
