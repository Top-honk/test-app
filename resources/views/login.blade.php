@extends('layouts.base')
@section('title', 'Главная')
@section('main')
<main class="form w-100 m-auto">
  @if ($errors->any())
  <div class="alert alert-danger">
      <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
  </div>
  @endif
  <form action="/authenticate" method="POST" class="login">
    @csrf
    <div class="form-floating">
      <input type="text" class="form-control" name="login" placeholder="name@example.com">
      <label for="floatingInput">Email или телефон</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" name="password" placeholder="Password">
      <label for="floatingPassword">Пароль</label>
    </div>
    <x-yandex-captcha></x-yandex-captcha>

    <button class="btn btn-primary w-100 py-2 mt-3" type="submit">Войти</button>
  </form>
</main>
@endsection('main')