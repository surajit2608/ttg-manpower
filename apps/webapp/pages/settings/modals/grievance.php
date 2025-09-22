@section('segments')
@parent
<modal id="add-grievance-modal" type="right">
  <div class="modal-header">
    <h4 class="title">Add Grievance</h4>
  </div>
  <div class="modal-body">
    <div class="group">
      <label>Date<small class="required">*</small>:</label>
      <dropdown-date value="{{grievance.grievance_date}}" min="{{today}}" />
    </div>
    <div class="group">
      <label>Time<small class="required">*</small>:</label>
      <dropdown-time value="{{grievance.grievance_time}}" />
    </div>
    <div class="group">
      <label>Grievance Name<small class="required">*</small>:</label>
      <dropdown options="{{options_grievance_types}}" value="{{grievance.grievance_type_id}}" />
    </div>
    <div class="group">
      <label>Comments<small class="required">*</small>:</label>
      <textarea class="controls" rows="4" value="{{grievance.comments}}"></textarea>
    </div>
    <div class="h-px-100"></div>
  </div>
  <div class="modal-footer">
    <button class="btn primary outline" target="add-grievance-modal" on-click="modal.close">Close</button>
    <button class="btn primary" on-click="onPressSaveGrievance" disabled="{{worker.status == 'active'}}">Save</button>
  </div>
</modal>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Event.on('add-grievance-modal.open', () => {
    $Api.get('<%ADMIN_URL%>/api/grievance-types/options').send()

    if (!$Data.get('grievance.worker_id')) {
      $Data.set('grievance.worker_id', $Data.get('me.id'))
    }
  })

  $Event.on('onPressSaveGrievance', () => {
    if ($Data.get('worker.status') == 'active') return
    var params = $Data.get('grievance')
    $Api.post('<%ADMIN_URL%>/api/grievances/save').params(params).send()
  })

  $Event.on('add-grievance-modal.close', () => {
    $Data.set('grievance', {})
  })
</script>
@endsection