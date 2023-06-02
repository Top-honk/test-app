<!DOCTYPE html>
<html>
  <head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="/styles/main.css" rel="stylesheet" type="text/css">
    <meta charset="UTF-8">
    <title>@yield('title') :: Тестовое</title>
  </head>
  <body>
    <div class="container">
      <h1 class="my-3 text-center">Тестовое</h1>
      <header class="d-flex justify-content-center py-3">
        <ul class="nav nav-pills">
          <li class="nav-item"><a href="/" class="nav-link {{ (request()->is('/')) ? 'active' : '' }}" aria-current="page">Главная</a></li>
          @if (Auth::user() == null)
            <li class="nav-item"><a href="/login" class="nav-link {{ (request()->is('login')) ? 'active' : '' }}">Логин</a></li>
            <li class="nav-item"><a href="/reg" class="nav-link {{ (request()->is('reg')) ? 'active' : '' }}">Регистрация</a></li>
          @else
            <li class="nav-item"><a href="/profile" class="nav-link {{ (request()->is('profile')) ? 'active' : '' }}">Профиль</a></li>
            <li class="nav-item"><a href="/logout" class="nav-link">Выход</a></li>
          @endif
        </ul>
        <?php
            // dd(request());
          ?>
      </header>
      @yield('main')
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://smartcaptcha.yandexcloud.net/captcha.js" defer></script>  
  </body>
</html>