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
      <fancy-upload class="flex-1 m-0" value="{{document.document}}" folder="applications/documents" filename="document" exts="image/png,image/jpeg,image/gif" size="5">
        <button class="btn primary outline block p-0_75 border-1">Browse Document</button>
      </fancy-upload>
    </div>
    <div class="h-px-100"></div>
  </div>
  <div class="modal-footer">
    <button class="btn primary outline" target="add-document-modal" on-click="modal.close">Close</button>
    <button class="btn primary" on-click="onPressSaveDocument" disabled="{{worker.status == 'active'}}">Save</button>
  </div>
</modal>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Event.on('add-document-modal.open', () => {
    $Api.get('<%ADMIN_URL%>/api/document-types/options').send()

    if (!$Data.get('document.worker_id')) {
      $Data.set('document.worker_id', $Data.get('me.id'))
    }
  })

  $Event.on('onPressSaveDocument', () => {
    if ($Data.get('worker.status') == 'active') return
    var params = $Data.get('document')
    $Api.post('<%ADMIN_URL%>/api/documents/save').params(params).send()
  })

  $Event.on('add-document-modal.close', () => {
    $Data.set('document', {})
  })
</script>
@endsection