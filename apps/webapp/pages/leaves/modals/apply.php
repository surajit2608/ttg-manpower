@section('segments')
@parent
<modal id="apply-leave-modal" type="right">
  <div class="modal-header">
    <h4 class="title">{{leave.id ? 'Edit' : 'Add'}} Leave</h4>
  </div>
  <div class="modal-body">
    <div class="group">
      <label>Leave<small class="required">*</small>:</label>
      <dropdown options="{{options_holidays}}" value="{{leave.holiday_id}}" placeholder="Choose Holiday" on-enter="onPressSaveLeave" />
    </div>
    <div class="group">
      <label>Message<small class="required">*</small>:</label>
      <textarea class="controls" rows="4" value="{{leave.message}}" on-enter="onPressSaveLeave"></textarea>
    </div>
    <div class="h-px-100"></div>
  </div>
  <div class="modal-footer">
    <button class="btn primary outline" target="apply-leave-modal" on-click="modal.close">Close</button>
    <button class="btn primary" on-click="onPressSaveLeave">Save</button>
  </div>
</modal>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Event.on('apply-leave-modal.open', () => {
    $Api.get('<%SITE_URL%>/api/holidays/options').send()
  })

  $Event.on('onPressSaveLeave', () => {
    var params = $Data.get('leave')
    $Api.post('<%SITE_URL%>/api/leaves/save').params(params).send()
  })

  $Event.on('apply-leave-modal.close', () => {
    $Data.set('leave', {})
  })
</script>
@endsection