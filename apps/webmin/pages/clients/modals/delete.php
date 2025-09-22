@section('segments')
@parent
<modal id="delete-client-modal" type="center">
  <div class="modal-header">
    <h4 class="modal-title">Delete Client</h4>
  </div>
  <div class="modal-body">
    <div class="group">Are you sure you would like to delete <b>{{client.business_name}}</b>? This action can not be undone if performed.</div>
    <div class="group">
      <label>Reason for Delete<small class="required">*</small>:</label>
      <textarea class="controls" rows="5" value="{{change_log.comment}}"></textarea>
    </div>
  </div>
  <div class="modal-footer">
    <button class="btn primary outline" target="delete-client-modal" on-click="modal.close">Close</button>
    <button class="btn primary" on-click="onPressDeleteClient">Delete</button>
  </div>
</modal>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Data.set('change_log', null)

  $Event.on('delete-client-modal.open', () => {
    $Data.set('change_log.method', 'delete')
    $Data.set('change_log.type', 'client.delete')
    $Data.set('change_log.user_id', $Data.get('me.id'))
    $Data.set('change_log.record_id', $Data.get('client.id'))
  })

  $Event.on('onPressDeleteClient', () => {
    var params = {
      client: $Data.get('client'),
      change_log: $Data.get('change_log'),
    }
    $Api.delete('<%ADMIN_URL%>/api/clients/delete').params(params).send()
  })

  $Event.on('delete-client-modal.close', () => {
    $Data.set('client', {})
    $Data.set('change_log.comment', '')
  })
</script>
@endsection