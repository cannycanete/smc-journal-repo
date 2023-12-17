<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SMC Research Journal Online Repository</title>

    {{-- CSS --}}
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <div class="main">

            <h1 class="m-bot">REGISTER</h1>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="input-group">
                    <!-- Name -->
                    <input type="text" id="name" name="name" :value="old('name')" required placeholder="Name">
                </div>

                <div class="input-group m-top">
                    <!-- Email Address -->
                    <input type="email" id="email" name="email" :value="old('email')" required placeholder="Email">
                </div>

                <div class="input-group m-top">
                    <!-- Password -->
                    <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Password">
                </div>

                <div class="input-group m-top">
                    <!-- Confirm Password -->
                    <input id="password_confirmation" class="block mt-1 w-full" type="password"
                        name="password_confirmation" required placeholder="Confirm Password">
                </div>

                
                <button type="submit" class="login-btn m-top">Register</button>

                <div class="flex m-top" style="padding: 0rem 0.25rem">
                    <span>Already have an account?</span>
                    <a href="{{ route('login') }}" class="text-bold right-pos-m">Login</a>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
