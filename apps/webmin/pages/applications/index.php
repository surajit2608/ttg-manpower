@extends('shared.layout')
@include('shared.events')
@include('shared.header', [
'page' => 'Applications',
])
@include('shared.sidebar', [
'page' => 'applications',
])


@include('widgets.input')
@include('widgets.modal')
@include('widgets.sorting')
@include('widgets.message')


@include('applications.modals.add')
@include('applications.modals.delete')


@section('title')
Applications -
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
        <input class="controls ph-0_5 pv-0_25 round-tr-0 round-br-0" value="{{search}}" placeholder="Search..." on-enter="onLoadApplications" />
        {{#if search}}
          <button class="btn p-0_5 round-0 border-1" on-click="onPressClearSearch">
            <i class="icon-close"></i>
          </button>
        {{/if}}
        <button class="btn p-0_5 round-tl-0 round-bl-0 border-1" on-click="onLoadApplications">
          <i class="icon-search"></i>
        </button>
      </div>
    </div>
    <div class="d-flex">
      {{#if me.permission.application_module.create == 'Allow'}}
        <a class="btn primary small round-0_25" on-click="modal.open" target="add-application-modal">
          <i class="icon-plus"></i><span class="ml-0_5 hide-xs">Add Application</span>
        </a>
      {{/if}}
      <a class="btn primary small round-0_25 ml-0_5" href="<%ADMIN_URL%>/change-logs/?type=application"><i class="icon-info"></i></a>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table bordered striped border-0">
      <thead>
        <tr>
          <th width="100px">
            <sorting order="{{order}}" column="applications.id" on-click="onLoadApplications">ID</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="applications.title" on-click="onLoadApplications">Title</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="jobs.name" on-click="onLoadApplications">Job Title</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="clients.business_name" on-click="onLoadApplications">Client</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="applications.address" on-click="onLoadApplications">Location</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="applications.hourly_salary" on-click="onLoadApplications">Hourly Salary</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="applications.created_at" on-click="onLoadApplications">Created At</sorting>
          </th>
          <th class="t-align-center" width="200px"><a>Action</a></th>
        </tr>
      </thead>
      <tbody>
        {{#if applications_loaded}}
          {{#each applications}}
            <tr>
              <td>{{id}}</td>
              <td>{{title}}</td>
              <td>{{job.name}}</td>
              <td>{{client.business_name}}</td>
              <td>{{address}}, {{city}}, {{post_code}}, {{country}}</td>
              <td>&#163; {{hourly_salary}}</td>
              <td>{{created_at}}</td>
              <td class="t-align-center ws-nowrap">
                <a class="btn primary d-inline small round-0_25" on-click="onPressCopyURL" tooltip="Copy URL">
                  <i class="icon-link"></i>
                </a>
                {{#if me.permission.application_module.update == 'Allow'}}
                  <a class="btn primary d-inline small round-0_25" on-click="onEditApplication" tooltip="Edit">
                    <i class="icon-edit"></i>
                  </a>
                {{/if}}
                {{#if me.permission.application_module.remove == 'Allow'}}
                  <a class="btn danger d-inline small round-0_25" on-click="onDeleteApplication" tooltip="Delete">
                    <i class="icon-trash"></i>
                  </a>
                {{/if}}
              </td>
            </tr>
          {{else}}
            <tr>
              <td colspan="7">
                <div class="empty">
                  <i class="icon-clipboard1"></i>
                  <h3>No Applications</h3>
                </div>
              </td>
            </tr>
          {{/each}}
        {{/if}}
      </tbody>
    </table>
  </div>
  {{#if applications_loaded && applications.length}}
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
  $Data.set('order.direction', 'desc')
  $Data.set('order.column', 'applications.id')
  $Data.set('$url', '<%ADMIN_URL%>/api/applications/all')

  $Event.on('page.init', () => {
    $Event.fire('onLoadApplications')
  })

  $Event.on('onLoadApplications', () => {
    var params = {
      ...$Data.get('order'),
      ...$Data.get('pagination'),
      search: $Data.get('search')
    }
    $Api.get('<%ADMIN_URL%>/api/applications/all').params(params).send()
  })

  $Event.on('onPressClearSearch', () => {
    $Data.set('search', '')
    $Event.fire('onLoadApplications')
  })

  $Event.on('onPressCopyURL', (e) => {
    copyToClipboard(`<%FULL_URL%>/application/${e.get('slug')}/`)
    $Event.fire('message.show', {
      type: 'success',
      text: 'Application URL Copied'
    })
  })

  $Event.on('onEditApplication', (e) => {
    $Data.set('application', e.get())
    $Event.fire('modal.open', 'add-application-modal')
  })

  $Event.on('onDeleteApplication', (e) => {
    $Data.set('application', e.get())
    $Event.fire('modal.open', 'delete-application-modal')
  })
</script>
@endsection