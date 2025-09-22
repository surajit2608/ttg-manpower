@extends('shared.layout')
@include('shared.events', [
'page' => 'login'
])


@include('widgets.input')
@include('widgets.modal')
@include('widgets.message')


@section('title')
Admin Login -
@endsection


@section('styles')
@parent
<style type="text/css">
  .login-form {
    width: 400px;
    box-shadow: 0 0 5px -2px rgba(0, 0, 0, 0.15);
  }
</style>
@endsection


@section('content')
<div class="content h-100 align-items-center justify-content-center">
  <div class="login-form p-2 bg-white border-1 round-0_25">
    <div class="t-align-center mb-2">
      <img src="<%SITE_URL%>/assets/images/logo.png" alt="<%SITE_TITLE%>" width="75%" />
    </div>
    <div class="group">
      <label for="username">Username: </label>
      <input type="text" class="controls" id="username" value="{{username}}" autofocus on-enter="onPressLogin" />
    </div>
    <div class="group">
      <label for="password">Password: </label>
      <div class="relative d-flex align-items-center">
        <input type="{{showPassword ? 'text' : 'password'}}" class="controls" id="password" value="{{password}}" on-enter="onPressLogin" />
        <a on-click="@this.toggle('showPassword')" class="absolute right-1"><i class-icon-eye="{{!showPassword}}" class-icon-eye-off="{{showPassword}}"></i></a>
      </div>
    </div>
    <div class="group">
      <div class="d-flex justify-content-space-between align-items-center">
        <label for="rememberme" class="f-weight-300">
          <input type="checkbox" id="rememberme" checked="{{rememberme}}" class="mr-0_5" /> Remember me
        </label>
        <a href="<%ADMIN_URL%>/password/forgot">Forgot Password</a>
      </div>
    </div>
    <div class="group mb-0">
      <button type="button" class="btn primary block" on-click="onPressLogin">Login</button>
    </div>
  </div>
</div>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Data.set('showPassword', false)

  $Event.on('page.init', () => {
    $Event.fire('hideLoading')

    $Data.set('username', getCookie('_mpwr_usr_name'))
    $Data.set('password', getCookie('_mpwr_usr_pass'))
    if ($Data.get('username') && $Data.get('password')) {
      $Data.set('rememberme', true)
    }
  })

  $Event.on('onPressLogin', () => {
    var params = {
      username: $Data.get('username'),
      password: $Data.get('password'),
      rememberme: $Data.get('rememberme'),
      tz_offset: (new Date()).getTimezoneOffset() * 60,
    };
    $Api.post('<%ADMIN_URL%>/api/users/login').params(params).send()
  })
</script>
@endsection