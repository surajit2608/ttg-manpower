@section('segments')
@parent
<modal id="delete-leave-modal" type="center">
  <div class="modal-header">
    <h4 class="modal-title">Delete Leave Application</h4>
  </div>
  <div class="modal-body">
    <div class="group">Are you sure you would like to delete leave application for <b>{{leave.holiday.name}}</b>? This action can not be undone if performed.</div>
  </div>
  <div class="modal-footer">
    <button class="btn primary outline" target="delete-leave-modal" on-click="modal.close">Close</button>
    <button class="btn primary" on-click="onPressDeleteLeave">Delete</button>
  </div>
</modal>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Event.on('onPressDeleteLeave', () => {
    var params = $Data.get('leave')
    $Api.delete('<%SITE_URL%>/api/leaves/delete').params(params).send()
  })

  $Event.on('delete-leave-modal.close', () => {
    $Data.set('leave', {})
  })
</script>
@endsection