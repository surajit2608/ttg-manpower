<?php
$tab = Input::get('tab', 'basic');
?>

@extends('shared.layout')
@include('shared.events')
@include('shared.header', [
'page' => 'Settings',
])
@include('shared.sidebar', [
'page' => 'settings',
])


@include('widgets.input')
@include('widgets.modal')
@include('widgets.upload')
@include('widgets.sorting')
@include('widgets.message')
@include('widgets.dropdown')

@include('settings.modals.document')
@include('settings.modals.grievance')

@section('title')
@if($tab == 'basic')
Basic Information -
@endif
@if($tab == 'password')
Password Information -
@endif
@if($tab == 'payrolls')
Payroll Information -
@endif
@if($tab == 'addresses')
Addresses -
@endif
@if($tab == 'employments')
Employment History -
@endif
@if($tab == 'trainings')
Training & Education -
@endif
@if($tab == 'references')
References -
@endif
@if($tab == 'health')
Occupational Health Section -
@endif
@if($tab == 'policy')
Policy and Declaration -
@endif
@if($tab == 'grievances')
Grievances -
@endif
@if($tab == 'documents')
Missing Documents -
@endif
@endsection


@section('styles')
@parent
<style media="screen">

</style>
@endsection


@section('content')
<div class="content">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-3">
      <div class="bg-white box-shadow-4 round-0_25 o-hidden mb-1 sticky top-2">
        <h3 class="f-weight-400 p-1 border-bottom-1 bg-gray">Settings Panel</h3>
        <ul class="list-none p-0">
          <li>
            <a class="d-flex p-1 border-top-1 justify-content-space-between align-items-center" class-bg-gray="{{tab=='basic'}}" class-f-weight-400="{{tab=='basic'}}" href="<%SITE_URL%>/settings/?tab=basic">
              <span><i class="icon-dashboard1"></i> Basic Information</span>
            </a>
          </li>
          <li>
            <a class="d-flex p-1 border-top-1 justify-content-space-between align-items-center" class-bg-gray="{{tab=='password'}}" class-f-weight-400="{{tab=='password'}}" href="<%SITE_URL%>/settings/?tab=password">
              <span><i class="icon-lock1"></i> Password Settings</span>
            </a>
          </li>
          <li>
            <a class="d-flex p-1 border-top-1 justify-content-space-between align-items-center" class-bg-gray="{{tab=='payrolls'}}" class-f-weight-400="{{tab=='payrolls'}}" href="<%SITE_URL%>/settings/?tab=payrolls">
              <span><i class="icon-file-text1"></i> Payroll Information</span>
            </a>
          </li>
          <li>
            <a class="d-flex p-1 border-top-1 justify-content-space-between align-items-center" class-bg-gray="{{tab=='addresses'}}" class-f-weight-400="{{tab=='addresses'}}" href="<%SITE_URL%>/settings/?tab=addresses">
              <span><i class="icon-star2"></i> Addresses</span>
            </a>
          </li>
          <li>
            <a class="d-flex p-1 border-top-1 justify-content-space-between align-items-center" class-bg-gray="{{tab=='employments'}}" class-f-weight-400="{{tab=='employments'}}" href="<%SITE_URL%>/settings/?tab=employments">
              <span><i class="icon-folder2"></i> Employment History</span>
            </a>
          </li>
          <li>
            <a class="d-flex p-1 border-top-1 justify-content-space-between align-items-center" class-bg-gray="{{tab=='trainings'}}" class-f-weight-400="{{tab=='trainings'}}" href="<%SITE_URL%>/settings/?tab=trainings">
              <span><i class="icon-users1"></i> Training & Education</span>
            </a>
          </li>
          <li>
            <a class="d-flex p-1 border-top-1 justify-content-space-between align-items-center" class-bg-gray="{{tab=='references'}}" class-f-weight-400="{{tab=='references'}}" href="<%SITE_URL%>/settings/?tab=references">
              <span><i class="icon-call_merge"></i> References</span>
            </a>
          </li>
          <li>
            <a class="d-flex p-1 border-top-1 justify-content-space-between align-items-center" class-bg-gray="{{tab=='health'}}" class-f-weight-400="{{tab=='health'}}" href="<%SITE_URL%>/settings/?tab=health">
              <span><i class="icon-medical_services"></i> Occupational Health Section</span>
            </a>
          </li>
          <li>
            <a class="d-none p-1 border-top-1 justify-content-space-between align-items-center" class-bg-gray="{{tab=='grievances'}}" class-f-weight-400="{{tab=='grievances'}}" href="<%SITE_URL%>/settings/?tab=grievances">
              <span><i class="icon-balance-scale"></i> Grievances</span>
            </a>
          </li>
          <li>
            <a class="d-flex p-1 border-top-1 justify-content-space-between align-items-center" class-bg-gray="{{tab=='documents'}}" class-f-weight-400="{{tab=='documents'}}" href="<%SITE_URL%>/settings/?tab=documents">
              <span><i class="icon-upload"></i> Missing Documents</span>
            </a>
          </li>
          <li>
            <a class="d-flex p-1 border-top-1 justify-content-space-between align-items-center" class-bg-gray="{{tab=='policy'}}" class-f-weight-400="{{tab=='policy'}}" href="<%SITE_URL%>/settings/?tab=policy">
              <span><i class="icon-handshake-o"></i> Policy and Declaration</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-9">
      <div class="bg-white box-shadow-4 round-0_25">
        <h3 class="d-flex justify-content-space-between align-items-center f-weight-400 pv-1 ph-base border-bottom-1 bg-gray">
          <div class="d-flex align-items-center ws-nowrap o-hidden">
            <a class="btn primary small p-0_25 round-5 mr-1" href="<%SITE_URL%>/">
              <i class="icon-keyboard_arrow_left"></i>
            </a>
            <span class="ws-nowrap t-o-ellipsis o-hidden">
              {{#if tab == 'basic'}}
                Basic Information
              {{/if}}
              {{#if tab == 'password'}}
                Password Information
              {{/if}}
              {{#if tab == 'payrolls'}}
                Payroll Information
              {{/if}}
              {{#if tab == 'addresses'}}
                Addresses
              {{/if}}
              {{#if tab == 'employments'}}
                Employment History
              {{/if}}
              {{#if tab == 'trainings'}}
                Training & Education
              {{/if}}
              {{#if tab == 'references'}}
                References
              {{/if}}
              {{#if tab == 'health'}}
                Occupational Health Section
              {{/if}}
              {{#if tab == 'policy'}}
                Policy and Declaration
              {{/if}}
              {{#if tab == 'grievances'}}
                Grievances
              {{/if}}
              {{#if tab == 'documents'}}
                Missing Documents
              {{/if}}
            </span>
          </div>
          <!-- <div class="ml-1 ws-nowrap"></div> -->
        </h3>
        <div class="p-base">
          {{#if tab == 'basic'}}
            @include('settings.includes.basic')
          {{/if}}
          {{#if tab == 'password'}}
            @include('settings.includes.password')
          {{/if}}
          {{#if tab == 'payrolls'}}
            @include('settings.includes.payrolls')
          {{/if}}
          {{#if tab == 'addresses'}}
            @include('settings.includes.addresses')
          {{/if}}
          {{#if tab == 'employments'}}
            @include('settings.includes.employments')
          {{/if}}
          {{#if tab == 'trainings'}}
            @include('settings.includes.trainings')
          {{/if}}
          {{#if tab == 'references'}}
            @include('settings.includes.references')
          {{/if}}
          {{#if tab == 'health'}}
            @include('settings.includes.health')
          {{/if}}
          {{#if tab == 'policy'}}
            @include('settings.includes.policy')
          {{/if}}
          {{#if tab == 'grievances'}}
            @include('settings.includes.grievances')
          {{/if}}
          {{#if tab == 'documents'}}
            @include('settings.includes.documents')
          {{/if}}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Data.set('tab', '<%$tab%>')

  $Event.on('page.init', () => {

  })
</script>
@endsection