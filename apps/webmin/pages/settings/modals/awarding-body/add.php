@section('segments')
@parent
<modal id="add-awarding-body-modal" type="right">
  <div class="modal-header">
    <h4 class="title">{{awarding_body.id ? 'Edit' : 'Add'}} Awarding Body</h4>
  </div>
  <div class="modal-body">
    <div class="group">
      <label>Awarding Body<small class="required">*</small>:</label>
      <input class="controls" type="text" value="{{awarding_body.name}}" on-enter="onPressSaveAwardingBody" />
    </div>
    {{#if awarding_body.id}}
      <div class="group">
        <label>Reason for Change<small class="required">*</small>:</label>
        <textarea class="controls" rows="5" value="{{change_log.comment}}"></textarea>
      </div>
    {{/if}}
    <div class="h-px-100"></div>
  </div>
  <div class="modal-footer">
    <button class="btn primary outline" target="add-awarding-body-modal" on-click="modal.close">Close</button>
    <button class="btn primary" on-click="onPressSaveAwardingBody">Save</button>
  </div>
</modal>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Data.set('change_log', null)

  $Event.on('add-awarding-body-modal.open', () => {
    $Data.set('change_log.method', 'update')
    $Data.set('change_log.type', 'settings.awarding.update')
    $Data.set('change_log.user_id', $Data.get('me.id'))
    $Data.set('change_log.record_id', $Data.get('awarding_body.id'))
  })

  $Event.on('onPressSaveAwardingBody', () => {
    var params = {
      awarding_body: $Data.get('awarding_body'),
      change_log: $Data.get('change_log'),
    }
    $Api.post('<%ADMIN_URL%>/api/awarding-bodies/save').params(params).send()
  })

  $Event.on('add-awarding-body-modal.close', () => {
    $Data.set('awarding_body', {})
    $Data.set('change_log.comment', '')
  })
</script>
@endsection