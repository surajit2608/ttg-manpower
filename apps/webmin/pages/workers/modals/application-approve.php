@section('segments')
@parent
<modal id="approve-worker-modal" type="center">
  <div class="modal-header">
    <h4 class="modal-title">Approve Worker</h4>
  </div>
  <div class="modal-body">
    <div class="group">Are you sure you would like to approve this worker?</div>
  </div>
  <div class="modal-footer">
    <button class="btn primary outline" target="approve-worker-modal" on-click="modal.close">Close</button>
    <button class="btn success" on-click="onPressConfirmApproveWorker">Approve</button>
  </div>
</modal>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Event.on('onPressConfirmApproveWorker', () => {
    var params = {
      worker_id: $Data.get('worker.id'),
    }
    $Api.post('<%ADMIN_URL%>/api/applications/approve').params(params).send()
  })
</script>
@endsection