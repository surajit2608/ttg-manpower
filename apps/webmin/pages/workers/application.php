<?php
$id = Input::get('id', 0);
if (!$id) {
  return Response::redirect(ADMIN_URL . '/workers');
}
$tab = Input::get('tab', 'basic');
?>

@extends('shared.layout')
@include('shared.events')
@include('shared.header', [
'page' => 'Application',
])
@include('shared.sidebar', [
'page' => 'workers',
])


@include('widgets.input')
@include('widgets.modal')
@include('widgets.upload')
@include('widgets.sorting')
@include('widgets.message')
@include('widgets.dropdown')


@include('workers.modals.document')
@include('workers.modals.grievance')
@include('workers.modals.application-reject')
@include('workers.modals.application-approve')
@include('workers.modals.application-archive')


@section('title')
@if($tab == 'basic')
Basic Information -
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
        <h3 class="f-weight-400 p-1 border-bottom-1 bg-gray">Application Menu</h3>
        <ul class="list-none p-0">
          <li>
            <a class="d-flex p-1 border-top-1 justify-content-space-between align-items-center" class-bg-gray="{{tab=='basic'}}" class-f-weight-400="{{tab=='basic'}}" href="<%ADMIN_URL%>/workers/application/?id={{worker.id}}&tab=basic">
              <span><i class="icon-dashboard1"></i> Basic Information</span>
            </a>
          </li>
          <li>
            <a class="d-flex p-1 border-top-1 justify-content-space-between align-items-center" class-bg-gray="{{tab=='payrolls'}}" class-f-weight-400="{{tab=='payrolls'}}" href="<%ADMIN_URL%>/workers/application/?id={{worker.id}}&tab=payrolls">
              <span><i class="icon-file-text1"></i> Payroll Information</span>
            </a>
          </li>
          <li>
            <a class="d-flex p-1 border-top-1 justify-content-space-between align-items-center" class-bg-gray="{{tab=='addresses'}}" class-f-weight-400="{{tab=='addresses'}}" href="<%ADMIN_URL%>/workers/application/?id={{worker.id}}&tab=addresses">
              <span><i class="icon-star2"></i> Addresses</span>
            </a>
          </li>
          <li>
            <a class="d-flex p-1 border-top-1 justify-content-space-between align-items-center" class-bg-gray="{{tab=='employments'}}" class-f-weight-400="{{tab=='employments'}}" href="<%ADMIN_URL%>/workers/application/?id={{worker.id}}&tab=employments">
              <span><i class="icon-folder2"></i> Employment History</span>
            </a>
          </li>
          <li>
            <a class="d-flex p-1 border-top-1 justify-content-space-between align-items-center" class-bg-gray="{{tab=='trainings'}}" class-f-weight-400="{{tab=='trainings'}}" href="<%ADMIN_URL%>/workers/application/?id={{worker.id}}&tab=trainings">
              <span><i class="icon-users1"></i> Training & Education</span>
            </a>
          </li>
          <li>
            <a class="d-flex p-1 border-top-1 justify-content-space-between align-items-center" class-bg-gray="{{tab=='references'}}" class-f-weight-400="{{tab=='references'}}" href="<%ADMIN_URL%>/workers/application/?id={{worker.id}}&tab=references">
              <span><i class="icon-call_merge"></i> References</span>
            </a>
          </li>
          <li>
            <a class="d-flex p-1 border-top-1 justify-content-space-between align-items-center" class-bg-gray="{{tab=='health'}}" class-f-weight-400="{{tab=='health'}}" href="<%ADMIN_URL%>/workers/application/?id={{worker.id}}&tab=health">
              <span><i class="icon-medical_services"></i> Occupational Health Section</span>
            </a>
          </li>
          <li>
            <a class="d-none p-1 border-top-1 justify-content-space-between align-items-center" class-bg-gray="{{tab=='grievances'}}" class-f-weight-400="{{tab=='grievances'}}" href="<%ADMIN_URL%>/workers/application/?id={{worker.id}}&tab=grievances">
              <span><i class="icon-balance-scale"></i> Grievances</span>
            </a>
          </li>
          <li>
            <a class="d-flex p-1 border-top-1 justify-content-space-between align-items-center" class-bg-gray="{{tab=='documents'}}" class-f-weight-400="{{tab=='documents'}}" href="<%ADMIN_URL%>/workers/application/?id={{worker.id}}&tab=documents">
              <span><i class="icon-upload"></i> Missing Documents</span>
            </a>
          </li>
          <li>
            <a class="d-flex p-1 border-top-1 justify-content-space-between align-items-center" class-bg-gray="{{tab=='policy'}}" class-f-weight-400="{{tab=='policy'}}" href="<%ADMIN_URL%>/workers/application/?id={{worker.id}}&tab=policy">
              <span><i class="icon-handshake-o"></i> Policy and Declaration</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-9">
      <div class="bg-white box-shadow-4 round-0_25">
        <h3 class="d-flex justify-content-space-between align-items-center f-weight-400 pv-1 ph-base border-bottom-1 bg-gray">
          {{#if worker_loaded}}
            <div class="d-flex align-items-center ws-nowrap o-hidden">
              <a class="btn primary small p-0_25 round-5 mr-1" href="<%ADMIN_URL%>/workers">
                <i class="icon-keyboard_arrow_left"></i>
              </a>
              <span class="ws-nowrap t-o-ellipsis o-hidden">
                {{worker.account_name}} -
                {{#if tab == 'basic'}}
                  Basic Information
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
            <div class="d-flex ml-1 ws-nowrap">
              <button class="btn small warning" on-click="modal.open" target="archive-worker-modal">
                <i class="icon-check-circle"></i><span class="ml-0_5 hide-xs">{{worker.status=='archived' ? 'Archived' : 'Archive'}}</span>
              </button>
              <button class="btn small success ml-0_5" {{#if worker.status != 'approved'}}on-click="modal.open" target="approve-worker-modal" {{/if}}>
                <i class="icon-check-circle"></i><span class="ml-0_5 hide-xs">{{worker.status=='approved' ? 'Approved' : 'Approve'}}</span>
              </button>
              <button class="btn small danger ml-0_5" {{#if worker.status != 'rejected'}}on-click="modal.open" target="reject-worker-modal" {{/if}}>
                <i class="icon-times-circle"></i><span class="ml-0_5 hide-xs">{{worker.status=='rejected' ? 'Rejected' : 'Reject'}}</span>
              </button>
              <a class="btn primary small round-0_25 ml-0_5" href="<%ADMIN_URL%>/change-logs/?id={{worker.id}}&type=worker.{{tab}}"><i class="icon-info"></i></a>
            </div>
          {{/if}}
        </h3>
        <div class="p-base">
          {{#if worker_loaded}}
            {{#if tab == 'basic'}}
              @include('workers.includes.basic')
            {{/if}}
            {{#if tab == 'payrolls'}}
              @include('workers.includes.payrolls')
            {{/if}}
            {{#if tab == 'addresses'}}
              @include('workers.includes.addresses')
            {{/if}}
            {{#if tab == 'employments'}}
              @include('workers.includes.employments')
            {{/if}}
            {{#if tab == 'trainings'}}
              @include('workers.includes.trainings')
            {{/if}}
            {{#if tab == 'references'}}
              @include('workers.includes.references')
            {{/if}}
            {{#if tab == 'health'}}
              @include('workers.includes.health')
            {{/if}}
            {{#if tab == 'policy'}}
              @include('workers.includes.policy')
            {{/if}}
            {{#if tab == 'grievances'}}
              @include('workers.includes.grievances')
            {{/if}}
            {{#if tab == 'documents'}}
              @include('workers.includes.documents')
            {{/if}}
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
  $Data.set('worker.id', parseInt('<%$id%>'))

  $Event.on('page.init', () => {
    var params = $Data.get('worker')
    $Api.get('<%ADMIN_URL%>/api/workers/get').params(params).send()
  })

  $Event.on('redirectTab', (tabName) => {
    $Event.fire('delay.redirect', `<%ADMIN_URL%>/workers/application/?id=${$Data.get('worker.id')}&tab=${tabName}`)
  })
</script>
@endsection