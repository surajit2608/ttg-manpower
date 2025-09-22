@extends('shared.layout')
@include('shared.events')
@include('shared.header', [
'page' => 'My Leaves',
'url' => 'leaves',
])
@include('shared.sidebar', [
'page' => 'leaves',
])


@include('widgets.input')
@include('widgets.modal')
@include('widgets.message')
@include('widgets.sorting')


@include('leaves.modals.apply')
@include('leaves.modals.delete')


@section('title')
My Leaves -
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
        <input class="controls ph-0_5 pv-0_25 round-tr-0 round-br-0" value="{{search}}" placeholder="Search..." on-enter="onLoadLeaves" />
        {{#if search}}
          <button class="btn p-0_5 round-0 border-1" on-click="onPressClearSearch">
            <i class="icon-close"></i>
          </button>
        {{/if}}
        <button class="btn p-0_5 round-tl-0 round-bl-0 border-1" on-click="onLoadLeaves">
          <i class="icon-search"></i>
        </button>
      </div>
    </div>
    <div>
      <a class="btn primary small round-0_25" on-click="modal.open" target="apply-leave-modal">
        <i class="icon-plus"></i><span class="ml-0_5 hide-xs">Apply Leave</span>
      </a>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table bordered striped border-0">
      <thead>
        <tr>
          <th width="100px">
            <sorting order="{{order}}" column="leaves.id" on-click="onLoadLeaves">ID</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="holidays.name" on-click="onLoadLeaves">Leave</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="holidays.date" on-click="onLoadLeaves">Date</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="leaves.message" on-click="onLoadLeaves">Message</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="leaves.comment" on-click="onLoadLeaves">Comment</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="leaves.status" on-click="onLoadLeaves">Status</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="leaves.created_at" on-click="onLoadLeaves">Created At</sorting>
          </th>
          <th class="t-align-center" width="200px"><a>Action</a></th>
        </tr>
      </thead>
      <tbody>
        {{#if leaves_loaded}}
          {{#each leaves}}
            <tr>
              <td>{{id}}</td>
              <td>{{holiday.name}}</td>
              <td>{{holiday.date}}</td>
              <td>{{message}}</td>
              <td>{{comment}}</td>
              <td>{{status.toUpperCase()}}</td>
              <td>{{created_at}}</td>
              <td class="t-align-center ws-nowrap">
                <a class="btn primary d-inline small round-0_25" on-click="onEditLeave" tooltip="Edit">
                  <i class="icon-edit"></i>
                </a>
                <a class="btn danger d-inline small round-0_25" on-click="onDeleteLeave" tooltip="Delete">
                  <i class="icon-trash"></i>
                </a>
              </td>
            </tr>
          {{else}}
            <tr>
              <td colspan="8">
                <div class="empty">
                  <i class="icon-calendar1"></i>
                  <h3>No Leaves</h3>
                </div>
              </td>
            </tr>
          {{/each}}
        {{/if}}
      </tbody>
    </table>
  </div>
  {{#if leaves_loaded && leaves.length}}
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
  $Data.set('order.column', 'leaves.id')
  $Data.set('order.direction', 'desc')
  $Data.set('$url', '<%SITE_URL%>/api/leaves/all')

  $Event.on('page.init', () => {
    $Event.fire('onLoadLeaves')
  })

  $Event.on('onLoadLeaves', () => {
    var params = {
      ...$Data.get('order'),
      ...$Data.get('pagination'),
      search: $Data.get('search')
    }
    $Api.get('<%SITE_URL%>/api/leaves/all').params(params).send()
  })

  $Event.on('onPressClearSearch', () => {
    $Data.set('search', '')
    $Event.fire('onLoadLeaves')
  })

  $Event.on('onEditLeave', (e) => {
    $Data.set('leave', e.get())
    $Event.fire('modal.open', 'apply-leave-modal')
  })

  $Event.on('onDeleteLeave', (e) => {
    $Data.set('leave', e.get())
    $Event.fire('modal.open', 'delete-leave-modal')
  })
</script>
@endsection