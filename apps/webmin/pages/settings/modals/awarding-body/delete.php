@section('segments')
@parent
<modal id="delete-awarding-body-modal" type="center">
  <div class="modal-header">
    <h4 class="modal-title">Delete Awarding Body</h4>
  </div>
  <div class="modal-body">
    <div class="group">Are you sure you would like to delete <b>{{awarding_body.name}}</b>? This action can not be undone if performed.</div>
    <div class="group">
      <label>Reason for Delete<small class="required">*</small>:</label>
      <textarea class="controls" rows="5" value="{{change_log.comment}}"></textarea>
    </div>
  </div>
  <div class="modal-footer">
    <button class="btn primary outline" target="delete-awarding-body-modal" on-click="modal.close">Close</button>
    <button class="btn primary" on-click="onPressDeleteAwardingBody">Delete</button>
  </div>
</modal>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Data.set('change_log', null)

  $Event.on('delete-awarding-body-modal.open', () => {
    $Data.set('change_log.method', 'delete')
    $Data.set('change_log.type', 'settings.awarding.delete')
    $Data.set('change_log.user_id', $Data.get('me.id'))
    $Data.set('change_log.record_id', $Data.get('awarding_body.id'))
  })

  $Event.on('onPressDeleteAwardingBody', () => {
    var params = {
      awarding_body: $Data.get('awarding_body'),
      change_log: $Data.get('change_log'),
    }
    $Api.delete('<%ADMIN_URL%>/api/awarding-bodies/delete').params(params).send()
  })

  $Event.on('delete-awarding-body-modal.close', () => {
    $Data.set('awarding_body', {})
    $Data.set('change_log.comment', '')
  })
</script>
@endsection