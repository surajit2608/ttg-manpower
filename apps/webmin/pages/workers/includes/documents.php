<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="d-flex justify-content-space-between align-items-center mb-1">
      <div>
        <div class="d-flex">
          <input class="controls ph-0_5 pv-0_25 round-tr-0 round-br-0" value="{{search}}" placeholder="Search..." on-enter="onLoadDocuments" />
          {{#if search}}
            <button class="btn p-0_5 round-0 border-1" on-click="onPressClearSearch">
              <i class="icon-close"></i>
            </button>
          {{/if}}
          <button class="btn p-0_5 round-tl-0 round-bl-0 border-1" on-click="onLoadDocuments">
            <i class="icon-search"></i>
          </button>
        </div>
      </div>
      <div>
        <a class="btn primary small round-0_25" on-click="modal.open" target="add-document-modal">
          <i class="icon-plus"></i><span class="ml-0_5 hide-xs">Add Document</span>
        </a>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table bordered striped border-0">
        <thead>
          <tr>
            <th width="100px">
              <sorting order="{{order}}" column="workers_documents.id" on-click="onLoadDocuments">ID</sorting>
            </th>
            <th>
              <sorting order="{{order}}" column="document_types.name" on-click="onLoadDocuments">Document Type</sorting>
            </th>
            <th>
              <a>Document</a>
            </th>
          </tr>
        </thead>
        <tbody>
          {{#if documents_loaded}}
            {{#each documents}}
              <tr>
                <td>{{id}}</td>
                <td>{{document_type.name}}</td>
                <td>
                  <a target="_blank" href="<%FULL_URL%>{{document}}"><%FULL_URL%>{{document}}</a>
                </td>
              </tr>
            {{else}}
              <tr>
                <td colspan="5">
                  <div class="empty">
                    <i class="icon-balance-scale"></i>
                    <h3>No Documents</h3>
                  </div>
                </td>
              </tr>
            {{/each}}
          {{/if}}
        </tbody>
      </table>
    </div>
    {{#if documents_loaded && documents.length}}
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
</div>

<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 mt-1">
    <div class="d-flex justify-content-space-between align-items-center">
      <div></div>
      <div></div>
    </div>
  </div>
</div>


@section('scripts')
@parent
<script type="text/javascript">
  $Event.on('page.init', () => {
    if ($Data.get('tab') == 'documents') {
      $Data.set('search', '')
      $Data.set('documents', [])
      $Data.set('pagination.page', 1)
      $Data.set('pagination.limit', 25)
      $Data.set('order.direction', 'desc')
      $Data.set('order.column', 'workers_documents.id')
      $Data.set('$url', '<%ADMIN_URL%>/api/applications/documents/get')

      $Event.fire('onLoadDocuments')
    }
  })

  $Event.on('onLoadDocuments', () => {
    var params = {
      ...$Data.get('order'),
      ...$Data.get('pagination'),
      search: $Data.get('search'),
      worker_id: $Data.get('worker.id'),
    }
    $Api.get('<%ADMIN_URL%>/api/applications/documents/get').params(params).send()
  })

  $Event.on('onPressClearSearch', () => {
    $Data.set('search', '')
    $Event.fire('onLoadDocuments')
  })
</script>
@endsection