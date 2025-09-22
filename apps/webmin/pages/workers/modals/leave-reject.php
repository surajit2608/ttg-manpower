@section('segments')
@parent
<modal id="reject-leave-modal" type="right">
  <div class="modal-header">
    <h4 class="modal-title">Reject Leave Application</h4>
  </div>
  <div class="modal-body">
    <div class="group">
      <label>Comment:</label>
      <textarea class="controls" rows="5" value="{{leave.comment}}"></textarea>
    </div>
    <div class="h-px-100"></div>
  </div>
  <div class="modal-footer">
    <button class="btn primary outline" target="reject-leave-modal" on-click="modal.close">Close</button>
    <button class="btn danger" on-click="onPressConfirmRejectLeave">Reject</button>
  </div>
</modal>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Event.on('onPressConfirmRejectLeave', () => {
    var params = $Data.get('leave')
    $Api.post('<%ADMIN_URL%>/api/leaves/reject').params(params).send(res => {
      $Event.fire('modal.close', 'view-leave-modal')
    })
  })

  $Event.on('reject-leave-modal.close', () => {
    if (!$Data.get('leaveViewOpened')) {
      $Data.set('leave', {})
    }
  })
</script>
@endsection