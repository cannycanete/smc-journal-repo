<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SMC Research Journal Online Repository</title>

    {{-- CSS --}}
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">

    {{-- Bootsrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
</head>

<body>
    <div class="wrapper">
        <div class="main">

            <h1 class="m-bot">LOGIN</h1>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="input-group">
                    <!-- Email Address -->
                    <i class="bi bi-person-fill"></i>
                    <input id="email" type="email" name="email" :value="old('email')" required
                        autocomplete="username" placeholder="Email">
                </div>

                <div class="input-group m-top">
                    <!-- Password -->
                    <i class="bi bi-lock-fill"></i>
                    <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Password">
                </div>



                <button type="submit" class="login-btn m-top">{{ __('Log in') }}</button>

                <div class="flex m-top" style="padding: 0rem 0.25rem">
                    <span>Don't have an account yet?</span>
                    <a href="{{ route('register') }}" class="text-bold right-pos-m">Register</a>
                </div>

            </form>
        </div>
    </div>

</body>

</html>
