<?php
$type = Input::get('type', null);
?>

@extends('shared.layout')
@include('shared.events')
@include('shared.header', [
'page' => 'Change Logs',
])
@include('shared.sidebar', [
'page' => 'change-logs',
])


@include('widgets.input')
@include('widgets.modal')
@include('widgets.sorting')
@include('widgets.message')


@section('title')
Change Logs -
@endsection


@section('styles')
@parent
<style media="screen">

</style>
@endsection


@section('content')
<div class="content">
  <div class="d-flex justify-content-space-between align-items-center mb-1">
    <div class="d-flex align-items-center">
      <a class="btn primary small p-0_25 round-5 mr-0_5" on-click="page.back">
        <i class="icon-keyboard_arrow_left"></i>
      </a>
      <div class="d-flex">
        <input class="controls ph-0_5 pv-0_25 round-tr-0 round-br-0" value="{{search}}" placeholder="Search..." on-enter="onLoadChangeLogs" />
        {{#if search}}
          <button class="btn p-0_5 round-0 border-1" on-click="onPressClearSearch">
            <i class="icon-close"></i>
          </button>
        {{/if}}
        <button class="btn p-0_5 round-tl-0 round-bl-0 border-1" on-click="onLoadChangeLogs">
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
          <th>
            <sorting order="{{order}}" column="users.full_name" on-click="onLoadChangeLogs">User Name</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="change_logs.method" on-click="onLoadChangeLogs">Change Type</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="change_logs.comment" on-click="onLoadChangeLogs">Comment</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="change_logs.created_at" on-click="onLoadChangeLogs">Change At</sorting>
          </th>
        </tr>
      </thead>
      <tbody>
        {{#if change_logs_loaded}}
          {{#each change_logs}}
            <tr>
              <td>{{full_name}}</td>
              <td>{{method.toUpperCase()}}</td>
              <td>{{comment}}</td>
              <td>{{created_at}}</td>
            </tr>
          {{else}}
            <tr>
              <td colspan="7">
                <div class="empty">
                  <i class="icon-clipboard1"></i>
                  <h3>No Change Logs</h3>
                </div>
              </td>
            </tr>
          {{/each}}
        {{/if}}
      </tbody>
    </table>
  </div>
  {{#if change_logs_loaded && change_logs.length}}
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
  $Data.set('type', '<%$type%>')
  $Data.set('pagination.page', 1)
  $Data.set('pagination.limit', 25)
  $Data.set('order.direction', 'desc')
  $Data.set('order.column', 'change_logs.id')
  $Data.set('$url', '<%ADMIN_URL%>/api/change-logs/all')

  $Event.on('page.init', () => {
    $Event.fire('onLoadChangeLogs')
  })

  $Event.on('onLoadChangeLogs', () => {
    var params = {
      ...$Data.get('order'),
      type: $Data.get('type'),
      ...$Data.get('pagination'),
      search: $Data.get('search'),
    }
    $Api.post('<%ADMIN_URL%>/api/change-logs/all').params(params).send()
  })

  $Event.on('onPressClearSearch', () => {
    $Data.set('search', '')
    $Event.fire('onLoadChangeLogs')
  })
</script>
@endsection