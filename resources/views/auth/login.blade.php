<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="body">
  <form class="form-signin" method="POST" action="{{ route('login') }}">
    <img src="{{ asset('img/logo.png') }}" width="150" height="150" alt="" class="mb-4">
    <h1 class="h3 mb-3 font-weight-normal">{{ config('app.name') }}</h1>
    <label for="inputEmail" class="sr-only">Email address</label>
    <input id="email" type="email" placeholder="Alamat Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>                            
    <label for="inputPassword" class="sr-only">Password</label>
    <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
    @csrf
    @error('email')
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
    @enderror
    @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
    <div class="checkbox mb-3">
      <label>
        <input name="remember" {{ old('remember') ? 'checked' : '' }} type="checkbox" value="remember-me"> Remember me
      </label>
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2017-2019</p>
  </form>
  {{-- copyright by andrew yohanes
    -- https://github.com/andrewyohanes123
    -- 
  --}}
</body>
</html>