@section('segments')
@parent
<modal id="add-training-type-modal" type="right">
  <div class="modal-header">
    <h4 class="title">{{training_type.id ? 'Edit' : 'Add'}} Training Type</h4>
  </div>
  <div class="modal-body">
    <div class="group">
      <label>Training Type<small class="required">*</small>:</label>
      <input class="controls" type="text" value="{{training_type.name}}" on-enter="onPressSaveTrainingType" />
    </div>
    {{#if training_type.id}}
      <div class="group">
        <label>Reason for Change<small class="required">*</small>:</label>
        <textarea class="controls" rows="5" value="{{change_log.comment}}"></textarea>
      </div>
    {{/if}}
    <div class="h-px-100"></div>
  </div>
  <div class="modal-footer">
    <button class="btn primary outline" target="add-training-type-modal" on-click="modal.close">Close</button>
    <button class="btn primary" on-click="onPressSaveTrainingType">Save</button>
  </div>
</modal>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Data.set('change_log', null)

  $Event.on('add-training-type-modal.open', () => {
    $Data.set('change_log.method', 'update')
    $Data.set('change_log.type', 'settings.training.update')
    $Data.set('change_log.user_id', $Data.get('me.id'))
    $Data.set('change_log.record_id', $Data.get('training_type.id'))
  })

  $Event.on('onPressSaveTrainingType', () => {
    var params = {
      training_type: $Data.get('training_type'),
      change_log: $Data.get('change_log'),
    }
    $Api.post('<%ADMIN_URL%>/api/training-types/save').params(params).send()
  })

  $Event.on('add-training-type-modal.close', () => {
    $Data.set('training_type', {})
    $Data.set('change_log.comment', '')
  })
</script>
@endsection