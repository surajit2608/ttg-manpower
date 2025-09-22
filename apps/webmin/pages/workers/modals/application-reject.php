@section('segments')
@parent
<modal id="reject-worker-modal" type="center">
  <div class="modal-header">
    <h4 class="modal-title">Reject Worker</h4>
  </div>
  <div class="modal-body">
    <div class="group">Are you sure you would like to reject this worker?</div>
  </div>
  <div class="modal-footer">
    <button class="btn primary outline" target="reject-worker-modal" on-click="modal.close">Close</button>
    <button class="btn danger" on-click="onPressConfirmRejectWorker">Reject</button>
  </div>
</modal>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Event.on('onPressConfirmRejectWorker', () => {
    var params = {
      worker_id: $Data.get('worker.id'),
    }
    $Api.post('<%ADMIN_URL%>/api/applications/reject').params(params).send()
  })
</script>
@endsection