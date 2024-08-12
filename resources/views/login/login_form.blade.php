<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログインフォーム</title>
    <script src="{{ asset('js/app.js')}}" defer></script>
    <link href="{{ asset('css/app.css')}}" rel="stylesheet">
    <link href="{{ asset('css/signin.css')}}" rel="stylesheet">
</head>
<body>


<main class="form-signin w-100 m-auto">
  <form method="POST" action="{{ route('login') }}">
　@csrf
    <h1 class="h3 mb-3 fw-normal">ログインフォーム</h1>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="form-floating">
      <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">
      <label for="floatingInput">Email address</label>
    </div>
    <div class="form-floating">
      <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">Password</label>
    </div>

    <button class="btn btn-primary w-100 py-2" type="submit">ログイン</button>
  </form>
</main>

    
</body>
</html>