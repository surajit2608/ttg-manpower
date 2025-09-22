@section('segments')
@parent
<modal id="add-document-type-modal" type="right">
  <div class="modal-header">
    <h4 class="title">{{document_type.id ? 'Edit' : 'Add'}} Document Type</h4>
  </div>
  <div class="modal-body">
    <div class="group">
      <label>Name<small class="required">*</small>:</label>
      <input class="controls" type="text" value="{{document_type.name}}" on-enter="onPressSaveDocumentType" />
    </div>
    {{#if document_type.id}}
      <div class="group">
        <label>Reason for Change<small class="required">*</small>:</label>
        <textarea class="controls" rows="5" value="{{change_log.comment}}"></textarea>
      </div>
    {{/if}}
    <div class="h-px-100"></div>
  </div>
  <div class="modal-footer">
    <button class="btn primary outline" target="add-document-type-modal" on-click="modal.close">Close</button>
    <button class="btn primary" on-click="onPressSaveDocumentType">Save</button>
  </div>
</modal>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Data.set('change_log', null)

  $Event.on('add-document-type-modal.open', () => {
    $Data.set('change_log.method', 'update')
    $Data.set('change_log.type', 'settings.document.update')
    $Data.set('change_log.user_id', $Data.get('me.id'))
    $Data.set('change_log.record_id', $Data.get('document_type.id'))
  })

  $Event.on('onPressSaveDocumentType', () => {
    var params = {
      document_type: $Data.get('document_type'),
      change_log: $Data.get('change_log'),
    }
    $Api.post('<%ADMIN_URL%>/api/document-types/save').params(params).send()
  })

  $Event.on('add-document-type-modal.close', () => {
    $Data.set('document_type', {})
    $Data.set('change_log.comment', '')
  })
</script>
@endsection