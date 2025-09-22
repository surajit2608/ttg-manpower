@extends('shared.layout')
@include('shared.events')
@include('shared.header', [
'page' => 'Users',
])
@include('shared.sidebar', [
'page' => 'users',
])


@include('widgets.input')
@include('widgets.modal')
@include('widgets.upload')
@include('widgets.sorting')
@include('widgets.message')
@include('widgets.dropdown')


@include('users.modals.add')
@include('users.modals.delete')
@include('users.modals.password')


@section('title')
Users -
@endsection


@section('styles')
@parent
<style media="screen">

</style>
@endsection


@section('content')
<div class="content">
  <div class="d-flex justify-content-space-between align-items-center mb-1">
    <div>
      <div class="d-flex">
        <input class="controls ph-0_5 pv-0_25 round-tr-0 round-br-0" value="{{search}}" placeholder="Search..." on-enter="onLoadUsers" />
        {{#if search}}
          <button class="btn p-0_5 round-0 border-1" on-click="onPressClearSearch">
            <i class="icon-close"></i>
          </button>
        {{/if}}
        <button class="btn p-0_5 round-tl-0 round-bl-0 border-1" on-click="onLoadUsers">
          <i class="icon-search"></i>
        </button>
      </div>
    </div>
    <div class="d-flex">
      {{#if me.permission.role_module}}
        <a class="btn primary small round-0_25" href="<%ADMIN_URL%>/roles">
          <i class="icon-shield2"></i><span class="ml-0_5 hide-xs">Roles</span>
        </a>
      {{/if}}
      {{#if me.permission.user_module.create == 'Allow'}}
        <a class="btn primary small round-0_25 ml-0_5" on-click="modal.open" target="add-user-modal">
          <i class="icon-plus"></i><span class="ml-0_5 hide-xs">Add User</span>
        </a>
      {{/if}}
      <a class="btn primary small round-0_25 ml-0_5" href="<%ADMIN_URL%>/change-logs/?type=user"><i class="icon-info"></i></a>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table bordered striped border-0">
      <thead>
        <tr>
          <th width="100px">
            <sorting order="{{order}}" column="id" on-click="onLoadUsers">ID</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="first_name" on-click="onLoadUsers">Full Name</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="username" on-click="onLoadUsers">Username</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="email" on-click="onLoadUsers">Email Address</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="phone" on-click="onLoadUsers">Phone</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="tz_offset" on-click="onLoadUsers">Timezone</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="last_loggedin" on-click="onLoadUsers">Last Login</sorting>
          </th>
          <th class="t-align-center" width="200px"><a>Action</a></th>
        </tr>
      </thead>
      <tbody>
        {{#if users_loaded}}
          {{#each users}}
            <tr>
              <td>{{id}}</td>
              <td>{{first_name}} {{last_name}}</td>
              <td>{{username}}</td>
              <td>{{email}}</td>
              <td>{{phone}}</td>
              <td>{{tz_offset}}</td>
              <td>{{last_loggedin}}</td>
              <td class="t-align-center ws-nowrap">
                {{#if me.permission.user_module.update == 'Allow'}}
                  <a class="btn primary d-inline small round-0_25" on-click="onEditUser" tooltip="Edit">
                    <i class="icon-edit"></i>
                  </a>
                  <a class="btn primary d-inline small round-0_25" on-click="onChangeUserPassword" tooltip="Change Password">
                    <i class="icon-lock"></i>
                  </a>
                {{/if}}
                {{#if me.permission.user_module.remove == 'Allow'}}
                  {{#if me.id != id}}
                    <a class="btn danger d-inline small round-0_25" on-click="onDeleteUser" tooltip="Delete">
                      <i class="icon-trash"></i>
                    </a>
                  {{/if}}
                {{/if}}
              </td>
            </tr>
          {{else}}
            <tr>
              <td colspan="8">
                <div class="empty">
                  <i class="icon-user1"></i>
                  <h3>No Users</h3>
                </div>
              </td>
            </tr>
          {{/each}}
        {{/if}}
      </tbody>
    </table>
  </div>
  {{#if users_loaded && users.length}}
    <div class="d-flex align-items-center mt-1">
      <div class="d-flex">
        <button class="btn border-1" class-disabled="{{!pagination.left}}" on-click="page.prev">
          <i class="icon-angle-left"></i>
        </button>
        <div class="d-flex">
          <input-number size="1" min="1" on-esc="page.esc" on-focus="page.focus" on-enter="page.enter" value="{{pagination.input}}" max="{{pagination.pages}}" />
        </div>
        <button class="btn border-1" class-disabled="{{!pagination.right}}" on-click="page.next">
          <i class="icon-angle-right"></i>
        </button>
      </div>
      <div class="d-flex f-dir-column ml-0_5">
        <small>Page: {{pagination.page}}/{{pagination.pages}}</small>
        <small>Item: {{((pagination.limit) * ((pagination.page) - 1) + (pagination.total ? 1 : 0))}}-{{((pagination.limit) < (pagination.total) ? (((pagination.limit) * (pagination.page)) < (pagination.total) ? ((pagination.limit) * (pagination.page)) : (pagination.total)) : ((pagination.total) * (pagination.page)))}}/{{pagination.total}}</small>
      </div>
    </div>
  {{/if}}
</div>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Data.set('search', '')
  $Data.set('pagination.page', 1)
  $Data.set('pagination.limit', 25)
  $Data.set('order.column', 'id')
  $Data.set('order.direction', 'desc')
  $Data.set('$url', '<%ADMIN_URL%>/api/users/all')

  $Event.on('page.init', () => {
    $Event.fire('onLoadUsers')
  })

  $Event.on('onLoadUsers', () => {
    var params = {
      ...$Data.get('order'),
      ...$Data.get('pagination'),
      search: $Data.get('search')
    }
    $Api.get('<%ADMIN_URL%>/api/users/all').params(params).send()
  })

  $Event.on('onPressClearSearch', () => {
    $Data.set('search', '')
    $Event.fire('onLoadUsers')
  })

  $Event.on('onEditUser', (e) => {
    $Data.set('user', e.get())
    $Event.fire('modal.open', 'add-user-modal')
  })

  $Event.on('onChangeUserPassword', (e) => {
    $Data.set('user', e.get())
    $Event.fire('modal.open', 'password-user-modal')
  })

  $Event.on('onDeleteUser', (e) => {
    $Data.set('user', e.get())
    $Event.fire('modal.open', 'delete-user-modal')
  })
</script>
@endsection