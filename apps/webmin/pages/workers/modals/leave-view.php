@section('segments')
@parent
<modal id="view-leave-modal" type="right">
  <div class="modal-header">
    <h4 class="title">Leave Application</h4>
  </div>
  <div class="modal-body">
    <div class="group">
      <label>Leave:</label>
      <div class="controls">{{leave.holiday.name}}</div>
    </div>
    <div class="group">
      <label>Date:</label>
      <div class="controls">{{leave.holiday.date}}</div>
    </div>
    <div class="group">
      <label>Message:</label>
      <div class="controls">{{leave.message}}</div>
    </div>
    <div class="group">
      <label>Status:</label>
      <div class="controls">{{leave.status.toUpperCase()}}</div>
    </div>
    <div class="group">
      <label>Applied At:</label>
      <div class="controls">{{leave.created_at}}</div>
    </div>
    <div class="h-px-100"></div>
  </div>
  <div class="modal-footer">
    <button class="btn primary outline" target="view-leave-modal" on-click="modal.close">Close</button>
    <button class="btn danger" on-click="modal.open" target="reject-leave-modal">Reject</button>
    <button class="btn primary" on-click="modal.open" target="approve-leave-modal">Approve</button>
  </div>
</modal>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Event.on('view-leave-modal.open', () => {
    $Data.set('leaveViewOpened', true)
  })

  $Event.on('view-leave-modal.close', () => {
    $Data.set('leave', {})
    $Data.set('leaveViewOpened', false)
  })
</script>
@endsection