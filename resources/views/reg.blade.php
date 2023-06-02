@extends('layouts.base')
@section('title', 'Главная')
@section('main')
<main class="form w-100 m-auto">
  <?php
// dd($errors);
  ?>
  @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  @endif
  <form action="/store" method="POST">
    @csrf
    <div class="form-floating">
      <input type="text" class="form-control" name="name" placeholder="Имя">
      <label for="floatingInput">Имя</label>
    </div>
    <div class="form-floating">
      <input type="email" class="form-control" name="email" placeholder="Email">
      <label for="floatingInput">Email</label>
    </div>
    <div class="form-floating">
      <input type="tel" class="form-control" name="phone" placeholder="Телефон">
      <label for="floatingInput">Телефон</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" name="password" placeholder="Пароль">
      <label for="floatingPassword">Пароль</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" name="password_confirmation" placeholder="Повторите пароль">
      <label for="floatingPassword">Повторите пароль</label>
    </div>
    <div
        id="captcha-container"
        class="smart-captcha"
        data-sitekey="ysc1_pPVoftKnHiDVf5biJbtNku3QHV82dI2cghcgC2Foc8d1763c"
    ></div>
    <button class="btn btn-primary w-100 py-2" type="submit">Регистрация</button>
  </form>
</main>
@endsection('main')