@extends('shared.layout')
@include('shared.events')
@include('shared.header', [
'page' => 'Holidays',
])
@include('shared.sidebar', [
'page' => 'holidays',
])


@include('widgets.input')
@include('widgets.modal')
@include('widgets.sorting')
@include('widgets.message')


@include('holidays.modals.add')
@include('holidays.modals.delete')


@section('title')
Holidays -
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
        <input class="controls ph-0_5 pv-0_25 round-tr-0 round-br-0" value="{{search}}" placeholder="Search..." on-enter="onLoadHolidays" />
        {{#if search}}
          <button class="btn p-0_5 round-0 border-1" on-click="onPressClearSearch">
            <i class="icon-close"></i>
          </button>
        {{/if}}
        <button class="btn p-0_5 round-tl-0 round-bl-0 border-1" on-click="onLoadHolidays">
          <i class="icon-search"></i>
        </button>
      </div>
    </div>
    <div class="d-flex">
      {{#if me.permission.holiday_module.create == 'Allow'}}
        <a class="btn primary small round-0_25" on-click="modal.open" target="add-holiday-modal">
          <i class="icon-plus"></i><span class="ml-0_5 hide-xs">Add Holiday</span>
        </a>
      {{/if}}
      <a class="btn primary small round-0_25 ml-0_5" href="<%ADMIN_URL%>/change-logs/?type=holiday"><i class="icon-info"></i></a>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table bordered striped border-0">
      <thead>
        <tr>
          <th width="100px">
            <sorting order="{{order}}" column="id" on-click="onLoadHolidays">ID</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="name" on-click="onLoadHolidays">Name</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="date" on-click="onLoadHolidays">Date</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="created_at" on-click="onLoadHolidays">Created At</sorting>
          </th>
          <th class="t-align-center" width="200px"><a>Action</a></th>
        </tr>
      </thead>
      <tbody>
        {{#if holidays_loaded}}
          {{#each holidays}}
            <tr>
              <td>{{id}}</td>
              <td>{{name}}</td>
              <td>{{date}}</td>
              <td>{{created_at}}</td>
              <td class="t-align-center ws-nowrap">
                {{#if me.permission.holiday_module.update == 'Allow'}}
                  <a class="btn primary d-inline small round-0_25" on-click="onEditHoliday" tooltip="Edit">
                    <i class="icon-edit"></i>
                  </a>
                {{/if}}
                {{#if me.permission.holiday_module.remove == 'Allow'}}
                  <a class="btn danger d-inline small round-0_25" on-click="onDeleteHoliday" tooltip="Delete">
                    <i class="icon-trash"></i>
                  </a>
                {{/if}}
              </td>
            </tr>
          {{else}}
            <tr>
              <td colspan="5">
                <div class="empty">
                  <i class="icon-calendar1"></i>
                  <h3>No Holidays</h3>
                </div>
              </td>
            </tr>
          {{/each}}
        {{/if}}
      </tbody>
    </table>
  </div>
  {{#if holidays_loaded && holidays.length}}
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
  $Data.set('$url', '<%ADMIN_URL%>/api/holidays/all')

  $Event.on('page.init', () => {
    $Event.fire('onLoadHolidays')
  })

  $Event.on('onLoadHolidays', () => {
    var params = {
      ...$Data.get('order'),
      ...$Data.get('pagination'),
      search: $Data.get('search')
    }
    $Api.get('<%ADMIN_URL%>/api/holidays/all').params(params).send()
  })

  $Event.on('onPressClearSearch', () => {
    $Data.set('search', '')
    $Event.fire('onLoadHolidays')
  })

  $Event.on('onEditHoliday', (e) => {
    $Data.set('holiday', e.get())
    $Event.fire('modal.open', 'add-holiday-modal')
  })

  $Event.on('onDeleteHoliday', (e) => {
    $Data.set('holiday', e.get())
    $Event.fire('modal.open', 'delete-holiday-modal')
  })
</script>
@endsection