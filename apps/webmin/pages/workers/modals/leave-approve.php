@section('segments')
@parent
<modal id="approve-leave-modal" type="right">
  <div class="modal-header">
    <h4 class="modal-title">Approve Leave Application</h4>
  </div>
  <div class="modal-body">
    <div class="group">
      <label>Comment:</label>
      <textarea class="controls" rows="5" value="{{leave.comment}}"></textarea>
    </div>
    <div class="h-px-100"></div>
  </div>
  <div class="modal-footer">
    <button class="btn primary outline" target="approve-leave-modal" on-click="modal.close">Close</button>
    <button class="btn success" on-click="onPressConfirmApproveLeave">Approve</button>
  </div>
</modal>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Event.on('onPressConfirmApproveLeave', () => {
    var params = $Data.get('leave')
    $Api.post('<%ADMIN_URL%>/api/leaves/approve').params(params).send(res => {
      $Event.fire('modal.close', 'view-leave-modal')
    })
  })

  $Event.on('approve-leave-modal.close', () => {
    if(!$Data.get('leaveViewOpened')){
      $Data.set('leave', {})
    }
  })
</script>
@endsection