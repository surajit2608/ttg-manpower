<div class="col-xs-12 col-sm-12 col-md-12">
  <div class="group">
    <fancy-upload value="{{company.logo}}" folder="logos" filename="logo" exts="image/png,image/jpeg,image/gif" size="5" disabled="{{me.permission.settings_module.update == 'Deny'}}">
      <button class="btn primary outline block pv-0_75 ph-1 border-1">Upload Company Logo</button>
    </fancy-upload>
    {{#if company.logo}}
      <div class="group t-align-center">
        <img src="{{company.logo}}" alt="{{company.name}}" height="50" class="border-1 mt-1" />
      </div>
    {{/if}}
  </div>
  <div class="group">
    <label>Name<small class="required">*</small>:</label>
    <input class="controls" type="text" value="{{company.name}}" on-enter="onPressSaveCompany" disabled="{{me.permission.settings_module.update == 'Deny'}}" />
  </div>
  <div class="group">
    <label>Address<small class="required">*</small>:</label>
    <textarea class="controls" rows="5" value="{{company.address}}" on-enter="onPressSaveCompany" disabled="{{me.permission.settings_module.update == 'Deny'}}"></textarea>
  </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-6">
  <div class="group">
    <label>City<small class="required">*</small>:</label>
    <input class="controls" type="text" value="{{company.city}}" on-enter="onPressSaveCompany" disabled="{{me.permission.settings_module.update == 'Deny'}}" />
  </div>
  <div class="group">
    <label>Phone<small class="required">*</small>:</label>
    <input type="text" class="controls" value="{{company.phone}}" on-enter="onPressSaveCompany" disabled="{{me.permission.settings_module.update == 'Deny'}}" />
  </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-6">
  <div class="group">
    <label>Postal Code<small class="required">*</small>:</label>
    <input class="controls" type="text" value="{{company.postal}}" on-enter="onPressSaveCompany" disabled="{{me.permission.settings_module.update == 'Deny'}}" />
  </div>
  <div class="group">
    <label>Fax:</label>
    <input class="controls" type="text" value="{{company.fax}}" on-enter="onPressSaveCompany" disabled="{{me.permission.settings_module.update == 'Deny'}}" />
  </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12">
  <div class="group">
    <label>Email Address<small class="required">*</small>:</label>
    <input class="controls" type="email" value="{{company.email}}" on-enter="onPressSaveCompany" disabled="{{me.permission.settings_module.update == 'Deny'}}" />
  </div>
  <div class="group">
    <label>Website:</label>
    <input class="controls" type="text" value="{{company.website}}" on-enter="onPressSaveCompany" disabled="{{me.permission.settings_module.update == 'Deny'}}" />
  </div>
  <div class="group">
    <label>Contact Person<small class="required">*</small>:</label>
    <dropdown options="{{options_users}}" value="{{company.user_id}}" placeholder="Choose Contact Person" disabled="{{me.permission.settings_module.update == 'Deny'}}" />
  </div>
</div>

{{#if me.permission.settings_module.update == 'Allow'}}
  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="group">
      <label>Reason for Change<small class="required">*</small>:</label>
      <textarea class="controls" rows="5" value="{{change_log.comment}}"></textarea>
    </div>
  </div>

  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="d-flex justify-content-space-between align-items-center">
      <div>
        <button class="btn primary" on-click="onPressSaveCompany">Save</button>
      </div>
      <div></div>
    </div>
  </div>
{{/if}}


@section('scripts')
@parent
<script type="text/javascript">
  $Data.set('change_log', null)

  $Event.on('page.init', () => {
    if ($Data.get('tab') == 'company') {
      $Api.get('<%ADMIN_URL%>/api/users/options').send()
      $Api.get('<%ADMIN_URL%>/api/settings/company/get').send()

      $Data.set('change_log.method', 'update')
      $Data.set('change_log.type', 'settings.company.update')
      $Data.set('change_log.user_id', $Data.get('me.id'))
      $Data.set('change_log.record_id', $Data.get('company.id'))
    }
  })

  $Event.on('onPressSaveCompany', () => {
    var params = {
      company: $Data.get('company'),
      change_log: $Data.get('change_log'),
    }
    $Api.post('<%ADMIN_URL%>/api/settings/company/save').params(params).send()
  })
</script>
@endsection