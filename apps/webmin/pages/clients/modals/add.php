@section('segments')
@parent
<modal id="add-client-modal" type="right">
  <div class="modal-header">
    <h4 class="title">{{client.id ? 'Edit' : 'Add'}} Client</h4>
  </div>
  <div class="modal-body">
    <div class="group">
      <label>Business Name<small class="required">*</small>:</label>
      <input class="controls" type="text" value="{{client.business_name}}" on-enter="onPressSaveClient" />
    </div>
    <div class="group">
      <label>Contact Person<small class="required">*</small>:</label>
      <input class="controls" type="text" value="{{client.contact_person}}" on-enter="onPressSaveClient" />
    </div>
    <div class="group">
      <label>Email Address<small class="required">*</small>:</label>
      <input class="controls" type="text" value="{{client.email}}" on-enter="onPressSaveClient" />
    </div>
    <div class="group">
      <label>Phone<small class="required">*</small>:</label>
      <input type="text" class="controls" value="{{client.phone}}" on-enter="onPressSaveClient" />
    </div>
    <div class="group">
      <label>Week Start:</label>
      <dropdown options="{{options_weekdays}}" value="{{client.week_start_day}}" />
    </div>
    <div class="group">
      <label>Week End:</label>
      <dropdown options="{{options_weekdays}}" value="{{client.week_end_day}}" />
    </div>
    <div class="group">
      <label>Contract Start:</label>
      <dropdown-date value="{{client.contract_start}}" />
    </div>
    <div class="group">
      <label>Contract End:</label>
      <dropdown-date value="{{client.contract_end}}" min="{{client.contract_start}}" />
    </div>
    {{#if client.id}}
      <div class="group">
        <label>Reason for Change<small class="required">*</small>:</label>
        <textarea class="controls" rows="5" value="{{change_log.comment}}"></textarea>
      </div>
    {{/if}}
    <div class="h-px-100"></div>
  </div>
  <div class="modal-footer">
    <button class="btn primary outline" target="add-client-modal" on-click="modal.close">Close</button>
    <button class="btn primary" on-click="onPressSaveClient">Save</button>
  </div>
</modal>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Data.set('change_log', null)

  $Event.on('add-client-modal.open', () => {
    $Data.set('change_log.method', 'update')
    $Data.set('change_log.type', 'client.update')
    $Data.set('change_log.user_id', $Data.get('me.id'))
    $Data.set('change_log.record_id', $Data.get('client.id'))
  })

  $Event.on('onPressSaveClient', () => {
    var params = {
      client: $Data.get('client'),
      change_log: $Data.get('change_log'),
    }
    $Api.post('<%ADMIN_URL%>/api/clients/save').params(params).send()
  })

  $Event.on('add-client-modal.close', () => {
    $Data.set('client', {})
    $Data.set('change_log.comment', '')
  })
</script>
@endsection