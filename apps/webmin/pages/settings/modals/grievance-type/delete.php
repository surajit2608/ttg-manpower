@section('segments')
@parent
<modal id="delete-grievance-type-modal" type="center">
  <div class="modal-header">
    <h4 class="modal-title">Delete Grievance Type</h4>
  </div>
  <div class="modal-body">
    <div class="group">Are you sure you would like to delete <b>{{grievance_type.name}}</b>? This action can not be undone if performed.</div>
    <div class="group">
      <label>Reason for Delete<small class="required">*</small>:</label>
      <textarea class="controls" rows="5" value="{{change_log.comment}}"></textarea>
    </div>
  </div>
  <div class="modal-footer">
    <button class="btn primary outline" target="delete-grievance-type-modal" on-click="modal.close">Close</button>
    <button class="btn primary" on-click="onPressDeletedGrievanceType">Delete</button>
  </div>
</modal>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Data.set('change_log', null)

  $Event.on('delete-grievance-type-modal.open', () => {
    $Data.set('change_log.method', 'delete')
    $Data.set('change_log.type', 'settings.grievance.delete')
    $Data.set('change_log.user_id', $Data.get('me.id'))
    $Data.set('change_log.record_id', $Data.get('grievance_type.id'))
  })

  $Event.on('onPressDeletedGrievanceType', () => {
    var params = {
      grievance_type: $Data.get('grievance_type'),
      change_log: $Data.get('change_log'),
    }
    $Api.delete('<%ADMIN_URL%>/api/grievance-types/delete').params(params).send()
  })

  $Event.on('delete-grievance-type-modal.close', () => {
    $Data.set('grievance_type', {})
    $Data.set('change_log.comment', '')
  })
</script>
@endsection