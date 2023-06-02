@extends('layouts.base')
@section('title', 'Главная')
@section('main')
<main class="form w-100 m-auto">
  <?php
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
  <form action="/profile" method="POST">
    @csrf
    <div class="form-floating">
      <input type="text" class="form-control" name="name" placeholder="Имя" value="{{ Auth::user()->name }}">
      <label for="floatingInput">Имя</label>
    </div>
    <div class="form-floating">
      <input type="email" class="form-control" name="email" placeholder="Email" value="{{ Auth::user()->email }}">
      <label for="floatingInput">Email</label>
    </div>
    <div class="form-floating">
      <input type="tel" class="form-control" name="phone" placeholder="Телефон" value="{{ Auth::user()->phone }}">
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
    <button class="btn btn-primary w-100 py-2 mt-3" type="submit">Обновить</button>
  </form>
</main>
@endsection('main')
