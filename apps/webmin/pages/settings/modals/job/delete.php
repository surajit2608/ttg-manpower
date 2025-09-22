@section('segments')
@parent
<modal id="delete-job-modal" type="center">
  <div class="modal-header">
    <h4 class="modal-title">Delete Job</h4>
  </div>
  <div class="modal-body">
    <div class="group">Are you sure you would like to delete <b>{{job.name}}</b>? This action can not be undone if performed.</div>
    <div class="group">
      <label>Reason for Delete<small class="required">*</small>:</label>
      <textarea class="controls" rows="5" value="{{change_log.comment}}"></textarea>
    </div>
  </div>
  <div class="modal-footer">
    <button class="btn primary outline" target="delete-job-modal" on-click="modal.close">Close</button>
    <button class="btn primary" on-click="onPressDeleteJob">Delete</button>
  </div>
</modal>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Data.set('change_log', null)

  $Event.on('delete-job-modal.open', () => {
    $Data.set('change_log.method', 'delete')
    $Data.set('change_log.type', 'settings.job.delete')
    $Data.set('change_log.user_id', $Data.get('me.id'))
    $Data.set('change_log.record_id', $Data.get('job.id'))
  })

  $Event.on('onPressDeleteJob', () => {
    var params = {
      job: $Data.get('job'),
      change_log: $Data.get('change_log'),
    }
    $Api.delete('<%ADMIN_URL%>/api/jobs/delete').params(params).send()
  })

  $Event.on('delete-job-modal.close', () => {
    $Data.set('job', {})
    $Data.set('change_log.comment', '')
  })
</script>
@endsection