@extends('shared.layout')
@include('shared.events', [
'page' => 'forgot'
])

@include('widgets.input')
@include('widgets.modal')
@include('widgets.message')


@section('title')
Forgot Password - 
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
      <input type="text" class="controls" id="username" value="{{password.username}}" autofocus on-enter="onPressForgotPassword" />
    </div>
    <div class="group">
      <label for="new-password">New Password: </label>
      <div class="relative d-flex align-items-center">
        <input type="{{showNewPassword ? 'text' : 'password'}}" class="controls" id="new-password" value="{{password.new}}" on-enter="onPressForgotPassword" />
        <a on-click="@this.toggle('showNewPassword')" class="absolute right-1"><i class-icon-eye="{{!showNewPassword}}" class-icon-eye-off="{{showNewPassword}}"></i></a>
      </div>
    </div>
    <div class="group">
      <label for="confirm-password">Confirm Password: </label>
      <div class="relative d-flex align-items-center">
        <input type="{{showConfirmPassword ? 'text' : 'password'}}" class="controls" id="confirm-password" value="{{password.confirm}}" on-enter="onPressForgotPassword" />
        <a on-click="@this.toggle('showConfirmPassword')" class="absolute right-1"><i class-icon-eye="{{!showConfirmPassword}}" class-icon-eye-off="{{showConfirmPassword}}"></i></a>
      </div>
    </div>
    <div class="group">
      <div class="d-flex justify-content-space-between align-items-center">
        <label class="f-weight-300">Want to login?</label>
        <a href="<%SITE_URL%>/login">Click here</a>
      </div>
    </div>
    <div class="group mb-0">
      <button type="button" class="btn primary block" on-click="onPressForgotPassword">Submit</button>
    </div>
  </div>
</div>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Data.set('showNewPassword', false)
  $Data.set('showConfirmPassword', false)

  $Event.on('page.init', () => {
    $Event.fire('hideLoading')
  })

  $Event.on('onPressForgotPassword', () => {
    var params = $Data.get('password')
    $Api.post('<%SITE_URL%>/api/workers/password/forgot').params(params).send()
  })
</script>
@endsection