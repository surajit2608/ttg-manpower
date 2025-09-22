@extends('shared.layout')
@include('shared.events')
@include('shared.header', [
'page' => 'Dashboard',
])
@include('shared.sidebar', [
'page' => 'dashboard',
])

@include('widgets.input')
@include('widgets.modal')
@include('widgets.sorting')
@include('widgets.message')


@section('title')
Dashboard -
@endsection


@section('styles')
@parent
<style media="screen">
  .info-box a {
    background-color: rgba(0, 0, 0, 0.10);
  }

  .info-box .box-icon {
    color: rgba(0, 0, 0, 0.20);
  }
</style>
@endsection


@section('content')
<div class="content">
  <div class="row">
    <div class="col-xs-12 col-sm-6 col-md-3 mb-1">
      <div class="bg-success box-shadow-2 round-0_25 o-hidden info-box">
        <div class="d-flex p-1 justify-content-space-between align-items-center">
          <div>
            <h2 class="mb-0_5 color-white f-size-2_5">{{info.new_workers}}</h2>
            <p class="f-size-0_85 color-white f-weight-500">WORKERS in Last 24 Hrs</p>
          </div>
          <i class="icon-user-plus1 f-size-5 box-icon"></i>
        </div>
        <a class="d-flex justify-content-center align-items-center color-white p-0_25 f-size-0_85" href="<%ADMIN_URL%>/workers">More info <i class="icon-arrow-right-circle ml-0_5"></i></a>
      </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-3 mb-1">
      <div class="bg-info box-shadow-2 round-0_25 o-hidden info-box">
        <div class="d-flex p-1 justify-content-space-between align-items-center">
          <div>
            <h2 class="mb-0_5 color-white f-size-2_5">{{info.total_workers}}</h2>
            <p class="f-size-0_85 color-white f-weight-500">TOTAL WORKERS</p>
          </div>
          <i class="icon-users1 f-size-5 box-icon"></i>
        </div>
        <a class="d-flex justify-content-center align-items-center color-white p-0_25 f-size-0_85" href="<%ADMIN_URL%>/workers">More info <i class="icon-arrow-right-circle ml-0_5"></i></a>
      </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-3 mb-1">
      <div class="bg-warning box-shadow-2 round-0_25 o-hidden info-box">
        <div class="d-flex p-1 justify-content-space-between align-items-center">
          <div>
            <h2 class="mb-0_5 color-white f-size-2_5">{{info.pending_workers}}</h2>
            <p class="f-size-0_85 color-white f-weight-500">PENDING WORKERS</p>
          </div>
          <i class="icon-user-minus f-size-5 box-icon"></i>
        </div>
        <a class="d-flex justify-content-center align-items-center color-white p-0_25 f-size-0_85" href="<%ADMIN_URL%>/workers">More info <i class="icon-arrow-right-circle ml-0_5"></i></a>
      </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-3 mb-1">
      <div class="bg-success box-shadow-2 round-0_25 o-hidden info-box">
        <div class="d-flex p-1 justify-content-space-between align-items-center">
          <div>
            <h2 class="mb-0_5 color-white f-size-2_5">{{info.approved_workers}}</h2>
            <p class="f-size-0_85 color-white f-weight-500">APPROVED WORKERS</p>
          </div>
          <i class="icon-user-check f-size-5 box-icon"></i>
        </div>
        <a class="d-flex justify-content-center align-items-center color-white p-0_25 f-size-0_85" href="<%ADMIN_URL%>/workers">More info <i class="icon-arrow-right-circle ml-0_5"></i></a>
      </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-3 mb-1">
      <div class="bg-danger box-shadow-2 round-0_25 o-hidden info-box">
        <div class="d-flex p-1 justify-content-space-between align-items-center">
          <div>
            <h2 class="mb-0_5 color-white f-size-2_5">{{info.rejected_workers}}</h2>
            <p class="f-size-0_85 color-white f-weight-500">REJECTED WORKERS</p>
          </div>
          <i class="icon-user-x f-size-5 box-icon"></i>
        </div>
        <a class="d-flex justify-content-center align-items-center color-white p-0_25 f-size-0_85" href="<%ADMIN_URL%>/workers">More info <i class="icon-arrow-right-circle ml-0_5"></i></a>
      </div>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-3 mb-1">
      <div class="bg-warning box-shadow-2 round-0_25 o-hidden info-box">
        <div class="d-flex p-1 justify-content-space-between align-items-center">
          <div>
            <h2 class="mb-0_5 color-white f-size-2_5">{{info.applications}}</h2>
            <p class="f-size-0_85 color-white f-weight-500">JOB APPLICATIONS</p>
          </div>
          <i class="icon-clipboard1 f-size-5 box-icon"></i>
        </div>
        <a class="d-flex justify-content-center align-items-center color-white p-0_25 f-size-0_85" href="<%ADMIN_URL%>/applications">More info <i class="icon-arrow-right-circle ml-0_5"></i></a>
      </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-3 mb-1">
      <div class="bg-info box-shadow-2 round-0_25 o-hidden info-box">
        <div class="d-flex p-1 justify-content-space-between align-items-center">
          <div>
            <h2 class="mb-0_5 color-white f-size-2_5">{{info.system_users}}</h2>
            <p class="f-size-0_85 color-white f-weight-500">SYSTEM USERS</p>
          </div>
          <i class="icon-user1 f-size-5 box-icon"></i>
        </div>
        <a class="d-flex justify-content-center align-items-center color-white p-0_25 f-size-0_85" href="<%ADMIN_URL%>/users">More info <i class="icon-arrow-right-circle ml-0_5"></i></a>
      </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-3 mb-1">
      <div class="bg-danger box-shadow-2 round-0_25 o-hidden info-box">
        <div class="d-flex p-1 justify-content-space-between align-items-center">
          <div>
            <h2 class="mb-0_5 color-white f-size-2_5">{{info.new_messages}}</h2>
            <p class="f-size-0_85 color-white f-weight-500">NEW MESSAGES</p>
          </div>
          <i class="icon-message-circle f-size-5 box-icon"></i>
        </div>
        <a class="d-flex justify-content-center align-items-center color-white p-0_25 f-size-0_85" href="<%ADMIN_URL%>/notifications">More info <i class="icon-arrow-right-circle ml-0_5"></i></a>
      </div>
    </div>
  </div>

  <div class="d-flex justify-content-space-between align-items-center mv-1">
    <div>
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
            <sorting order="{{order}}" column="workers.id" on-click="onLoadWorkers">ID</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="workers.account_name" on-click="onLoadWorkers">Worker Name</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="workers.phone" on-click="onLoadWorkers">Phone</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="workers_basics.visa_type" on-click="onLoadWorkers">VISA Type</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="workers_basics.visa_expiry" on-click="onLoadWorkers">VISA Expiry</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="workers_basics.passport_expiry" on-click="onLoadWorkers">Passport Expiry</sorting>
          </th>
          <th><a>Days Left</a></th>
        </tr>
      </thead>
      <tbody>
        {{#if workers_loaded}}
          {{#each workers}}
            <tr>
              <td>{{id}}</td>
              <td>{{account_name}}</td>
              <td>{{phone}}</td>
              <td>{{basic.visa_type}}</td>
              <td>{{basic.visa_expiry}}</td>
              <td>{{basic.passport_expiry}}</td>
              <td><small class="p-0_25 color-white f-weight-600 round-1" class-bg-danger="{{visa_days_left <= 0}}" class-bg-warning="{{visa_days_left > 0 && visa_days_left < 100}}" class-bg-success="{{visa_days_left >= 100}}">{{visa_days_left > 0 ? visa_days_left : 'Expired'}}</small></td>
            </tr>
          {{else}}
            <tr>
              <td colspan="7">
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
  $Data.set('info', {
    new_workers: 0,
    total_workers: 0,
    pending_workers: 0,
    approved_workers: 0,
    rejected_workers: 0,

    applications: 0,
    system_users: 0,
    new_messages: 0,
  })
  $Data.set('search', '')
  $Data.set('pagination.page', 1)
  $Data.set('pagination.limit', 25)
  $Data.set('order.direction', 'desc')
  $Data.set('order.column', 'workers.id')
  $Data.set('$url', '<%ADMIN_URL%>/api/workers/all')

  $Event.on('page.init', () => {
    $Event.fire('onLoadWorkers')
    $Api.get('<%ADMIN_URL%>/api/dashboard/info').send()
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
</script>
@endsection