@section('segments')
@parent
<modal id="add-application-modal" type="right">
  <div class="modal-header">
    <h4 class="title">{{application.id ? 'Edit' : 'Add'}} Application</h4>
  </div>
  <div class="modal-body">
    <div class="group">
      <label>Application Title<small class="required">*</small>:</label>
      <input type="text" class="controls" value="{{application.title}}" />
    </div>
    <div class="group">
      <label>Application URL<small class="required">*</small>:</label>
      <input type="text" class="controls" value="{{application.slug}}" />
    </div>
    <div class="group">
      <label>Choose Job<small class="required">*</small>:</label>
      <dropdown options="{{options_jobs}}" value="{{application.job_id}}" placeholder="Choose Job" />
    </div>
    <div class="group">
      <label>Choose Client<small class="required">*</small>:</label>
      <dropdown options="{{options_clients}}" value="{{application.client_id}}" placeholder="Choose Client" />
    </div>
    <div class="group">
      <label>Street Address<small class="required">*</small>:</label>
      <input type="text" class="controls" value="{{application.address}}" />
    </div>
    <div class="group">
      <label>City<small class="required">*</small>:</label>
      <input type="text" class="controls" value="{{application.city}}" />
    </div>
    <div class="group">
      <label>Post Code<small class="required">*</small>:</label>
      <input type="text" class="controls" value="{{application.post_code}}" />
    </div>
    <div class="group">
      <label>Country<small class="required">*</small>:</label>
      <input type="text" class="controls" value="{{application.country}}" />
    </div>
    <div class="group">
      <label>Hourly Salary<small class="required">*</small>:</label>
      <div class="d-flex align-items-stretch">
        <span class="controls f-size-1_25 pv-0 ph-0_5 w-px-25 justify-content-center round-tr-0 round-br-0 d-flex align-items-center">&#163;</span>
        <input type="number" class="controls round-tl-0 round-bl-0" style="margin-left: -1px" value="{{application.hourly_salary}}" />
      </div>
    </div>
    {{#if application.id}}
      <div class="group">
        <label>Reason for Change<small class="required">*</small>:</label>
        <textarea class="controls" rows="5" value="{{change_log.comment}}"></textarea>
      </div>
    {{/if}}
    <div class="h-px-100"></div>
  </div>
  <div class="modal-footer">
    <button class="btn primary outline" target="add-application-modal" on-click="modal.close">Close</button>
    <button class="btn primary" on-click="onPressSaveApplication">Save</button>
  </div>
</modal>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Data.set('change_log', null)

  $Event.on('add-application-modal.open', () => {
    $Api.get('<%ADMIN_URL%>/api/jobs/options').send()
    $Api.get('<%ADMIN_URL%>/api/clients/options').send()

    $Data.set('change_log.method', 'update')
    $Data.set('change_log.type', 'application.update')
    $Data.set('change_log.user_id', $Data.get('me.id'))
    $Data.set('change_log.record_id', $Data.get('application.id'))
  })

  $Event.on('onPressSaveApplication', () => {
    var params = {
      application: $Data.get('application'),
      change_log: $Data.get('change_log'),
    }
    $Api.post('<%ADMIN_URL%>/api/applications/save').params(params).send()
  })

  $Event.on('add-application-modal.close', () => {
    $Data.set('application', {})
    $Data.set('change_log.comment', '')
  })
</script>
@endsection