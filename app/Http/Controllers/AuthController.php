<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator; 

class AuthController extends Controller {
  private $validateErrors = [
    'name.required' => 'Имя обязательно для заполнения',
    'name.unique' => 'Такое имя уже существует',
    'email.required' => 'Email обязателен для заполнения',
    'email.unique' => 'Такой email уже существует',
    'phone.required' => 'Номер обязателен для заполнения',
    'password.required' => 'Пароль обязателен для заполнения',
    'password.confirmed' => 'Пароли должны совпадать',
    'password.min' => 'Пароль должен быть не менее 8 символов',
  ];

  public function index() {
    return view('index');
  }

  public function reg() {
    return view('reg');
  }

  public function createUser(Request $request) {
    $validated = $request->validate([
      'name' => 'required|unique:users',
      'email' => 'required|unique:users',
      'phone' => 'required|min:11|numeric',
      'password' => 'required|confirmed|min:8',
      'smart-token' => ['required']  
    ], $this->validateErrors);

    if (!$this->checkCaptcha($validated['smart-token'])) {
      return back()->withErrors([
        'smart-token' => 'Капча нне пройдена',
      ]);
    }

    User::create([
      'name' => $request->input('name'),
      'email' => $request->input('email'),
      'password' => Hash::make($request->input('password')),
      'phone' => $request->input('phone'),
    ]);
    $name = $request->input('name');

    return redirect('login');
  }

  public function profile(Request $request) {
    if (Auth::user() == null) {
      return redirect()->intended('/');
    }
    return view('profile');
  }

  public function updateProfile(Request $request) {
    $user = Auth::user();
    if ($user == null) {
      return redirect()->intended('/');
    }

    $validated = $request->validate([
      'name' => 'required',
      'email' => 'required',
      'phone' => 'required|min:11|numeric',
      'password' => ['required', 'confirmed', Password::min(8)],
    ], $this->validateErrors);

    /*
      $validator = Validator::make($input, $rules, $messages = [
        'required' => 'The :attribute field is required.',
      ]);

      $messages = [
          'same' => 'The :attribute and :other must match.',
          'size' => 'The :attribute must be exactly :size.',
          'between' => 'The :attribute value :input is not between :min - :max.',
          'in' => 'The :attribute must be one of the following types: :values',
      ];
     */

    if ($user->name != $validated['name'] && User::where('name', $validated['name'])->first() == null) {
      $user->name = $validated['name'];
    }
    
    if ($user->email != $validated['email'] && User::where('email', $validated['email'])->first() == null) {
      $user->email = $validated['email'];
    }
    
    if ($user->phone != $validated['phone'] && User::where('phone', $validated['phone'])->first() == null) {
      $user->phone = $validated['phone'];
    }

    if (!Hash::check($request->password, $request->user()->password)) {
      $user->password = Hash::make($validated['password']);
    }

    $user->save(); 
    return view('profile');
  }

  public function login(Request $request) {
    return view('login');
  }

  public function authenticate(Request $request) {
      $credentials = $request->validate([
          'login' => ['required'],
          'password' => ['required'],
          'smart-token' => ['required'] 
      ]);

      if (!$this->checkCaptcha($credentials['smart-token'])) {
        return back()->withErrors([
          'smart-token' => 'Капча нне пройдена',
        ]);
      }

      $loginIsEmail = Validator::make($request->all(), ['login' => 'required|email'])->errors()->first('login') == "";
      $loginIsPhone = Validator::make($request->all(), ['login' => 'required|min:11|numeric'])->errors()->first('login') == "";

      if ($loginIsEmail && Auth::attempt(['email' => $credentials['login'], 'password' => $credentials['password']])) {
        $request->session()->regenerate();
        return redirect()->intended('profile');
      }

      $user = User::where('phone', $credentials['login'])->first();
      if ($loginIsPhone && $user !== null) {
        if (Auth::attempt(['email' => $user->email, 'password' => $credentials['password']])) {
          $request->session()->regenerate();
          return redirect()->intended('profile');
        }
      }

      return back()->withErrors([
          'login' => 'Пользователь с такими данными не найден',
      ]);
  }
  public function logout(Request $request) {
      Auth::logout();
      $request->session()->invalidate();
      $request->session()->regenerateToken();
      return redirect('/');
  }

  private function checkCaptcha($token) {
    $ch = curl_init();
    $args = http_build_query([
        "secret" => 'ysc2_oyGghbIPWoWEck9uW5QNrbgplbOnDnw7PlSZL4G4999854dc',
        "token" => $token,
        "ip" => $_SERVER['REMOTE_ADDR'], // Нужно передать IP пользователя.
                                         // Как правильно получить IP зависит от вашего прокси.
    ]);
    curl_setopt($ch, CURLOPT_URL, "https://captcha-api.yandex.ru/validate?$args");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 1);

    $server_output = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpcode !== 200) {
        echo "Allow access due to an error: code=$httpcode; message=$server_output\n";
        return true;
    }
    $resp = json_decode($server_output);
    return $resp->status === "ok";
  }
}
