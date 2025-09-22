@extends('shared.layout')
@include('shared.events')
@include('shared.header', [
'page' => 'Clients',
])
@include('shared.sidebar', [
'page' => 'clients',
])


@include('widgets.input')
@include('widgets.modal')
@include('widgets.sorting')
@include('widgets.message')
@include('widgets.dropdown')


@include('clients.modals.add')
@include('clients.modals.delete')


@section('title')
Clients -
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
        <input class="controls ph-0_5 pv-0_25 round-tr-0 round-br-0" value="{{search}}" placeholder="Search..." on-enter="onLoadClients" />
        {{#if search}}
          <button class="btn p-0_5 round-0 border-1" on-click="onPressClearSearch">
            <i class="icon-close"></i>
          </button>
        {{/if}}
        <button class="btn p-0_5 round-tl-0 round-bl-0 border-1" on-click="onLoadClients">
          <i class="icon-search"></i>
        </button>
      </div>
    </div>
    <div class="d-flex">
      {{#if me.permission.client_module.create == 'Allow'}}
        <a class="btn primary small round-0_25" on-click="modal.open" target="add-client-modal">
          <i class="icon-plus"></i><span class="ml-0_5 hide-xs">Add Client</span>
        </a>
      {{/if}}
      <a class="btn primary small round-0_25 ml-0_5" href="<%ADMIN_URL%>/change-logs/?type=client"><i class="icon-info"></i></a>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table bordered striped border-0">
      <thead>
        <tr>
          <th width="100px">
            <sorting order="{{order}}" column="id" on-click="onLoadClients">ID</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="business_name" on-click="onLoadClients">Business Name</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="contact_person" on-click="onLoadClients">Contact Person</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="email" on-click="onLoadClients">Email Address</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="phone" on-click="onLoadClients">Phone</sorting>
          </th>
          <th class="t-align-center" width="200px"><a>Action</a></th>
        </tr>
      </thead>
      <tbody>
        {{#if clients_loaded}}
          {{#each clients}}
            <tr>
              <td>{{id}}</td>
              <td>{{business_name}}</td>
              <td>{{contact_person}}</td>
              <td>{{email}}</td>
              <td>{{phone}}</td>
              <td class="t-align-center ws-nowrap">
                {{#if me.permission.client_module.update == 'Allow'}}
                  <a class="btn primary d-inline small round-0_25" on-click="onEditClient" tooltip="Edit">
                    <i class="icon-edit"></i>
                  </a>
                {{/if}}
                {{#if me.permission.client_module.remove == 'Allow'}}
                  <a class="btn danger d-inline small round-0_25" on-click="onDeleteClient" tooltip="Delete">
                    <i class="icon-trash"></i>
                  </a>
                {{/if}}
              </td>
            </tr>
          {{else}}
            <tr>
              <td colspan="6">
                <div class="empty">
                  <i class="icon-user-check"></i>
                  <h3>No Clients</h3>
                </div>
              </td>
            </tr>
          {{/each}}
        {{/if}}
      </tbody>
    </table>
  </div>
  {{#if clients_loaded && clients.length}}
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
  $Data.set('$url', '<%ADMIN_URL%>/api/clients/all')

  $Event.on('page.init', () => {
    $Event.fire('onLoadClients')
  })

  $Event.on('onLoadClients', () => {
    var params = {
      ...$Data.get('order'),
      ...$Data.get('pagination'),
      search: $Data.get('search')
    }
    $Api.get('<%ADMIN_URL%>/api/clients/all').params(params).send()
  })

  $Event.on('onPressClearSearch', () => {
    $Data.set('search', '')
    $Event.fire('onLoadClients')
  })

  $Event.on('onEditClient', (e) => {
    $Data.set('client', e.get())
    $Event.fire('modal.open', 'add-client-modal')
  })

  $Event.on('onDeleteClient', (e) => {
    $Data.set('client', e.get())
    $Event.fire('modal.open', 'delete-client-modal')
  })
</script>
@endsection