@section('segments')
@parent
<modal id="delete-document-type-modal" type="center">
  <div class="modal-header">
    <h4 class="modal-title">Delete Document Type</h4>
  </div>
  <div class="modal-body">
    <div class="group">Are you sure you would like to delete <b>{{document_type.name}}</b>? This action can not be undone if performed.</div>
    <div class="group">
      <label>Reason for Delete<small class="required">*</small>:</label>
      <textarea class="controls" rows="5" value="{{change_log.comment}}"></textarea>
    </div>
  </div>
  <div class="modal-footer">
    <button class="btn primary outline" target="delete-document-type-modal" on-click="modal.close">Close</button>
    <button class="btn primary" on-click="onPressDeletedDocumentType">Delete</button>
  </div>
</modal>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Data.set('change_log', null)

  $Event.on('delete-document-type-modal.open', () => {
    $Data.set('change_log.method', 'delete')
    $Data.set('change_log.type', 'settings.document.delete')
    $Data.set('change_log.user_id', $Data.get('me.id'))
    $Data.set('change_log.record_id', $Data.get('document_type.id'))
  })

  $Event.on('onPressDeletedDocumentType', () => {
    var params = {
      document_type: $Data.get('document_type'),
      change_log: $Data.get('change_log'),
    }
    $Api.delete('<%ADMIN_URL%>/api/document-types/delete').params(params).send()
  })

  $Event.on('delete-document-type-modal.close', () => {
    $Data.set('document_type', {})
    $Data.set('change_log.comment', '')
  })
</script>
@endsection