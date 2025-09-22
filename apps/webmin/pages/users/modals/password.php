@section('segments')
@parent
<modal id="password-user-modal" type="right">
  <div class="modal-header">
    <h4 class="title">Change Password</h4>
  </div>
  <div class="modal-body">
    <div class="group">
      <label>Password<small class="required">*</small>:</label>
      <input class="controls" type="password" value="{{user.newpassword}}" on-enter="onPressSaveUserPassword" />
    </div>
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
    <div class="group">
      <label>Reason for Change<small class="required">*</small>:</label>
      <textarea class="controls" rows="5" value="{{change_log.comment}}"></textarea>
    </div>
    <div class="h-px-100"></div>
  </div>
  <div class="modal-footer">
    <button class="btn primary outline" target="password-user-modal" on-click="modal.close">Close</button>
    <button class="btn primary" on-click="onPressSaveUserPassword">Save</button>
  </div>
</modal>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Data.set('change_log', null)

  $Event.on('password-user-modal.open', () => {
    $Data.set('change_log.method', 'update')
    $Data.set('change_log.type', 'user.password')
    $Data.set('change_log.user_id', $Data.get('me.id'))
    $Data.set('change_log.record_id', $Data.get('user.id'))
  })

  $Event.on('onPressSaveUserPassword', () => {
    var params = {
      user: $Data.get('user'),
      change_log: $Data.get('change_log'),
    }
    $Api.post('<%ADMIN_URL%>/api/users/password').params(params).send()
  })

  $Event.on('password-user-modal.close', () => {
    $Data.set('user', {})
    $Data.set('change_log.comment', '')
  })
</script>
@endsection