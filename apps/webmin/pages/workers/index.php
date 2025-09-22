@extends('shared.layout')
@include('shared.events')
@include('shared.header', [
'page' => 'Workers',
])
@include('shared.sidebar', [
'page' => 'workers',
])


@include('widgets.input')
@include('widgets.modal')
@include('widgets.upload')
@include('widgets.sorting')
@include('widgets.message')
@include('widgets.dropdown')


@include('workers.modals.add')
@include('workers.modals.delete')
@include('workers.modals.password')


@section('title')
Workers -
@endsection


@section('styles')
@parent
<style media="screen">

</style>
@endsection


@section('content')
<div class="content">
  <div class="d-flex justify-content-space-between align-items-center mb-1">
    <div class="d-flex">
      <input class="controls ph-0_5 pv-0_25 round-tr-0 round-br-0" value="{{search}}" placeholder="Search..." on-enter="onLoadWorkers" />
      {{#if search}}
        <button class="btn p-0_5 round-0 border-1" on-click="onPressClearSearch">
          <i class="icon-close"></i>
        </button>
      {{/if}}
      <button class="btn p-0_5 round-tl-0 round-bl-0 border-1" on-click="onLoadWorkers">
        <i class="icon-search"></i>
      </button>

      <button class="btn p-0_5 border-1 ml-0_5" on-click="onExportWorkers">
        <i class="icon-download-cloud"></i>
      </button>
    </div>
    <div class="d-flex">
      {{#if me.permission.worker_module.update == 'Allow'}}
        <a class="btn primary small round-0_25" href="<%ADMIN_URL%>/workers/assign">
          <i class="icon-users1"></i><span class="ml-0_5 hide-xs">Assign Workers</span>
        </a>
      {{/if}}
      {{#if me.permission.worker_module.create == 'Allow'}}
        <a class="btn primary small round-0_25 ml-0_5" on-click="modal.open" target="add-worker-modal">
          <i class="icon-plus"></i><span class="ml-0_5 hide-xs">Add Worker</span>
        </a>
      {{/if}}
      <a class="btn primary small round-0_25 ml-0_5" href="<%ADMIN_URL%>/change-logs/?type=worker"><i class="icon-info"></i></a>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table bordered striped border-0">
      <thead>
        <tr>
          <th width="100px">
            <sorting order="{{order}}" column="workers.id" on-click="onLoadWorkers">ID</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="workers.first_name" on-click="onLoadWorkers">First Name</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="workers.last_name" on-click="onLoadWorkers">Last Name</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="workers.account_name" on-click="onLoadWorkers">Account Name</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="workers.status" on-click="onLoadWorkers">Status</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="workers.created_at" on-click="onLoadWorkers">Created At</sorting>
          </th>
          <th class="t-align-center" width="250px"><a>Action</a></th>
        </tr>
      </thead>
      <tbody>
        {{#if workers_loaded}}
          {{#each workers}}
            <tr>
              <td>{{id}}</td>
              <td>{{first_name}}</td>
              <td>{{last_name}}</td>
              <td>{{account_name}}</td>
              <td>{{status.toUpperCase()}}</td>
              <td>{{created_at}}</td>
              <td class="t-align-center ws-nowrap">
                {{#if me.permission.attendance_module.read == 'Allow'}}
                  <a class="btn primary d-inline small round-0_25" on-click="onViewAttendance" tooltip="Attendance">
                    <i class="icon-schedule_send"></i>
                  </a>
                {{/if}}
                {{#if me.permission.leave_module.read == 'Allow'}}
                  <a class="btn primary d-inline small round-0_25" on-click="onViewLeaves" tooltip="Leaves">
                    <i class="icon-calendar1"></i>
                  </a>
                {{/if}}
                {{#if me.permission.worker_module.update == 'Allow'}}
                  <a class="btn primary d-inline small round-0_25" on-click="onViewWorker" tooltip="Edit">
                    <i class="icon-edit"></i>
                  </a>
                  <a class="btn primary d-inline small round-0_25" on-click="onChangeWorkerPassword" tooltip="Change Password">
                    <i class="icon-lock"></i>
                  </a>
                {{/if}}
                {{#if me.permission.worker_module.remove == 'Allow'}}
                  <a class="btn danger d-inline small round-0_25" on-click="onDeleteWorker" tooltip="Delete">
                    <i class="icon-trash"></i>
                  </a>
                {{/if}}
              </td>
            </tr>
          {{else}}
            <tr>
              <td colspan="6">
                <div class="empty">
                  <i class="icon-users1"></i>
                  <h3>No Workers</h3>
                </div>
              </td>
            </tr>
          {{/each}}
        {{/if}}
      </tbody>
    </table>
  </div>
  {{#if workers_loaded && workers.length}}
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
  $Data.set('order.direction', 'desc')
  $Data.set('order.column', 'workers.id')
  $Data.set('$url', '<%ADMIN_URL%>/api/workers/all')

  $Event.on('page.init', () => {
    $Event.fire('onLoadWorkers')
  })

  $Event.on('onLoadWorkers', () => {
    var params = {
      ...$Data.get('order'),
      ...$Data.get('pagination'),
      search: $Data.get('search')
    }
    $Api.get('<%ADMIN_URL%>/api/workers/all').params(params).send()
  })

  $Event.on('onPressClearSearch', () => {
    $Data.set('search', '')
    $Event.fire('onLoadWorkers')
  })

  $Event.on('onExportWorkers', () => {
    var params = {
      ...$Data.get('order'),
      search: $Data.get('search')
    }
    $Api.post('<%ADMIN_URL%>/api/workers/export').params(params).send()
  })

  $Event.on('onViewAttendance', (e) => {
    $Event.fire('page.redirect', `<%ADMIN_URL%>/workers/attendance/?id=${e.get('id')}`)
  })

  $Event.on('onViewLeaves', (e) => {
    $Event.fire('page.redirect', `<%ADMIN_URL%>/workers/leaves/?id=${e.get('id')}`)
  })

  $Event.on('onViewWorker', (e) => {
    $Event.fire('page.redirect', `<%ADMIN_URL%>/workers/application/?id=${e.get('id')}&tab=basic`)
  })

  $Event.on('onEditWorker', (e) => {
    $Data.set('worker', e.get())
    $Event.fire('modal.open', 'add-worker-modal')
  })

  $Event.on('onChangeWorkerPassword', (e) => {
    $Data.set('worker', e.get())
    $Event.fire('modal.open', 'password-worker-modal')
  })

  $Event.on('onDeleteWorker', (e) => {
    $Data.set('worker', e.get())
    $Event.fire('modal.open', 'delete-worker-modal')
  })
</script>
@endsection