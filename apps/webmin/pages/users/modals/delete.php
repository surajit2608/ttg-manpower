@section('segments')
@parent
<modal id="delete-user-modal" type="center">
  <div class="modal-header">
    <h4 class="modal-title">Delete User</h4>
  </div>
  <div class="modal-body">
    <div class="group">Are you sure you would like to delete <b>{{user.full_name}}</b>? This action can not be undone if performed.</div>
    <div class="group">
      <label>Reason for Delete<small class="required">*</small>:</label>
      <textarea class="controls" rows="5" value="{{change_log.comment}}"></textarea>
    </div>
  </div>
  <div class="modal-footer">
    <button class="btn primary outline" target="delete-user-modal" on-click="modal.close">Close</button>
    <button class="btn primary" on-click="onPressDeleteUser">Delete</button>
  </div>
</modal>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Data.set('change_log', null)

  $Event.on('delete-user-modal.open', () => {
    $Data.set('change_log.method', 'delete')
    $Data.set('change_log.type', 'user.delete')
    $Data.set('change_log.user_id', $Data.get('me.id'))
    $Data.set('change_log.record_id', $Data.get('user.id'))
  })

  $Event.on('onPressDeleteUser', () => {
    var params = {
      user: $Data.get('user'),
      change_log: $Data.get('change_log'),
    }
    $Api.delete('<%ADMIN_URL%>/api/users/delete').params(params).send()
  })

  $Event.on('delete-user-modal.close', () => {
    $Data.set('user', {})
    $Data.set('change_log.comment', '')
  })
</script>
@endsection