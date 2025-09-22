<div class="row">
  {{#each addresses:index}}
    <div class="col-xs-12 col-sm-12 col-md-12" class-border-bottom-2="{{index < addresses.length - 1}}" class-mb-1="{{index < addresses.length - 1}}">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6">
          <div class="group">
            <label>House No & Street Address<small class="required">*</small>:</label>
            <input type="text" class="controls" value="{{this.address}}" />
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
          <div class="group">
            <label class="d-flex justify-content-space-between align-items-center">
              <span>City<small class="required">*</small>:</span>
              {{#if index > 0}}
                <a class="color-danger" on-click="onPressRemoveAddress"><i class="icon-trash"></i></a>
              {{/if}}
            </label>
            <input type="text" class="controls" value="{{this.city}}" />
          </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-6">
          <div class="group">
            <label>Post Code<small class="required">*</small>:</label>
            <input type="text" class="controls" value="{{this.post_code}}" />
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
          <div class="group">
            <label>Country<small class="required">*</small>:</label>
            <input type="text" class="controls" value="{{this.country}}" />
          </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-6">
          <div class="group">
            <label>From Date:</label>
            <dropdown-date value="{{this.from_date}}" placeholder="Choose From Date" max="{{today}}" />
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
          <div class="group">
            <label>To Date:</label>
            <dropdown-date value="{{this.to_date}}" placeholder="Choose To Date" min="{{this.from_date}}" />
          </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-4">
          <div class="group">
            <label>Utility Bill:</label>
            <div class="d-flex">
              <fancy-upload class="flex-1 m-0" value="{{this.utility_bill}}" folder="applications/addresses" filename="utility-bill" exts="image/png,image/jpeg,image/gif" size="5">
                <button class="btn primary outline block p-0_75 border-1">Browse Utility Bill</button>
              </fancy-upload>
              {{#if this.utility_bill}}<a target="_blank" class="btn primary p-0_75 ml-1" href="<%FULL_URL%>{{this.utility_bill}}"><i class="icon-link"></i></a>{{/if}}
            </div>
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4">
          <div class="group">
            <label>Bank Statement Employment:</label>
            <div class="d-flex">
              <fancy-upload class="flex-1 m-0" value="{{this.bank_statement}}" folder="applications/addresses" filename="bank-statement" exts="image/png,image/jpeg,image/gif" size="5">
                <button class="btn primary outline block p-0_75 border-1">Browse Bank Statement</button>
              </fancy-upload>
              {{#if this.bank_statement}}<a target="_blank" class="btn primary p-0_75 ml-1" href="<%FULL_URL%>{{this.bank_statement}}"><i class="icon-link"></i></a>{{/if}}
            </div>
            <small>Should not be more than 3 months old</small>
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4">
          <div class="group">
            <label>DNLA:</label>
            <div class="d-flex">
              <fancy-upload class="flex-1 m-0" value="{{this.dnla}}" folder="applications/addresses" filename="dnla" exts="image/png,image/jpeg,image/gif" size="5">
                <button class="btn primary outline block p-0_75 border-1">Browse DNLA</button>
              </fancy-upload>
              {{#if this.dnla}}<a target="_blank" class="btn primary p-0_75 ml-1" href="<%FULL_URL%>{{this.dnla}}"><i class="icon-link"></i></a>{{/if}}
            </div>
          </div>
        </div>
      </div>
    </div>
  {{/each}}
</div>

<div class="row">
  <div class="col-xs-12">
    <div class="group">
      <label>Reason for Change<small class="required">*</small>:</label>
      <textarea class="controls" rows="5" value="{{change_log.comment}}"></textarea>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 mt-1">
    <div class="d-flex justify-content-space-between align-items-center">
      <div>
        <button class="btn primary" on-click="onPressSaveAddresses">Save</button>
      </div>
      <div>
        <button class="btn primary outline small" on-click="onPressAddAddress"><i class="icon-plus mr-0_5"></i> Add more</button>
      </div>
    </div>
  </div>
</div>


@section('scripts')
@parent
<script type="text/javascript">
  $Data.set('addresses', [])
  $Data.set('change_log', null)

  $Event.on('page.init', () => {
    if ($Data.get('tab') == 'addresses') {
      var params = {
        worker_id: $Data.get('worker.id'),
      }
      $Api.get('<%ADMIN_URL%>/api/applications/addresses/get').params(params).send((res) => {
        if (!$Data.get('addresses[0].id')) {
          $Data.set('addresses[0].worker_id', $Data.get('worker.id'))
        }

        $Data.set('change_log.method', 'update')
        $Data.set('change_log.type', 'worker.addresses')
        $Data.set('change_log.user_id', $Data.get('me.id'))
        $Data.set('change_log.record_id', $Data.get('worker.id'))
      })
    }
  })

  $Event.on('onPressAddAddress', () => {
    $Data.push('addresses', {
      worker_id: $Data.get('worker.id'),
    })
  })

  $Event.on('onPressRemoveAddress', (e) => {
    $Data.splice('addresses', e.get('index'), 1)
  })

  $Event.on('onPressSaveAddresses', (callback) => {
    var params = {
      addresses: $Data.get('addresses'),
      change_log: $Data.get('change_log'),
    }
    $Api.post('<%ADMIN_URL%>/api/applications/addresses/save').params(params).send(res => {
      callback(res)
    })
  })
</script>
@endsection