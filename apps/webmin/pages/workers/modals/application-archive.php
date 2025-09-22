@section('segments')
@parent
<modal id="archive-worker-modal" type="center">
  <div class="modal-header">
    <h4 class="modal-title">Archive Worker</h4>
  </div>
  <div class="modal-body">
    <div class="group">Are you sure you would like to archive this worker?</div>
  </div>
  <div class="modal-footer">
    <button class="btn primary outline" target="archive-worker-modal" on-click="modal.close">Close</button>
    <button class="btn warning" on-click="onPressConfirmArchiveWorker">Archive</button>
  </div>
</modal>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Event.on('onPressConfirmArchiveWorker', () => {
    var params = {
      worker_id: $Data.get('worker.id'),
    }
    $Api.post('<%ADMIN_URL%>/api/applications/archive').params(params).send()
  })
</script>
@endsection