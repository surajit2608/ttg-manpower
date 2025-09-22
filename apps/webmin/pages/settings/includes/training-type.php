<div class="col-xs-12 col-sm-12 col-md-12">
  <div class="d-flex justify-content-space-between align-items-center mb-1">
    <div>
      <div class="d-flex">
        <input class="controls ph-0_5 pv-0_25 round-tr-0 round-br-0" value="{{search}}" placeholder="Search..." on-enter="onLoadTrainingTypes" />
        {{#if search}}
          <button class="btn p-0_5 round-0 border-1" on-click="onPressClearSearch">
            <i class="icon-close"></i>
          </button>
        {{/if}}
        <button class="btn p-0_5 round-tl-0 round-bl-0 border-1" on-click="onLoadTrainingTypes">
          <i class="icon-search"></i>
        </button>
      </div>
    </div>
    <div>
      {{#if me.permission.settings_module.create == 'Allow'}}
        <a class="btn primary small round-0_25" on-click="modal.open" target="add-training-type-modal">
          <i class="icon-plus"></i><span class="ml-0_5 hide-xs">Add Training Type</span>
        </a>
      {{/if}}
    </div>
  </div>
  <div class="table-responsive">
    <table class="table bordered striped border-0">
      <thead>
        <tr>
          <th width="100px">
            <sorting order="{{order}}" column="id" on-click="onLoadTrainingTypes">ID</sorting>
          </th>
          <th>
            <sorting order="{{order}}" column="name" on-click="onLoadTrainingTypes">Training Type</sorting>
          </th>
          <th class="t-align-center" width="200px"><a>Action</a></th>
        </tr>
      </thead>
      <tbody>
        {{#if training_types_loaded}}
          {{#each training_types}}
            <tr>
              <td>{{id}}</td>
              <td>{{name}}</td>
              <td class="t-align-center ws-nowrap">
                {{#if me.permission.settings_module.update == 'Allow'}}
                  <a class="btn primary d-inline small round-0_25" on-click="onEditTrainingType" tooltip="Edit">
                    <i class="icon-edit"></i>
                  </a>
                {{/if}}
                {{#if me.permission.settings_module.remove == 'Allow'}}
                  <a class="btn danger d-inline small round-0_25" on-click="onDeleteTrainingType" tooltip="Delete">
                    <i class="icon-trash"></i>
                  </a>
                {{/if}}
              </td>
            </tr>
          {{else}}
            <tr>
              <td colspan="3">
                <div class="empty">
                  <i class="icon-model_training"></i>
                  <h3>No Training Types</h3>
                </div>
              </td>
            </tr>
          {{/each}}
        {{/if}}
      </tbody>
    </table>
  </div>
  {{#if training_types_loaded && training_types.length}}
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


@section('scripts')
@parent
<script type="text/javascript">
  $Data.set('search', '')
  $Data.set('pagination.page', 1)
  $Data.set('pagination.limit', 25)
  $Data.set('order.column', 'id')
  $Data.set('order.direction', 'desc')
  $Data.set('$url', '<%ADMIN_URL%>/api/training-types/all')

  $Event.on('page.init', () => {
    if ($Data.get('tab') == 'training') {
      $Event.fire('onLoadTrainingTypes')
    }
  })

  $Event.on('onLoadTrainingTypes', () => {
    var params = {
      ...$Data.get('order'),
      ...$Data.get('pagination'),
      search: $Data.get('search')
    }
    $Api.get('<%ADMIN_URL%>/api/training-types/all').params(params).send()
  })

  $Event.on('onPressClearSearch', () => {
    $Data.set('search', '')
    $Event.fire('onLoadTrainingTypes')
  })

  $Event.on('onEditTrainingType', (e) => {
    $Data.set('training_type', e.get())
    $Event.fire('modal.open', 'add-training-type-modal')
  })

  $Event.on('onDeleteTrainingType', (e) => {
    $Data.set('training_type', e.get())
    $Event.fire('modal.open', 'delete-training-type-modal')
  })
</script>
@endsection