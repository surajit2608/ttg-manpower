@extends('shared.layout')
@include('shared.events')
@include('shared.header', [
'page' => 'Dashboard',
'url' => 'dashboard',
])
@include('shared.sidebar', [
'page' => 'dashboard',
])


@include('widgets.input')
@include('widgets.modal')
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
    <div class="col-xs-12 col-sm-12 col-md-12">
      <div class="bg-warning box-shadow-2 round-0_25 o-hidden mb-1">
        <a class="d-block p-1" href="<%SITE_URL%>/settings/?tab=documents">
          <strong>You have missed to upload some important documents. Please click here to upload the documents.</strong>
        </a>
      </div>
    </div>
  </div>
  
  <div class="row">
    <div class="col-xs-12 col-sm-6 col-md-3 mb-1">
      <div class="bg-info box-shadow-2 round-0_25 o-hidden info-box">
        <div class="d-flex p-1 justify-content-space-between align-items-center">
          <div>
            <h2 class="mb-0_5 color-white f-size-2_5">{{info.last_week_worked_hours}}</h2>
            <p class="f-size-0_85 color-white f-weight-500">LAST WEEK HOURS WORKED</p>
          </div>
          <i class="icon-users1 f-size-5 box-icon"></i>
        </div>
        <a class="d-flex justify-content-center align-items-center color-white p-0_25 f-size-0_85" href="<%SITE_URL%>/attendance">More info <i class="icon-arrow-right-circle ml-0_5"></i></a>
      </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-3 mb-1">
      <div class="bg-success box-shadow-2 round-0_25 o-hidden info-box">
        <div class="d-flex p-1 justify-content-space-between align-items-center">
          <div>
            <h2 class="mb-0_5 color-white f-size-2_5">{{info.last_week_worked_amount}}</h2>
            <p class="f-size-0_85 color-white f-weight-500">LAST WEEK SALARY</p>
          </div>
          <i class="icon-clipboard1 f-size-5 box-icon"></i>
        </div>
        <a class="d-flex justify-content-center align-items-center color-white p-0_25 f-size-0_85" href="<%SITE_URL%>/attendance">More info <i class="icon-arrow-right-circle ml-0_5"></i></a>
      </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-3 mb-1">
      <div class="bg-warning box-shadow-2 round-0_25 o-hidden info-box">
        <div class="d-flex p-1 justify-content-space-between align-items-center">
          <div>
            <h2 class="mb-0_5 color-white f-size-2_5">{{info.leaves_applied}}</h2>
            <p class="f-size-0_85 color-white f-weight-500">LEAVES APPLIED</p>
          </div>
          <i class="icon-user1 f-size-5 box-icon"></i>
        </div>
        <a class="d-flex justify-content-center align-items-center color-white p-0_25 f-size-0_85" href="<%SITE_URL%>/leaves">More info <i class="icon-arrow-right-circle ml-0_5"></i></a>
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
        <a class="d-flex justify-content-center align-items-center color-white p-0_25 f-size-0_85" href="<%SITE_URL%>/notifications">More info <i class="icon-arrow-right-circle ml-0_5"></i></a>
      </div>
    </div>
  </div>
</div>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Data.set('info', {
    last_week_worked_hours: 0,
    last_week_work_hours_remain: 0,
    last_week_worked_amount: 0,
    leaves_applied: 0,
    new_messages: 0,
  })

  $Event.on('page.init', () => {
    $Api.get('<%SITE_URL%>/api/dashboard/info').send()
  })
</script>
@endsection