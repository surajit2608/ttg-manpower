<?php
$id = Input::get('id', 0);
if (!$id) {
  return Response::redirect(ADMIN_URL . '/workers');
}
?>

@extends('shared.layout')
@include('shared.events')
@include('shared.header', [
'page' => "{{#if worker_loaded}}{{worker.first_name}}'s Leaves{{/if}}",
'url' => 'leaves',
])
@include('shared.sidebar', [
'page' => 'workers',
])


@include('widgets.input')
@include('widgets.modal')
@include('widgets.message')
@include('widgets.sorting')


@include('workers.modals.leave-reject')
@include('workers.modals.leave-approve')
@include('workers.modals.leave-view')


@section('title')
Leaves -
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
      <a class="btn primary small p-0_25 round-5 mr-1 f-size-1_25" href="<%ADMIN_URL%>/workers">
        <i class="icon-keyboard_arrow_left"></i>
      </a>
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
      </div>
    </div>
    <div></div>
  </div>
  <div class="table-responsive">
    <table class="table bordered striped border-0">
      <thead>
        <tr>
          <th width="100px">
            <sorting order="{{order}}" column="leaves.id" on-click="onLoadWorkers">ID</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="holidays.name" on-click="onLoadWorkers">Leave</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="holidays.date" on-click="onLoadWorkers">Date</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="leaves.message" on-click="onLoadWorkers">Message</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="leaves.comment" on-click="onLoadWorkers">Comment</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="leaves.status" on-click="onLoadWorkers">Status</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="leaves.created_at" on-click="onLoadWorkers">Created At</sorting>
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
                <a class="btn primary d-inline small round-0_25" on-click="onViewLeave" tooltip="View">
                  <i class="icon-eye"></i>
                </a>
                {{#if me.permission.leave_module.update == 'Allow'}}
                  <a class="btn primary d-inline small round-0_25" on-click="onApproveLeave" tooltip="Approve">
                    <i class="icon-check"></i>
                  </a>
                  <a class="btn danger d-inline small round-0_25" on-click="onRejectLeave" tooltip="Reject">
                    <i class="icon-cancel"></i>
                  </a>
                {{/if}}
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
  $Data.set('worker.id', parseInt('<%$id%>'))
  $Data.set('$url', '<%ADMIN_URL%>/api/leaves/all')

  $Event.on('page.init', () => {
    $Event.fire('onLoadWorkers')
  })

  $Event.on('onLoadWorkers', () => {
    var params = $Data.get('worker')
    $Api.get('<%ADMIN_URL%>/api/workers/get').params(params).send()

    var params = {
      ...$Data.get('order'),
      ...$Data.get('pagination'),
      search: $Data.get('search'),
      worker_id: $Data.get('worker.id'),
    }
    $Api.get('<%ADMIN_URL%>/api/leaves/all').params(params).send()
  })

  $Event.on('onPressClearSearch', () => {
    $Data.set('search', '')
    $Event.fire('onLoadWorkers')
  })

  $Event.on('onViewLeave', (e) => {
    $Data.set('leave', e.get())
    $Event.fire('modal.open', 'view-leave-modal')
  })

  $Event.on('onApproveLeave', (e) => {
    $Data.set('leave', e.get())
    $Event.fire('modal.open', 'approve-leave-modal')
  })

  $Event.on('onRejectLeave', (e) => {
    $Data.set('leave', e.get())
    $Event.fire('modal.open', 'reject-leave-modal')
  })
</script>
@endsection