<div class="col-xs-12 col-sm-12 col-md-6">
  <div class="group">
    <label>First Name<small class="required">*</small>:</label>
    <input class="controls" type="text" value="{{me.first_name}}" on-enter="onPressSaveProfile" />
  </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-6">
  <div class="group">
    <label>Last Name<small class="required">*</small>:</label>
    <input class="controls" type="text" value="{{me.last_name}}" on-enter="onPressSaveProfile" />
  </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12">
  <div class="group">
    <label>User Image<small class="required">*</small>:</label>
    <div class="d-flex">
      <fancy-upload class="flex-1 m-0" value="{{me.image}}" folder="users" filename="dp" exts="image/png,image/jpeg,image/gif" size="5">
        <button class="btn primary outline block p-0_75 border-1">Browse Image</button>
      </fancy-upload>
      {{#if me.image}}<a target="_blank" class="btn primary p-0_75 ml-1" href="<%FULL_URL%>{{me.image}}"><i class="icon-link"></i></a>{{/if}}
    </div>
  </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-6">
  <div class="group">
    <label>Email Address<small class="required">*</small>:</label>
    <input class="controls" type="text" value="{{me.email}}" on-enter="onPressSaveProfile" />
  </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-6">
  <div class="group">
    <label>Username<small class="required">*</small>:</label>
    <input class="controls" type="text" value="{{me.username}}" on-enter="onPressSaveProfile" />
  </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-6">
  <div class="group">
    <label>Phone<small class="required">*</small>:</label>
    <input type="text" class="controls" value="{{me.phone}}" on-enter="onPressSaveProfile" />
  </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-6">
  <div class="group">
    <label>Role<small class="required">*</small>:</label>
    <dropdown options="{{options_roles}}" value="{{me.role_id}}" placeholder="Choose Role" disabled="true" />
  </div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12">
  <div class="d-flex justify-content-space-between align-items-center">
    <div>
      <button class="btn primary" on-click="onPressSaveProfile">Save</button>
    </div>
    <div></div>
  </div>
</div>


@section('scripts')
@parent
<script type="text/javascript">
  $Event.on('page.init', () => {
    if ($Data.get('tab') == 'profile') {
      $Api.get('<%ADMIN_URL%>/api/roles/options').send()
    }
  })

  $Event.on('onPressSaveProfile', () => {
    var params = $Data.get('me')
    $Api.post('<%ADMIN_URL%>/api/settings/profile/save').params(params).send()
  })
</script>
@endsection