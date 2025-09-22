<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="group">
      <h4 class="f-weight-500">Please add Employment History of Last 5 Years. It can be your Home Country, Abroad or United Kingdom:</h4>
    </div>
  </div>
  {{#each employments:index}}
    <div class="col-xs-12 col-sm-12 col-md-12" class-border-bottom-2="{{index < employments.length - 1}}" class-mb-1="{{index < employments.length - 1}}">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="group">
            <label class="d-flex justify-content-space-between align-items-center">
              <span>Position Held/Unemployed and Claiming Benefit/Travelling/Study<small class="required">*</small>:</span>
              {{#if index > 0}}
                <a class="color-danger" on-click="onPressRemoveEmployment" class-disabled="{{employments[0].no_employment}}"><i class="icon-trash"></i></a>
              {{/if}}
            </label>
            <textarea class="controls" rows="3" value="{{this.employment_position}}" disabled="{{employments[0].no_employment}}"></textarea>
          </div>
          <div class="group">
            <label>Reason for Leaving/Status<small class="required">*</small>:</label>
            <textarea class="controls" rows="3" value="{{this.leaving_reason}}" disabled="{{employments[0].no_employment}}"></textarea>
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
          <div class="group">
            <label>Company/Personal Reference Name<small class="required">*</small>:</label>
            <input type="text" class="controls" value="{{this.reference_name}}" disabled="{{employments[0].no_employment}}" />
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
          <div class="group">
            <label>Company/Personal Reference Address<small class="required">*</small>:</label>
            <input type="text" class="controls" value="{{this.reference_address}}" disabled="{{employments[0].no_employment}}" />
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
          <div class="group">
            <label>Company/Personal Reference Phone<small class="required">*</small>:</label>
            <input type="text" class="controls" value="{{this.reference_phone}}" disabled="{{employments[0].no_employment}}" />
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
          <div class="group">
            <label>Company/Personal Reference Email Address<small class="required">*</small>:</label>
            <input type="text" class="controls" value="{{this.reference_email}}" disabled="{{employments[0].no_employment}}" />
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
          <div class="group">
            <label>From Date:</label>
            <dropdown-date value="{{this.from_date}}" placeholder="Choose From Date" max="{{today}}" disabled="{{employments[0].no_employment}}" />
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
          <div class="group">
            <label>To Date:</label>
            <dropdown-date value="{{this.to_date}}" placeholder="Choose To Date" min="{{this.from_date}}" disabled="{{employments[0].no_employment}}" />
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
          <div class="group">
            <label>Experience Letter:</label>
            <div class="d-flex">
              <fancy-upload class="flex-1 m-0" value="{{this.experience_letter}}" folder="applications/experiences" filename="experience" exts="image/png,image/jpeg,image/gif" size="5" disabled="{{employments[0].no_employment}}">
                <button class="btn primary outline block p-0_75 border-1">Browse Experience Letter</button>
              </fancy-upload>
              {{#if this.experience_letter}}<a target="_blank" class="btn primary p-0_75 ml-1" href="<%FULL_URL%>{{this.experience_letter}}"><i class="icon-link"></i></a>{{/if}}
            </div>
          </div>
        </div>
      </div>
    </div>
  {{/each}}
</div>

{{#if need_reference}}
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
      <div class="border-bottom-2 mb-1"></div>
      <div class="group">
        <h4 class="f-weight-500">Please add a Gap Reference:</h4>
      </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6">
      <div class="group">
        <label>Reference Name<small class="required">*</small>:</label>
        <input type="text" class="controls" value="{{employment.reference_name}}" />
      </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6">
      <div class="group">
        <label>Reference Phone<small class="required">*</small>:</label>
        <input type="text" class="controls" value="{{employment.reference_phone}}" />
      </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6">
      <div class="group">
        <label>Reference Email<small class="required">*</small>:</label>
        <input type="text" class="controls" value="{{employment.reference_email}}" />
      </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6">
      <div class="group">
        <label>Reference Profession<small class="required">*</small>:</label>
        <input type="text" class="controls" value="{{employment.reference_profession}}" />
      </div>
    </div>
  </div>
{{/if}}

<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 mt-1">
    <div class="group">
      <label>
        <input type="checkbox" checked="{{employments[0].no_employment}}" class="mr-1" on-change="onChangeNoEmployment" /> No Previous Employment
      </label>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 mt-1">
    <div class="d-flex justify-content-space-between align-items-center">
      <div>
        <button class="btn primary" on-click="onPressSaveEmployments">Save</button>
      </div>
      <div>
        <button class="btn primary outline small" on-click="onPressAddEmployment" disabled="{{employments[0].no_employment}}"><i class="icon-plus mr-0_5"></i> Add more</button>
      </div>
    </div>
  </div>
</div>


@section('scripts')
@parent
<script type="text/javascript">
  $Data.set('employment', {})
  $Data.set('employments', [])
  $Data.set('need_reference', false)

  $Event.on('page.init', () => {
    if ($Data.get('tab') == 'employments') {
      $Data.observe('employments', (employments) => {
        if (employments.length < 2) return
        for (var i in employments) {
          if (i == 0) continue

          var date1 = new Date(employments[i - 1].to_date)
          var date2 = new Date(employments[i].from_date)

          var millisecondsPerDay = 24 * 60 * 60 * 1000
          var timeDifferenceInMilliseconds = Math.abs(date2 - date1)

          var daysDifference = timeDifferenceInMilliseconds / millisecondsPerDay

          if (daysDifference > 14) {
            $Data.set('need_reference', true)
            break;
          } else {
            $Data.set('need_reference', false)
          }
        }
      })

      var params = {
        worker_id: $Data.get('me.id'),
      }
      $Api.get('<%SITE_URL%>/api/applications/employments/get').params(params).send((res) => {
        if ($Data.get('employment')) {
          $Data.set('need_reference', true)
        }
        if (!$Data.get('employments[0].id')) {
          $Data.set('employments[0].no_employment', 0)
          $Data.set('employments[0].worker_id', $Data.get('me.id'))
        }
      })
    }
  })

  $Event.on('onPressAddEmployment', () => {
    $Data.push('employments', {
      worker_id: $Data.get('me.id'),
    })
  })

  $Event.on('onPressRemoveEmployment', (e) => {
    $Data.splice('employments', e.get('index'), 1)
  })

  $Event.on('onChangeNoEmployment', (e) => {
    if ($Data.get('employments[0].no_employment')) {
      $Data.set('employments[0].worker_id', $Data.get('me.id'))
      $Data.set('employments[0].no_employment', 1)
      $Data.set('employments[0].employment_position', '')
      $Data.set('employments[0].leaving_reason', '')
      $Data.set('employments[0].reference_name', '')
      $Data.set('employments[0].reference_address', '')
      $Data.set('employments[0].reference_phone', '')
      $Data.set('employments[0].reference_email', '')
      $Data.set('employments[0].from_date', '')
      $Data.set('employments[0].to_date', '')
      $Data.set('employments[0].from_date', '')
      $Data.set('employments[0].experience_letter', '')
    }
  })

  $Event.on('onPressSaveEmployments', (callback) => {
    var params = {
      employments: $Data.get('employments'),
    }
    if ($Data.get('need_reference')) {
      params.employment = $Data.get('employment')
    }
    $Api.post('<%SITE_URL%>/api/applications/employments/save').params(params).send(res => {
      callback(res)
    })
  })
</script>
@endsection