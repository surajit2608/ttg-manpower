@section('segments')
@parent
<modal id="add-holiday-modal" type="right">
  <div class="modal-header">
    <h4 class="title">{{holiday.id ? 'Edit' : 'Add'}} Skill Set</h4>
  </div>
  <div class="modal-body">
    <div class="group">
      <label>Name<small class="required">*</small>:</label>
      <input class="controls" type="text" value="{{holiday.name}}" on-enter="onPressSaveHoliday" />
    </div>
    <div class="group">
      <label>Date<small class="required">*</small>:</label>
      <dropdown-date value="{{holiday.date}}" />
    </div>
    {{#if holiday.id}}
      <div class="group">
        <label>Reason for Change<small class="required">*</small>:</label>
        <textarea class="controls" rows="5" value="{{change_log.comment}}"></textarea>
      </div>
    {{/if}}
    <div class="h-px-100"></div>
  </div>
  <div class="modal-footer">
    <button class="btn primary outline" target="add-holiday-modal" on-click="modal.close">Close</button>
    <button class="btn primary" on-click="onPressSaveHoliday">Save</button>
  </div>
</modal>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Data.set('change_log', null)

  $Event.on('add-holiday-modal.open', () => {
    $Data.set('change_log.method', 'update')
    $Data.set('change_log.type', 'holiday.update')
    $Data.set('change_log.user_id', $Data.get('me.id'))
    $Data.set('change_log.record_id', $Data.get('holiday.id'))
  })

  $Event.on('onPressSaveHoliday', () => {
    var params = {
      holiday: $Data.get('holiday'),
      change_log: $Data.get('change_log'),
    }
    $Api.post('<%ADMIN_URL%>/api/holidays/save').params(params).send()
  })

  $Event.on('add-holiday-modal.close', () => {
    $Data.set('holiday', {})
    $Data.set('change_log.comment', '')
  })
</script>
@endsection