@section('segments')
@parent
<modal id="add-job-modal" type="right">
  <div class="modal-header">
    <h4 class="title">{{job.id ? 'Edit' : 'Add'}} Job</h4>
  </div>
  <div class="modal-body">
    <div class="group">
      <label>Job<small class="required">*</small>:</label>
      <input class="controls" type="text" value="{{job.name}}" on-enter="onPressSaveJob" />
    </div>
    {{#if job.id}}
      <div class="group">
        <label>Reason for Change<small class="required">*</small>:</label>
        <textarea class="controls" rows="5" value="{{change_log.comment}}"></textarea>
      </div>
    {{/if}}
    <div class="h-px-100"></div>
  </div>
  <div class="modal-footer">
    <button class="btn primary outline" target="add-job-modal" on-click="modal.close">Close</button>
    <button class="btn primary" on-click="onPressSaveJob">Save</button>
  </div>
</modal>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Data.set('change_log', null)

  $Event.on('add-job-modal.open', () => {
    $Data.set('change_log.method', 'update')
    $Data.set('change_log.type', 'settings.job.update')
    $Data.set('change_log.user_id', $Data.get('me.id'))
    $Data.set('change_log.record_id', $Data.get('job.id'))
  })

  $Event.on('onPressSaveJob', () => {
    var params = {
      job: $Data.get('job'),
      change_log: $Data.get('change_log'),
    }
    $Api.post('<%ADMIN_URL%>/api/jobs/save').params(params).send()
  })

  $Event.on('add-job-modal.close', () => {
    $Data.set('job', {})
    $Data.set('change_log.comment', '')
  })
</script>
@endsection