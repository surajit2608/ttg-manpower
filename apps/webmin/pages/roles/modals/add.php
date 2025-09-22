@section('segments')
@parent
<modal id="add-role-modal" type="right">
  <div class="modal-header">
    <h4 class="title">{{role.id ? 'Edit' : 'Add'}} Role</h4>
  </div>
  <div class="modal-body">
    <div class="group">
      <label>Name<small class="required">*</small>:</label>
      <input class="controls" type="text" value="{{role.name}}" on-enter="onPressSaveRole" />
    </div>
    <div class="group">
      <label>Permissions<small class="required">*</small>:</label>
      <table class="table bordered striped">
        {{#each role.permissions:i}}
          <thead>
            <tr>
              <th colspan="2">{{name}}</th>
              <th><input type="radio" name="module_{{i}}" value="Allow" checked="{{value=='Allow'}}" on-click="onCheckModule" /> Allow</th>
              <th><input type="radio" name="module_{{i}}" value="Deny" checked="{{value=='Deny'}}" on-click="onCheckModule" /> Deny</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="border-right-0"></td>
              <td>Read</td>
              <td><input type="radio" name="module_{{i}}_read" value="Allow" checked="{{read=='Allow'}}" key="read" on-click="onCheckSubModule" /> Allow</td>
              <td><input type="radio" name="module_{{i}}_read" value="Deny" checked="{{read=='Deny'}}" key="read" on-click="onCheckSubModule" /> Deny</td>
            </tr>
            <tr>
              <td class="border-right-0"></td>
              <td>Create</td>
              <td><input type="radio" name="module_{{i}}_create" value="Allow" checked="{{create=='Allow'}}" key="create" on-click="onCheckSubModule" /> Allow</td>
              <td><input type="radio" name="module_{{i}}_create" value="Deny" checked="{{create=='Deny'}}" key="create" on-click="onCheckSubModule" /> Deny</td>
            </tr>
            <tr>
              <td class="border-right-0"></td>
              <td>Update</td>
              <td><input type="radio" name="module_{{i}}_update" value="Allow" checked="{{update=='Allow'}}" key="update" on-click="onCheckSubModule" /> Allow</td>
              <td><input type="radio" name="module_{{i}}_update" value="Deny" checked="{{update=='Deny'}}" key="update" on-click="onCheckSubModule" /> Deny</td>
            </tr>
            <tr>
              <td class="border-right-0"></td>
              <td>Delete</td>
              <td><input type="radio" name="module_{{i}}_remove" value="Allow" checked="{{remove=='Allow'}}" key="remove" on-click="onCheckSubModule" /> Allow</td>
              <td><input type="radio" name="module_{{i}}_remove" value="Deny" checked="{{remove=='Deny'}}" key="remove" on-click="onCheckSubModule" /> Deny</td>
            </tr>
          </tbody>
        {{/each}}
      </table>
    </div>
    {{#if role.id}}
      <div class="group">
        <label>Reason for Change<small class="required">*</small>:</label>
        <textarea class="controls" rows="5" value="{{change_log.comment}}"></textarea>
      </div>
    {{/if}}
    <div class="h-px-100"></div>
  </div>
  <div class="modal-footer">
    <button class="btn primary outline" target="add-role-modal" on-click="modal.close">Close</button>
    <button class="btn primary" on-click="onPressSaveRole">Save</button>
  </div>
</modal>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Data.set('change_log', null)

  $Event.on('add-role-modal.open', () => {
    if (!$Data.get('role.permissions') || !$Data.get('role.permissions').length) {
      $Data.set('role.permissions', [{
          name: "Worker Module",
          value: "Allow",
          create: "Allow",
          read: "Allow",
          update: "Allow",
          remove: "Allow",
        },
        {
          name: "Client Module",
          value: "Allow",
          create: "Allow",
          read: "Allow",
          update: "Allow",
          remove: "Allow",
        },
        {
          name: "User Module",
          value: "Allow",
          create: "Allow",
          read: "Allow",
          update: "Allow",
          remove: "Allow",
        },
        {
          name: "Role Module",
          value: "Allow",
          create: "Allow",
          read: "Allow",
          update: "Allow",
          remove: "Allow",
        },
        {
          name: "Application Module",
          value: "Allow",
          create: "Allow",
          read: "Allow",
          update: "Allow",
          remove: "Allow",
        },
        {
          name: "Settings Module",
          value: "Allow",
          create: "Allow",
          read: "Allow",
          update: "Allow",
          remove: "Allow",
        },
        {
          name: "Holiday Module",
          value: "Allow",
          create: "Allow",
          read: "Allow",
          update: "Allow",
          remove: "Allow",
        },
        {
          name: "Leave Module",
          value: "Allow",
          create: "Allow",
          read: "Allow",
          update: "Allow",
          remove: "Allow",
        },
        {
          name: "Attendance Module",
          value: "Allow",
          create: "Allow",
          read: "Allow",
          update: "Allow",
          remove: "Allow",
        },
      ])
    }

    $Data.set('change_log.method', 'update')
    $Data.set('change_log.type', 'role.update')
    $Data.set('change_log.user_id', $Data.get('me.id'))
    $Data.set('change_log.record_id', $Data.get('role.id'))
  })

  $Event.on('onCheckModule', (e) => {
    e.set('value', e.node.attrs('value'))
    e.set('create', e.node.attrs('value'))
    e.set('read', e.node.attrs('value'))
    e.set('update', e.node.attrs('value'))
    e.set('remove', e.node.attrs('value'))
  })

  $Event.on('onCheckSubModule', (e) => {
    var key = e.node.attrs('key')
    var value = e.node.attrs('value')
    e.set(key, value)

    var create = e.get('create')
    var read = e.get('read')
    var update = e.get('update')
    var remove = e.get('remove')

    if (key != 'read' && value == 'Allow') {
      e.set('read', 'Allow')
    }
    if (create == 'Deny' && read == 'Deny' && update == 'Deny' && remove == 'Deny') {
      e.set('value', 'Deny')
    }
    if (create == 'Allow' || read == 'Allow' || update == 'Allow' || remove == 'Allow') {
      e.set('value', 'Allow')
    }
  })

  $Event.on('onPressSaveRole', () => {
    var params = {
      role: $Data.get('role'),
      change_log: $Data.get('change_log'),
    }
    $Api.post('<%ADMIN_URL%>/api/roles/save').params(params).send()
  })

  $Event.on('add-role-modal.close', () => {
    $Data.set('role', {})
    $Data.set('change_log.comment', '')
  })
</script>
@endsection