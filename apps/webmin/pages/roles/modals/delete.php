@section('segments')
@parent
<modal id="delete-role-modal" type="center">
  <div class="modal-header">
    <h4 class="modal-title">Delete Role</h4>
  </div>
  <div class="modal-body">
    <div class="group">Are you sure you would like to delete <b>{{role.name}}</b>? This action can not be undone if performed.</div>
    <div class="group">
      <label>Reason for Delete<small class="required">*</small>:</label>
      <textarea class="controls" rows="5" value="{{change_log.comment}}"></textarea>
    </div>
  </div>
  <div class="modal-footer">
    <button class="btn primary outline" target="delete-role-modal" on-click="modal.close">Close</button>
    <button class="btn primary" on-click="onPressDeleteRole">Delete</button>
  </div>
</modal>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Data.set('change_log', null)

  $Event.on('delete-role-modal.open', () => {
    $Data.set('change_log.method', 'delete')
    $Data.set('change_log.type', 'role.delete')
    $Data.set('change_log.user_id', $Data.get('me.id'))
    $Data.set('change_log.record_id', $Data.get('role.id'))
  })

  $Event.on('onPressDeleteRole', () => {
    var params = {
      role: $Data.get('role'),
      change_log: $Data.get('change_log'),
    }
    $Api.delete('<%ADMIN_URL%>/api/roles/delete').params(params).send()
  })

  $Event.on('delete-role-modal.close', () => {
    $Data.set('role', {})
    $Data.set('change_log.comment', '')
  })
</script>
@endsection