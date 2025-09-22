@extends('shared.layout')
@include('shared.events')
@include('shared.header', [
'page' => 'Notifications',
'url' => 'notifications',
])
@include('shared.sidebar', [
'page' => 'notifications',
])


@include('widgets.input')
@include('widgets.modal')
@include('widgets.message')


@section('title')
Notifications -
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
        <input class="controls ph-0_5 pv-0_25 round-tr-0 round-br-0" value="{{search}}" placeholder="Search..." on-enter="onLoadNotifications" />
        {{#if search}}
          <button class="btn p-0_5 round-0 border-1" on-click="onPressClearSearch">
            <i class="icon-close"></i>
          </button>
        {{/if}}
        <button class="btn p-0_5 round-tl-0 round-bl-0 border-1" on-click="onLoadNotifications">
          <i class="icon-search"></i>
        </button>
      </div>
    </div>
    <div>
      <a class="btn primary small round-0_25" on-click="onPressMarkAllAsRead">Mark all as read</a>
    </div>
  </div>

  {{#if notifications_loaded}}
    <div class="bg-white round-0_25 border-1 notifications">
      {{#each notifications:index}}
        <a class="d-flex align-items-center p-1 border-bottom-1" on-click="onPressNotificationItem">
          {{#if sender.image}}
            <img src="{{sender.image}}" alt="{{sender.name_initial || 'BDC'}}" />
          {{else}}
            <span data-letters="{{sender.name_initial || 'BDC'}}"></span>
          {{/if}}
          <div class="flex-1">
            <p class="color-base mb-0_5">{{content}}</p>
            <span class="d-flex align-items-center justify-content-space-between">
              <small class="color-primary">{{ago}}</small>
              {{#if status=='unread'}}<span class="d-inline-block round-5 w-px-10 h-px-10 bg-primary mr-0_5"></span>{{/if}}
            </span>
          </div>
        </a>
      {{else}}
        <div class="empty">
          <i class="icon-bell"></i>
          <h3>No Notifications</h3>
        </div>
      {{/each}}
    </div>
  {{/if}}

  {{#if notifications_loaded && notifications.length}}
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
  $Data.set('$url', '<%ADMIN_URL%>/api/notifications/all')

  $Event.on('page.init', () => {
    $Event.fire('onLoadNotifications')
  })

  $Event.on('onLoadNotifications', () => {
    var params = {
      ...$Data.get('order'),
      ...$Data.get('pagination'),
      search: $Data.get('search')
    }
    $Api.get('<%ADMIN_URL%>/api/notifications/all').params(params).send()
  })

  $Event.on('onPressClearSearch', () => {
    $Data.set('search', '')
    $Event.fire('onLoadNotifications')
  })
</script>
@endsection