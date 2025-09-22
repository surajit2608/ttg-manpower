@extends('shared.layout')
@include('shared.events')
@include('shared.header', [
'page' => 'Assign Workers',
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


@include('workers.modals.assign')


@section('title')
Assign Workers -
@endsection


@section('styles')
@parent
<style media="screen">

</style>
@endsection


@section('content')
<div class="content">
  <div class="row align-items-center">
    <div class="col-xs-12 col-sm-6 col-md-3">
      <div class="group mb-0_5">
        <label class="mb-0_25">Job / Client:</label>
        <dropdown options="{{options_applications}}" value="{{assign.application_id}}" placeholder="Choose Job / Client" />
      </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-3">
      <div class="group mb-0_5">
        <label class="mb-0_25">Distance Radius (Mile):</label>
        <input-number value="{{assign.radius_m}}" placeholder="Enter Distance Radius" />
      </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-3">
      <div class="group mb-0_5">
        <label class="mb-0_25">From Date:</label>
        <dropdown-date value="{{assign.from_date}}" placeholder="Choose From Date" />
      </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-3">
      <div class="group mb-0_5">
        <label class="mb-0_25">To Date:</label>
        <dropdown-date value="{{assign.to_date}}" min="{{assign.from_date}}" placeholder="Choose To Date" />
      </div>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-3">
      <div class="group mb-0_5">
        <label class="mb-0_25">Shift Start Time:</label>
        <dropdown-time value="{{assign.shift_start_time}}" placeholder="Choose Shift Start Time" />
      </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-3">
      <div class="group mb-0_5">
        <label class="mb-0_25">Shift End Time:</label>
        <dropdown-time value="{{assign.shift_end_time}}" placeholder="Choose Shift End Time" />
      </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-3"></div>
    <div class="col-xs-12 col-sm-6 col-md-3">
      <div class="group mb-0_5">
        <label class="mb-0_25 hide-xs">&nbsp;&nbsp;&nbsp;</label>
        <div class="d-flex">
          <a class="btn primary round-0_25 w-100 p-0_6" on-click="onPressSearchWorkers">
            <i class="icon-search mr-0_5"></i> Search Workers
          </a>
          <a class="btn primary small round-0_25 ml-0_5" href="<%ADMIN_URL%>/change-logs/?type=worker.assignment"><i class="icon-info"></i></a>
        </div>
      </div>
    </div>
  </div>

  {{#if application}}
    <div class="d-flex justify-content-space-between align-items-center">
      <div class="group mb-0_5">
        <p><b>Job Location:</b> {{application.address}}, {{application.city}}, {{application.post_code}}, {{application.country}}</p>
      </div>
      <div class="group mb-0_5">
        <div class="d-flex">
          <input class="controls ph-0_5 pv-0_25 round-tr-0 round-br-0" value="{{search}}" placeholder="Search..." on-enter="onPressSearchWorkers" />
          {{#if search}}
            <button class="btn p-0_5 round-0 border-1" on-click="onPressClearSearch">
              <i class="icon-close"></i>
            </button>
          {{/if}}
          <button class="btn p-0_5 round-tl-0 round-bl-0 border-1" on-click="onPressSearchWorkers">
            <i class="icon-search"></i>
          </button>
        </div>
      </div>
    </div>
  {{/if}}

  <div class="table-responsive bg-white mt-0_5">
    {{#if workers_loaded && workers.length}}
      <table class="table bordered striped border-0">
        <thead>
          <tr>
            <th>
              <sorting order="{{order}}" column="account_name" on-click="onPressSearchWorkers">Name</sorting>
            </th>
            <th>
              <sorting order="{{order}}" column="distance" on-click="onPressSearchWorkers">Distance</sorting>
            </th>
            {{#each date_ranges:date}}
              <th class="t-align-center"><a>{{this.toUpperCase()}}<br />{{date}}</a></th>
            {{/each}}
            <th class="sticky-cols t-align-center" width="50px"><a>Action</a></th>
          </tr>
        </thead>
        <tbody>
          {{#each workers}}
            <tr>
              <td>{{account_name}}</td>
              <td>{{distance}} M</td>
              {{#each _availabilities:date}}
                <td class="t-align-center">
                  <label label="checkbox_{{date}}" class-color-success="{{availability=='Yes'}}" class-color-danger="{{availability=='No'}}">
                    {{#if availability=='Yes'}}
                      <input type="checkbox" id="checkbox_{{date}}" checked="{{checked}}" /><span class="ml-0_25">{{availability}}</span>
                    {{else}}
                      {{availability}}
                    {{/if}}
                  </label>
                </td>
              {{/each}}
              <td class="sticky-cols t-align-center ws-nowrap">
                <a class="btn primary d-inline small round-0_25" on-click="onPressOpenAssignModal" tooltip="Assign">
                  <i class="icon-plus"></i>
                </a>
              </td>
            </tr>
          {{/each}}
        </tbody>
      </table>
    {{/if}}

    {{#if workers_loaded && !workers.length}}
      <div class="empty">
        <i class="icon-users1"></i>
        <h3>No Workers Found</h3>
      </div>
    {{/if}}
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
  $Data.set('search', '')
  $Data.set('workers', [])
  $Data.set('workers_loaded', true)
  $Data.set('pagination.page', 1)
  $Data.set('pagination.limit', 25)
  $Data.set('order.column', 'id')
  $Data.set('order.direction', 'desc')
  $Data.set('$url', '<%ADMIN_URL%>/api/workers/search')

  $Event.on('page.init', () => {
    $Data.set('assign', {
      radius_m: 0,
      application_id: '',
      shift_start_time: '',
      shift_end_time: '',
      to_date: $Data.get('today'),
      from_date: $Data.get('today'),
    })

    $Api.get('<%ADMIN_URL%>/api/applications/options').send()
  });

  $Event.on('onPressSearchWorkers', () => {
    var params = {
      ...$Data.get('order'),
      ...$Data.get('pagination'),
      search: $Data.get('search'),
      ...$Data.get('assign'),
    }
    $Api.post('<%ADMIN_URL%>/api/workers/search').params(params).send()
  })

  $Event.on('onPressClearSearch', () => {
    $Data.set('search', '')
    $Event.fire('onPressSearchWorkers')
  })

  $Event.on('onPressOpenAssignModal', (e) => {
    let isCheckedDate = false
    const availabilities = e.get('_availabilities')
    for (const date in availabilities) {
      if (availabilities[date].checked) {
        isCheckedDate = true
        break
      }
    }
    if (!isCheckedDate) {
      $Event.fire('message.show', {
        type: 'error',
        text: 'Choose date to assign worker',
      })
      return
    }

    $Data.set('worker', e.get())
    $Event.fire('modal.open', 'assign-worker-modal')
  })
</script>
@endsection