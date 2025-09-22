@extends('shared.layout')
@include('shared.events')
@include('shared.header', [
'page' => 'My Attendance',
'url' => 'attendance',
])
@include('shared.sidebar', [
'page' => 'attendance',
])


@include('widgets.input')
@include('widgets.modal')
@include('widgets.message')
@include('widgets.sorting')


@section('title')
My Attendance -
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
        <input class="controls ph-0_5 pv-0_25 round-tr-0 round-br-0" value="{{search}}" placeholder="Search..." on-enter="onLoadAttendances" />
        {{#if search}}
          <button class="btn p-0_5 round-0 border-1" on-click="onPressClearSearch">
            <i class="icon-close"></i>
          </button>
        {{/if}}
        <button class="btn p-0_5 round-tl-0 round-bl-0 border-1" on-click="onLoadAttendances">
          <i class="icon-search"></i>
        </button>
      </div>
    </div>
    <div class="d-flex align-items-center">
      {{#if punched_loaded}}
        <input class="controls ph-0_5 pv-0_25 mr-0_5" placeholder="{{!punched.in_time ? 'In' : 'Out'}} note within 50 chars" value="{{punch_note}}" on-enter="onPressPunchInOut" disabled="{{punched.out_time}}" />
        <a class="btn primary small ph-1_5 round-0_25" on-click="onPressPunchInOut" class-disabled="{{punched.out_time}}">
          <i class="icon-schedule_send"></i><span class="ml-0_5 hide-xs">{{!punched.in_time ? 'Punch In' : 'Punch Out'}}</span>
        </a>
      {{/if}}
    </div>
  </div>
  <div class="table-responsive">
    <table class="table bordered striped border-0">
      <thead>
        <tr>
          <th>
            <sorting order="{{order}}" column="date" on-click="onLoadAttendances">Date</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="in_time" on-click="onLoadAttendances">In Time</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="in_note" on-click="onLoadAttendances">In Note</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="out_time" on-click="onLoadAttendances">Out Time</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="out_note" on-click="onLoadAttendances">Out Note</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="hours" on-click="onLoadAttendances">Hours</sorting>
          </th>
        </tr>
      </thead>
      <tbody>
        {{#if attendance_loaded}}
          {{#each attendance:index}}
            <tr>
              <td>{{date}}</td>
              <td>{{in_time}}</td>
              <td>{{in_note}}</td>
              <td>{{out_time}}</td>
              <td>{{out_note}}</td>
              <td>{{hours}}</td>
            </tr>
          {{else}}
            <tr>
              <td colspan="6">
                <div class="empty">
                  <i class="icon-schedule_send"></i>
                  <h3>No Attendance</h3>
                </div>
              </td>
            </tr>
          {{/each}}
        {{/if}}
      </tbody>
    </table>
  </div>
  {{#if attendance_loaded && attendance.length}}
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
  $Data.set('$url', '<%SITE_URL%>/api/attendance/all')

  $Event.on('page.init', () => {
    $Event.fire('onLoadAttendances')
  })

  $Event.on('onLoadAttendances', () => {
    var params = {
      ...$Data.get('order'),
      ...$Data.get('pagination'),
      search: $Data.get('search')
    }
    $Api.get('<%SITE_URL%>/api/attendance/all').params(params).send()
  })

  $Event.on('onPressClearSearch', () => {
    $Data.set('search', '')
    $Event.fire('onLoadAttendances')
  })
</script>
@endsection