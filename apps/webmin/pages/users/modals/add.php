@section('segments')
@parent
<modal id="add-user-modal" type="right">
  <div class="modal-header">
    <h4 class="title">{{user.id ? 'Edit' : 'Add'}} User</h4>
  </div>
  <div class="modal-body">
    <div class="group">
      <label>First Name<small class="required">*</small>:</label>
      <input class="controls" type="text" value="{{user.first_name}}" on-enter="onPressSaveUser" />
    </div>
    <div class="group">
      <label>Last Name<small class="required">*</small>:</label>
      <input class="controls" type="text" value="{{user.last_name}}" on-enter="onPressSaveUser" />
    </div>
    <div class="group">
      <label>User Image<small class="required">*</small>:</label>
      <div class="d-flex">
        <fancy-upload class="flex-1 m-0" value="{{user.image}}" folder="users" filename="dp" exts="image/png,image/jpeg,image/gif" size="5">
          <button class="btn primary outline block p-0_75 border-1">Browse Image</button>
        </fancy-upload>
        {{#if user.image}}<a target="_blank" class="btn primary p-0_75 ml-1" href="<%FULL_URL%>{{user.image}}"><i class="icon-link"></i></a>{{/if}}
      </div>
    </div>
    <div class="group">
      <label>Email Address<small class="required">*</small>:</label>
      <input class="controls" type="text" value="{{user.email}}" on-enter="onPressSaveUser" />
    </div>
    <div class="group">
      <label>Username<small class="required">*</small>:</label>
      <input class="controls" type="text" value="{{user.username}}" on-enter="onPressSaveUser" />
    </div>
    {{#if !user.id}}
      <div class="group">
        <label>Password<small class="required">*</small>:</label>
        <input class="controls" type="password" value="{{user.password}}" on-enter="onPressSaveUser" />
      </div>
    {{/if}}
    <div class="group">
      <label>Phone<small class="required">*</small>:</label>
      <input type="text" class="controls" value="{{user.phone}}" on-enter="onPressSaveUser" />
    </div>
    <div class="group">
      <label>Role<small class="required">*</small>:</label>
      <dropdown options="{{options_roles}}" value="{{user.role_id}}" placeholder="Choose Role" />
    </div>
    {{#if user.id}}
      <div class="group">
        <label>Reason for Change<small class="required">*</small>:</label>
        <textarea class="controls" rows="5" value="{{change_log.comment}}"></textarea>
      </div>
    {{/if}}
    <div class="h-px-100"></div>
  </div>
  <div class="modal-footer">
    <button class="btn primary outline" target="add-user-modal" on-click="modal.close">Close</button>
    <button class="btn primary" on-click="onPressSaveUser">Save</button>
  </div>
</modal>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Data.set('change_log', null)

  $Event.on('add-user-modal.open', () => {
    $Api.get('<%ADMIN_URL%>/api/roles/options').send()

    $Data.set('change_log.method', 'update')
    $Data.set('change_log.type', 'user.update')
    $Data.set('change_log.user_id', $Data.get('me.id'))
    $Data.set('change_log.record_id', $Data.get('user.id'))
  })

  $Event.on('onPressSaveUser', () => {
    var params = {
      user: $Data.get('user'),
      change_log: $Data.get('change_log'),
    }
    $Api.post('<%ADMIN_URL%>/api/users/save').params(params).send()
  })

  $Event.on('add-user-modal.close', () => {
    $Data.set('user', {})
    $Data.set('change_log.comment', '')
  })
</script>
@endsection