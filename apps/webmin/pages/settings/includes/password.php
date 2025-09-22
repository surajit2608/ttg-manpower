<div class="col-xs-12 col-sm-12 col-md-6">
  <div class="group">
    <label>Existing Password<small class="required">*</small>:</label>
    <input class="controls" type="password" value="{{password.old}}" on-enter="onPressSavePassword" />
  </div>
  <div class="group">
    <label>New Password<small class="required">*</small>:</label>
    <input class="controls" type="password" value="{{password.new}}" on-enter="onPressSavePassword" />
  </div>
  <div class="group">
    <label>Confirm Password<small class="required">*</small>:</label>
    <input class="controls" type="password" value="{{password.confirm}}" on-enter="onPressSavePassword" />
  </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-6">
  <div class="group">
    <label>Password Hint:</label>
    <ul>
      <li>Password must be atleast 8 characters long.</li>
      <li>Password must be alpha-numeric.</li>
      <li>Password must contains atleast one special character.</li>
      <li>Password must contains atleast one capital letter.</li>
      <li>Password must contains atleast one small letter.</li>
    </ul>
  </div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12">
  <div class="d-flex justify-content-space-between align-items-center">
    <div>
      <button class="btn primary" on-click="onPressSavePassword">Change Password</button>
    </div>
    <div></div>
  </div>
</div>


@section('scripts')
@parent
<script type="text/javascript">
  $Event.on('page.init', () => {
    if ($Data.get('tab') == 'password') {
      $Event.fire('hideLoading')
    }
  })

  $Event.on('onPressSavePassword', () => {
    var params = $Data.get('password')
    $Api.post('<%ADMIN_URL%>/api/settings/password/save').params(params).send()
  })
</script>
@endsection