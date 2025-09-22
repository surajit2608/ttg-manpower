@section('segments')
@parent
<modal id="delete-holiday-modal" type="center">
  <div class="modal-header">
    <h4 class="modal-title">Delete Skill Set</h4>
  </div>
  <div class="modal-body">
    <div class="group">Are you sure you would like to delete <b>{{holiday.name}}</b>? This action can not be undone if performed.</div>
    <div class="group">
      <label>Reason for Delete<small class="required">*</small>:</label>
      <textarea class="controls" rows="5" value="{{change_log.comment}}"></textarea>
    </div>
  </div>
  <div class="modal-footer">
    <button class="btn primary outline" target="delete-holiday-modal" on-click="modal.close">Close</button>
    <button class="btn primary" on-click="onPressDeleteHoliday">Delete</button>
  </div>
</modal>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Data.set('change_log', null)

  $Event.on('delete-holiday-modal.open', () => {
    $Data.set('change_log.method', 'delete')
    $Data.set('change_log.type', 'holiday.delete')
    $Data.set('change_log.user_id', $Data.get('me.id'))
    $Data.set('change_log.record_id', $Data.get('holiday.id'))
  })

  $Event.on('onPressDeleteHoliday', () => {
    var params = {
      holiday: $Data.get('holiday'),
      change_log: $Data.get('change_log'),
    }
    $Api.delete('<%ADMIN_URL%>/api/holidays/delete').params(params).send()
  })

  $Event.on('delete-holiday-modal.close', () => {
    $Data.set('holiday', {})
    $Data.set('change_log.comment', '')
  })
</script>
@endsection