<?php
$tab = Input::get('tab', 'profile');
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


@include('settings.modals.job.add')
@include('settings.modals.job.delete')
@include('settings.modals.nationality.add')
@include('settings.modals.nationality.delete')
@include('settings.modals.relationship.add')
@include('settings.modals.relationship.delete')
@include('settings.modals.training-type.add')
@include('settings.modals.training-type.delete')
@include('settings.modals.awarding-body.add')
@include('settings.modals.awarding-body.delete')
@include('settings.modals.document-type.add')
@include('settings.modals.document-type.delete')
@include('settings.modals.grievance-type.add')
@include('settings.modals.grievance-type.delete')


@section('title')
Settings -
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
            <a class="d-flex p-1 border-top-1 justify-content-space-between align-items-center" class-bg-gray="{{tab=='profile'}}" class-f-weight-400="{{tab=='profile'}}" href="<%ADMIN_URL%>/settings/?tab=profile">
              <span><i class="icon-user1"></i> Profile Settings</span>
            </a>
          </li>
          <li>
            <a class="d-flex p-1 border-top-1 justify-content-space-between align-items-center" class-bg-gray="{{tab=='password'}}" class-f-weight-400="{{tab=='password'}}" href="<%ADMIN_URL%>/settings/?tab=password">
              <span><i class="icon-lock1"></i> Password Settings</span>
            </a>
          </li>

          {{#if me.permission.settings_module.read == 'Allow'}}
            <li>
              <a class="d-flex p-1 border-top-1 justify-content-space-between align-items-center" class-bg-gray="{{tab=='company'}}" class-f-weight-400="{{tab=='company'}}" href="<%ADMIN_URL%>/settings/?tab=company">
                <span><i class="icon-dashboard1"></i> Company Settings</span>
              </a>
            </li>
            <li>
              <a class="d-flex p-1 border-top-1 justify-content-space-between align-items-center" class-bg-gray="{{tab=='job'}}" class-f-weight-400="{{tab=='job'}}" href="<%ADMIN_URL%>/settings/?tab=job">
                <span><i class="icon-file-text1"></i> Job Settings</span>
              </a>
            </li>
            <li>
              <a class="d-flex p-1 border-top-1 justify-content-space-between align-items-center" class-bg-gray="{{tab=='nationality'}}" class-f-weight-400="{{tab=='nationality'}}" href="<%ADMIN_URL%>/settings/?tab=nationality">
                <span><i class="icon-map2"></i> Nationality Settings</span>
              </a>
            </li>
            <li>
              <a class="d-flex p-1 border-top-1 justify-content-space-between align-items-center" class-bg-gray="{{tab=='relationship'}}" class-f-weight-400="{{tab=='relationship'}}" href="<%ADMIN_URL%>/settings/?tab=relationship">
                <span><i class="icon-id-card-o"></i> Relationship Settings</span>
              </a>
            </li>
            <!-- <li>
              <a class="d-flex p-1 border-top-1 justify-content-space-between align-items-center" class-bg-gray="{{tab=='training'}}" class-f-weight-400="{{tab=='training'}}" href="<%ADMIN_URL%>/settings/?tab=training">
                <span><i class="icon-model_training"></i> Training Type Settings</span>
              </a>
            </li> -->
            <!-- <li>
              <a class="d-flex p-1 border-top-1 justify-content-space-between align-items-center" class-bg-gray="{{tab=='awarding'}}" class-f-weight-400="{{tab=='awarding'}}" href="<%ADMIN_URL%>/settings/?tab=awarding">
                <span><i class="icon-star2"></i> Awarding Body Settings</span>
              </a>
            </li> -->
            <li>
              <a class="d-flex p-1 border-top-1 justify-content-space-between align-items-center" class-bg-gray="{{tab=='document'}}" class-f-weight-400="{{tab=='document'}}" href="<%ADMIN_URL%>/settings/?tab=document">
                <span><i class="icon-folder2"></i> Document Type Settings</span>
              </a>
            </li>
            <!-- <li>
              <a class="d-flex p-1 border-top-1 justify-content-space-between align-items-center" class-bg-gray="{{tab=='grievance'}}" class-f-weight-400="{{tab=='grievance'}}" href="<%ADMIN_URL%>/settings/?tab=grievance">
                <span><i class="icon-balance-scale"></i> Grievance Type Settings</span>
              </a>
            </li> -->
          {{/if}}
        </ul>
      </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-9">
      <div class="bg-white box-shadow-4 round-0_25">
        <h3 class="d-flex justify-content-space-between align-items-center f-weight-400 pv-1 ph-base border-bottom-1 bg-gray">
          <div class="d-flex align-items-center ws-nowrap o-hidden">
            <a class="btn primary small p-0_25 round-5 mr-0_5" href="<%ADMIN_URL%>/">
              <i class="icon-keyboard_arrow_left"></i>
            </a>
            {{#if tab == 'profile'}}
              Profile Settings
            {{/if}}
            {{#if tab == 'password'}}
              Password Settings
            {{/if}}

            {{#if me.permission.settings_module.read == 'Allow'}}
              {{#if tab == 'company'}}
                Company Settings
              {{/if}}
              {{#if tab == 'job'}}
                Job Settings
              {{/if}}
              {{#if tab == 'nationality'}}
                Nationality Settings
              {{/if}}
              {{#if tab == 'relationship'}}
                Relationship Settings
              {{/if}}
              {{#if tab == 'training'}}
                Training Types Settings
              {{/if}}
              {{#if tab == 'awarding'}}
                Awarding Body Settings
              {{/if}}
              {{#if tab == 'document'}}
                Document Type Settings
              {{/if}}
              {{#if tab == 'grievance'}}
                Grievance Type Settings
              {{/if}}
            {{/if}}
          </div>
          <div>
            {{#if tab != 'profile' && tab != 'password'}}
              <a class="btn primary small round-0_25 ml-0_5" href="<%ADMIN_URL%>/change-logs/?type=settings.{{tab}}"><i class="icon-info"></i></a>
            {{/if}}
          </div>
        </h3>
        <div class="p-base">
          <div class="row">
            {{#if tab == 'profile'}}
              @include('settings.includes.profile')
            {{/if}}
            {{#if tab == 'password'}}
              @include('settings.includes.password')
            {{/if}}

            {{#if me.permission.settings_module.read == 'Allow'}}
              {{#if tab == 'company'}}
                @include('settings.includes.company')
              {{/if}}
              {{#if tab == 'job'}}
                @include('settings.includes.job')
              {{/if}}
              {{#if tab == 'nationality'}}
                @include('settings.includes.nationality')
              {{/if}}
              {{#if tab == 'relationship'}}
                @include('settings.includes.relationship')
              {{/if}}
              {{#if tab == 'training'}}
                @include('settings.includes.training-type')
              {{/if}}
              {{#if tab == 'awarding'}}
                @include('settings.includes.awarding-body')
              {{/if}}
              {{#if tab == 'document'}}
                @include('settings.includes.document-type')
              {{/if}}
              {{#if tab == 'grievance'}}
                @include('settings.includes.grievance-type')
              {{/if}}
            {{/if}}
          </div>
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
</script>
@endsection