@section('segments')
@parent
<modal id="assign-worker-modal" type="right">
  <div class="modal-header">
    <h4 class="modal-title">Assign Worker</h4>
  </div>
  <div class="modal-body o-visible">
    <div class="group">Assigning <b>{{worker.account_name}}</b> to <b>{{application.title}}</b></div>
    <div class="group">
      <label>Selected Dates:</label>
      {{#each worker._availabilities}}
        {{#if checked}}
          <b class="d-inline-block t-align-center mr-0_5 mb-0_5 p-0_5 bg-primary color-white round-0_25">{{day.toUpperCase()}}<br />{{date}}</b>
        {{/if}}
      {{/each}}
    </div>
    <div class="group">
      <label>Shift Start Time<small class="required">*</small>:</label>
      <dropdown-time value="{{worker.shift_start_time}}" placeholder="Choose Shift Time" />
    </div>
    <div class="group">
      <label>Shift End Time<small class="required">*</small>:</label>
      <dropdown-time value="{{worker.shift_end_time}}" placeholder="Choose Shift Time" />
    </div>
    <div class="group">
      <label>Reason for Change<small class="required">*</small>:</label>
      <textarea class="controls" rows="5" value="{{change_log.comment}}"></textarea>
    </div>
  </div>
  <div class="modal-footer">
    <button class="btn primary outline" target="assign-worker-modal" on-click="modal.close">Close</button>
    <button class="btn primary" on-click="onPressAssignWorker">Assign Worker</button>
  </div>
</modal>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Data.set('change_log', null)

  $Event.on('assign-worker-modal.open', () => {
    $Data.set('worker.shift_start_time', $Data.get('assign.shift_start_time'))
    $Data.set('worker.shift_end_time', $Data.get('assign.shift_end_time'))

    $Data.set('change_log.method', 'update')
    $Data.set('change_log.type', 'worker.assignment')
    $Data.set('change_log.user_id', $Data.get('me.id'))
    $Data.set('change_log.record_id', $Data.get('worker.id'))
  })

  $Event.on('onPressAssignWorker', () => {
    var params = {
      worker_id: $Data.get('worker.id'),
      shift_start_time: $Data.get('worker.shift_start_time'),
      shift_end_time: $Data.get('worker.shift_end_time'),
      application_id: $Data.get('assign.application_id'),
      availabilities: $Data.get('worker._availabilities'),
      change_log: $Data.get('change_log'),
    }
    $Api.post('<%ADMIN_URL%>/api/workers/assign').params(params).send()
  })

  $Event.on('assign-worker-modal.close', () => {
    $Data.set('worker', {})
    $Data.set('change_log.comment', '')
  })
</script>
@endsection