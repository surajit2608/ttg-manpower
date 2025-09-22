<div class="col-xs-12 col-sm-12 col-md-12">
  <div class="d-flex justify-content-space-between align-items-center mb-1">
    <div>
      <div class="d-flex">
        <input class="controls ph-0_5 pv-0_25 round-tr-0 round-br-0" value="{{search}}" placeholder="Search..." on-enter="onLoadGrievances" />
        {{#if search}}
          <button class="btn p-0_5 round-0 border-1" on-click="onPressClearSearch">
            <i class="icon-close"></i>
          </button>
        {{/if}}
        <button class="btn p-0_5 round-tl-0 round-bl-0 border-1" on-click="onLoadGrievances">
          <i class="icon-search"></i>
        </button>
      </div>
    </div>
    <div>
      <a class="btn primary small round-0_25" on-click="modal.open" target="add-grievance-modal" class-disabled="{{worker.status == 'active'}}">
        <i class="icon-plus"></i><span class="ml-0_5 hide-xs">Add Grievance</span>
      </a>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table bordered striped border-0">
      <thead>
        <tr>
          <th width="100px">
            <sorting order="{{order}}" column="workers_grievances.id" on-click="onLoadGrievances">ID</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="grievance_types.name" on-click="onLoadGrievances">Grievance</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="workers_grievances.grievance_date" on-click="onLoadGrievances">Date</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="workers_grievances.grievance_time" on-click="onLoadGrievances">Time</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="workers_grievances.comments" on-click="onLoadGrievances">Comments</sorting>
          </th>
        </tr>
      </thead>
      <tbody>
        {{#if grievances_loaded}}
          {{#each grievances}}
            <tr>
              <td>{{id}}</td>
              <td>{{grievance_type.name}}</td>
              <td>{{grievance_date}}</td>
              <td>{{grievance_time}}</td>
              <td>{{comments}}</td>
            </tr>
          {{else}}
            <tr>
              <td colspan="5">
                <div class="empty">
                  <i class="icon-balance-scale"></i>
                  <h3>No Grievances</h3>
                </div>
              </td>
            </tr>
          {{/each}}
        {{/if}}
      </tbody>
    </table>
  </div>
  {{#if grievances_loaded && grievances.length}}
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

<div class="col-xs-12 col-sm-12 col-md-12 mt-1">
  <div class="d-flex justify-content-space-between align-items-center">
    <div></div>
    <div></div>
  </div>
</div>


@section('scripts')
@parent
<script type="text/javascript">
  $Event.on('page.init', () => {
    if ($Data.get('tab') == 'grievances') {
      $Data.set('search', '')
      $Data.set('grievances', [])
      $Data.set('pagination.page', 1)
      $Data.set('pagination.limit', 25)
      $Data.set('order.direction', 'desc')
      $Data.set('order.column', 'workers_grievances.id')
      $Data.set('$url', '<%SITE_URL%>/api/applications/grievances/get')

      $Event.fire('onLoadGrievances')
    }
  })

  $Event.on('onLoadGrievances', () => {
    var params = {
      ...$Data.get('order'),
      ...$Data.get('pagination'),
      search: $Data.get('search'),
      worker_id: $Data.get('me.id'),
    }
    $Api.get('<%SITE_URL%>/api/applications/grievances/get').params(params).send()
  })

  $Event.on('onPressClearSearch', () => {
    $Data.set('search', '')
    $Event.fire('onLoadGrievances')
  })
</script>
@endsection