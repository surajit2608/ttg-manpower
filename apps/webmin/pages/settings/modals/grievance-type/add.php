@section('segments')
@parent
<modal id="add-grievance-type-modal" type="right">
  <div class="modal-header">
    <h4 class="title">{{grievance_type.id ? 'Edit' : 'Add'}} Grievance Type</h4>
  </div>
  <div class="modal-body">
    <div class="group">
      <label>Name<small class="required">*</small>:</label>
      <input class="controls" type="text" value="{{grievance_type.name}}" on-enter="onPressSaveGrievanceType" />
    </div>
    {{#if grievance_type.id}}
      <div class="group">
        <label>Reason for Change<small class="required">*</small>:</label>
        <textarea class="controls" rows="5" value="{{change_log.comment}}"></textarea>
      </div>
    {{/if}}
    <div class="h-px-100"></div>
  </div>
  <div class="modal-footer">
    <button class="btn primary outline" target="add-grievance-type-modal" on-click="modal.close">Close</button>
    <button class="btn primary" on-click="onPressSaveGrievanceType">Save</button>
  </div>
</modal>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Data.set('change_log', null)

  $Event.on('add-grievance-type-modal.open', () => {
    $Data.set('change_log.method', 'update')
    $Data.set('change_log.type', 'settings.grievance.update')
    $Data.set('change_log.user_id', $Data.get('me.id'))
    $Data.set('change_log.record_id', $Data.get('grievance_type.id'))
  })

  $Event.on('onPressSaveGrievanceType', () => {
    var params = {
      grievance_type: $Data.get('grievance_type'),
      change_log: $Data.get('change_log'),
    }
    $Api.post('<%ADMIN_URL%>/api/grievance-types/save').params(params).send()
  })

  $Event.on('add-grievance-type-modal.close', () => {
    $Data.set('grievance_type', {})
    $Data.set('change_log.comment', '')
  })
</script>
@endsection