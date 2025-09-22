@section('segments')
@parent
<modal id="add-document-modal" type="right">
  <div class="modal-header">
    <h4 class="title">Add Document</h4>
  </div>
  <div class="modal-body">
    <div class="group">
      <label>Document Type<small class="required">*</small>:</label>
      <dropdown options="{{options_document_types}}" value="{{document.document_type_id}}" />
    </div>
    <div class="group">
      <div class="d-flex">
        <fancy-upload class="flex-1 m-0" value="{{document.document}}" folder="applications/documents" filename="document" exts="image/png,image/jpeg,image/gif" size="5">
          <button class="btn primary outline block p-0_75 border-1">Browse Document</button>
        </fancy-upload>
        {{#if document.document}}
          <a target="_blank" class="btn primary p-0_75 ml-1" href="<%FULL_URL%>{{document.document}}"><i class="icon-link"></i></a>
        {{/if}}
      </div>
    </div>
    <div class="group">
      <label>Reason for Change<small class="required">*</small>:</label>
      <textarea class="controls" rows="5" value="{{change_log.comment}}"></textarea>
    </div>
    <div class="h-px-100"></div>
  </div>
  <div class="modal-footer">
    <button class="btn primary outline" target="add-document-modal" on-click="modal.close">Close</button>
    <button class="btn primary" on-click="onPressSaveDocument">Save</button>
  </div>
</modal>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Data.set('change_log', null)

  $Event.on('add-document-modal.open', () => {
    $Api.get('<%ADMIN_URL%>/api/document-types/options').send()

    if (!$Data.get('document.worker_id')) {
      $Data.set('document.worker_id', $Data.get('worker.id'))
    }

    $Data.set('change_log.method', 'update')
    $Data.set('change_log.type', 'worker.documents')
    $Data.set('change_log.user_id', $Data.get('me.id'))
    $Data.set('change_log.record_id', $Data.get('worker.id'))
  })

  $Event.on('onPressSaveDocument', () => {
    var params = {
      document: $Data.get('document'),
      change_log: $Data.get('change_log'),
    }
    $Api.post('<%ADMIN_URL%>/api/applications/documents/save').params(params).send()
  })

  $Event.on('add-document-modal.close', () => {
    $Data.set('document', {})
    $Data.set('change_log.comment', '')
  })
</script>
@endsection