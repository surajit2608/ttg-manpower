@section('segments')
@parent
<modal id="add-relationship-modal" type="right">
  <div class="modal-header">
    <h4 class="title">{{relationship.id ? 'Edit' : 'Add'}} Relationship</h4>
  </div>
  <div class="modal-body">
    <div class="group">
      <label>Relationship<small class="required">*</small>:</label>
      <input class="controls" type="text" value="{{relationship.name}}" on-enter="onPressSaveRelationship" />
    </div>
    {{#if relationship.id}}
      <div class="group">
        <label>Reason for Change<small class="required">*</small>:</label>
        <textarea class="controls" rows="5" value="{{change_log.comment}}"></textarea>
      </div>
    {{/if}}
    <div class="h-px-100"></div>
  </div>
  <div class="modal-footer">
    <button class="btn primary outline" target="add-relationship-modal" on-click="modal.close">Close</button>
    <button class="btn primary" on-click="onPressSaveRelationship">Save</button>
  </div>
</modal>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Data.set('change_log', null)

  $Event.on('add-relationship-modal.open', () => {
    $Data.set('change_log.method', 'update')
    $Data.set('change_log.type', 'settings.relationship.update')
    $Data.set('change_log.user_id', $Data.get('me.id'))
    $Data.set('change_log.record_id', $Data.get('relationship.id'))
  })

  $Event.on('onPressSaveRelationship', () => {
    var params = {
      relationship: $Data.get('relationship'),
      change_log: $Data.get('change_log'),
    }
    $Api.post('<%ADMIN_URL%>/api/relationships/save').params(params).send()
  })

  $Event.on('add-relationship-modal.close', () => {
    $Data.set('relationship', {})
    $Data.set('change_log.comment', '')
  })
</script>
@endsection