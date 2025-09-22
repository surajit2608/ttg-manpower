<?php

$updated = false;

$tk = Input::get('tk', 0);
$auth = Input::get('auth', 0);
$expire = Input::get('expire', 0);
$password = Input::get('token', 0);

$rawToken = $auth . $expire . $password;
$newTk = Crypto::hash($rawToken, 8);

$userId = Crypto::decrypt($auth);
$expire = Crypto::decrypt($expire);

if (time() < strtotime($expire) && $newTk == $tk) {
  $user = Worker::find($userId);
  if ($user && $user->password != $password) {
    $user->password = $password;
    $user->save();
    $updated = true;
  }
}
?>

@extends('shared.layout')
@include('shared.events', [
'page' => 'reset'
])

@include('widgets.input')
@include('widgets.message')


@section('title')
Reset Password - 
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
      <div class="empty" style="padding:2rem 0 5rem">
        @if($updated)
          <i class="icon-check-circle1"></i>
          <h4>Password Reset</h4>
        @else
          <i class="icon-block"></i>
          <h4>Invalid/Expired Link</h4>
        @endif
      </div>
    </div>
    <div class="group mb-0">
      <a href="<%SITE_URL%>/login" class="btn primary block">Click here to Login</a>
    </div>
  </div>
</div>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Event.on('page.init', () => {
    $Event.fire('hideLoading')
  })
</script>
@endsection