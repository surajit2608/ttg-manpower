<?php
$params = Request::params();
$slug = $params[0] ?? null;
$application = Application::where('slug', $slug)->first();
?>

@extends('shared.layout')
@include('shared.events')


@include('widgets.input')
@include('widgets.modal')
@include('widgets.upload')
@include('widgets.sorting')
@include('widgets.message')
@include('widgets.dropdown')


@section('title')
<%$application->title ?? '404 Not Found'%> -
@endsection


@section('styles')
@parent
<style media="screen">

</style>
@endsection


@section('content')
<div class="content">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="bg-white box-shadow-4 round-0_25">
          {{#if !application && application_loaded}}
            <div class="empty">
              <i class="icon-clipboard1"></i>
              <h3>No Application Found</h3>
              <p class="mt-1 f-size-1_25">It seems the application is closed or not found</p>
            </div>
          {{/if}}

          {{#if application && application_loaded}}
            <h3 class="d-flex justify-content-space-between align-items-center f-weight-400 pv-1 ph-base border-bottom-1 bg-gray">
              <div class="d-flex align-items-center ws-nowrap o-hidden">
                {{#if application_loaded}}
                  {{application.title}} in {{application.address}}, {{application.city}}, {{application.post_code}}
                {{/if}}
              </div>
              <div>&nbsp;</div>
            </h3>

            <div class="p-base">
              <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-3">
                  <div class="group">
                    <label>Title<small class="required">*</small>:</label>
                    <dropdown options="{{options_prefix}}" value="{{worker.title}}" placeholder="Choose Title" />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-3">
                  <div class="group">
                    <label>First Name<small class="required">*</small>:</label>
                    <input type="text" class="controls" value="{{worker.first_name}}" on-enter="onPressSubmitWorker" />
                  </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3">
                  <div class="group">
                    <label>Middle Name:</label>
                    <input type="text" class="controls" value="{{worker.middle_name}}" on-enter="onPressSubmitWorker" />
                  </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3">
                  <div class="group">
                    <label>Last Name<small class="required">*</small>:</label>
                    <input type="text" class="controls" value="{{worker.last_name}}" on-enter="onPressSubmitWorker" />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-3">
                  <div class="group">
                    <label>Date of Birth<small class="required">*</small>:</label>
                    <dropdown-date value="{{worker.dob}}" max="{{today}}" />
                  </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3">
                  <div class="group">
                    <label>Gender<small class="required">*</small>:</label>
                    <dropdown options="{{options_genders}}" value="{{worker.gender}}" placeholder="Choose Gender" />
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-xs-12">
                  <h2 class="mb-1 mt-1 f-size-1_25 f-weight-400"><u>Login information</u>:</h2>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3">
                  <div class="group">
                    <label>Email Address<small class="required">*</small>:</label>
                    <input type="email" class="controls" value="{{worker.email}}" on-enter="onPressSubmitWorker" />
                  </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3">
                  <div class="group">
                    <label>Phone<small class="required">*</small>:</label>
                    <input type="text" class="controls" value="{{worker.phone}}" on-enter="onPressSubmitWorker" />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-3">
                  <div class="group">
                    <label>Username<small class="required">*</small>:</label>
                    <input type="text" class="controls" value="{{worker.username}}" on-enter="onPressSubmitWorker" />
                  </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3">
                  <div class="group">
                    <label>Password<small class="required">*</small>:</label>
                    <input type="password" class="controls" value="{{worker.password}}" on-enter="onPressSubmitWorker" />
                  </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3">
                  <div class="group">
                    <label>Confirm Password<small class="required">*</small>:</label>
                    <input type="password" class="controls" value="{{worker.confirm_password}}" on-enter="onPressSubmitWorker" />
                  </div>
                </div>
                <div class="col-xs-12">
                  <div class="group">
                    <label>Password Hint:</label>
                    <ul>
                      <li>Password must be atleast 8 characters long.</li>
                      <li>Password must be alpha-numeric.</li>
                      <li>Password must contains atleast one special character.</li>
                      <li>Password must contains atleast one capital letter.</li>
                      <li>Password must contains atleast one small letter.</li>
                    </ul>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-xs-12">
                  <h2 class="mb-1 mt-1 f-size-1_25 f-weight-400"><u>Address information</u>:</h2>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6">
                  <div class="group">
                    <label>House No & Street Address<small class="required">*</small>:</label>
                    <input type="text" class="controls" value="{{worker.address.address}}" on-enter="onPressSubmitWorker" />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-3">
                  <div class="group">
                    <label>City<small class="required">*</small>:</label>
                    <input type="text" class="controls" value="{{worker.address.city}}" on-enter="onPressSubmitWorker" />
                  </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3">
                  <div class="group">
                    <label>Post Code<small class="required">*</small>:</label>
                    <input type="text" class="controls" value="{{worker.address.post_code}}" on-enter="onPressSubmitWorker" />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-3">
                  <div class="group">
                    <label>Country<small class="required">*</small>:</label>
                    <input type="text" class="controls" value="{{worker.address.country}}" on-enter="onPressSubmitWorker" />
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-xs-12">
                  <h2 class="mb-1 mt-1 f-size-1_25 f-weight-400"><u>Other information</u>:</h2>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3">
                  <div class="group">
                    <label>VISA Type<small class="required">*</small>:</label>
                    <dropdown options="{{options_visa_types}}" value="{{worker.basic.visa_type}}" placeholder="Choose VISA Type" />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-3">
                  <div class="group">
                    <label>VISA Expiry<small class="required">*</small>:</label>
                    <dropdown-date value="{{worker.basic.visa_expiry}}" min="{{today}}" />
                  </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3">
                  <div class="group">
                    <label>Passport Expiry:</label>
                    <dropdown-date value="{{worker.basic.passport_expiry}}" min="{{today}}" />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-3">
                  <div class="group">
                    <label>Nationality:</label>
                    <dropdown options="{{options_nationalities}}" value="{{worker.basic.nationality_id}}" placeholder="Choose Nationality" />
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 mt-1">
                  <button class="btn primary" on-click="onPressSubmitWorker">Submit</button>
                </div>
              </div>
            </div>
          {{/if}}
        </div>
        <div class="h-px-100"></div>
      </div>
    </div>
  </div>
</div>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Event.on('page.init', () => {
    $Api.get('<%SITE_URL%>/api/nationalities/options').send()

    var params = {
      slug: '<%$slug%>'
    }
    $Api.get('<%SITE_URL%>/api/applications/get').params(params).send(res => {
      $Data.set('worker.application_id', $Data.get('application.id'))
      $Data.set('worker.tz_offset', (new Date()).getTimezoneOffset() * 60)
    })
  })

  $Event.on('onPressSubmitWorker', function() {
    var params = $Data.get('worker')
    $Api.post('<%SITE_URL%>/api/applications/register').params(params).send()
  })
</script>
@endsection