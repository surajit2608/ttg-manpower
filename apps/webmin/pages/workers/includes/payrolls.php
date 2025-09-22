<div class="row">
  {{#each payrolls:index}}
    <div class="col-xs-12 col-sm-12 col-md-12" class-border-bottom-2="{{index < payrolls.length - 1}}" class-mb-1="{{index < payrolls.length - 1}}">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6">
          <div class="group">
            <label>Account Holder Name<small class="required">*</small>:</label>
            <input type="text" class="controls" value="{{this.account_holder}}" />
          </div>
          <div class="group">
            <label>Account Number<small class="required">*</small>:</label>
            <input type="text" class="controls" value="{{this.account_number}}" />
          </div>
          <div class="group">
            <label>Sort Code<small class="required">*</small>:</label>
            <input type="text" class="controls" value="{{this.sort_code}}" />
          </div>
          <div class="group">
            <label>Bank Name<small class="required">*</small>:</label>
            <input type="text" class="controls" value="{{this.bank_name}}" />
          </div>
          <div class="group">
            <label>Other Information:</label>
            <textarea class="controls" rows="3" value="{{this.other_info}}"></textarea>
          </div>
          <div class="group">
            <label>Bank Letter:</label>
            <div class="d-flex">
              <fancy-upload class="flex-1 m-0" value="{{this.bank_letter}}" folder="applications/letters" filename="bank" exts="image/png,image/jpeg,image/gif" size="5">
                <button class="btn primary outline block p-0_75 border-1">Browse Bank Letter</button>
              </fancy-upload>
              {{#if this.bank_letter}}<a target="_blank" class="btn primary p-0_75 ml-1" href="<%FULL_URL%>{{this.bank_letter}}"><i class="icon-link"></i></a>{{/if}}
            </div>
          </div>
          <div class="group">
            <label>Primary:</label>
            <dropdown options="{{options_yes_no}}" value="{{this.primary}}" index="{{index}}" on-select="onSelectPayrollPrimary" />
          </div>
          <div class="group">
            <label>Do you have a NI Number<small class="required">*</small>:</label>
            <div class="d-flex">
              <label class="mr-2 f-weight-300"><input type="radio" name="{{this.have_ni}}" value="yes" class="ml-0_5" /> Yes</label>
              <label class="f-weight-300"><input type="radio" name="{{this.have_ni}}" value="no" class="ml-0_5" /> No</label>
            </div>
          </div>
          <div class="group">
            {{#if this.have_ni == 'yes'}}
              <label>NI Number<small class="required">*</small>:</label>
              <input type="text" class="controls" value="{{this.ni_number}}" />
            {{else}}
              <p>Please update the NI Number in 4 weeks</p>
            {{/if}}
          </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-6">
          <div class="group">
            <label class="d-flex justify-content-space-between align-items-center">
              <span>P45 Information for workers<small class="required">*</small></span>
              {{#if index > 0}}
                <a class="color-danger" on-click="onPressRemovePayroll"><i class="icon-trash"></i></a>
              {{/if}}
            </label>
            <label>Upload P45 Form from Your Previous Employer:</label>
            <div class="d-flex">
              <fancy-upload class="flex-1 m-0" value="{{this.p45_document}}" folder="applications/p45s" filename="p45" exts="image/png,image/jpeg,image/gif" size="5">
                <button class="btn primary outline block p-0_75 border-1">Browse P45 Form</button>
              </fancy-upload>
              {{#if this.p45_document}}<a target="_blank" class="btn primary p-0_75 ml-1" href="<%FULL_URL%>{{this.p45_document}}"><i class="icon-link"></i></a>{{/if}}
            </div>
          </div>

          <div class="group">
            <label class="d-flex justify-content-space-between align-items-center">
              <span>P46 Information for workers<small class="required">*</small></span>
            </label>
            <p>As a new worker your employer needs the information on this form before your first payday to tell HMRC about you and help them use the correct tax code. Fill in this form then give it to your employer.</p>
          </div>
          <div class="group">
            <label>Employee statement</label>
            <p>You need to tick only one of the following statements A, B or C.</p>
          </div>
          <div class="group">
            <label>
              <input type="radio" name="{{this.employee_statement}}" value="P46 A" class="mr-0_5" /> P46 A
            </label>
            <ul>
              <li>This is my first job since last 6 April and I have not been receiving taxable</li>
              <li>Jobseeker's Allowance, Employment and Support Allowance, taxable Incapacity</li>
              <li>Benefit, State Pension or Occupational Pension.</li>
            </ul>
          </div>
          <div class="group">
            <label>
              <input type="radio" name="{{this.employee_statement}}" value="P46 B" class="mr-0_5" /> P46 B
            </label>
            <ul>
              <li>This is now only job but since last 6 April I have had another job, or received</li>
              <li>taxable Jobseeker's Allowance, Employment and Support Allowance or taxable</li>
              <li>Incapacity Benefit. I do not receive a State Pension or Occupational Pension.</li>
            </ul>
          </div>
          <div class="group">
            <label>
              <input type="radio" name="{{this.employee_statement}}" value="P46 C" class="mr-0_5" /> P46 C
            </label>
            <ul>
              <li>As well as my new job. I have another job or receive a State Pension or Occupational</li>
            </ul>
          </div>
          <div class="group">
            <label>Upload P46 Document:</label>
            <div class="d-flex">
              <fancy-upload class="flex-1 m-0" value="{{this.p46_document}}" folder="applications/p46s" filename="p46" exts="image/png,image/jpeg,image/gif" size="5">
                <button class="btn primary outline block p-0_75 border-1">Browse P46 Document</button>
              </fancy-upload>
              {{#if this.p46_document}}<a target="_blank" class="btn primary p-0_75 ml-1" href="<%FULL_URL%>{{this.p46_document}}"><i class="icon-link"></i></a>{{/if}}
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
        <button class="btn primary" on-click="onPressSavePayrolls">Save</button>
      </div>
      <div>
        <button class="btn primary outline small" on-click="onPressAddPayroll"><i class="icon-plus mr-0_5"></i> Add more</button>
      </div>
    </div>
  </div>
</div>


@section('scripts')
@parent
<script type="text/javascript">
  $Data.set('payrolls', [])
  $Data.set('change_log', null)

  $Event.on('page.init', () => {
    if ($Data.get('tab') == 'payrolls') {
      var params = {
        worker_id: $Data.get('worker.id'),
      }
      $Api.get('<%ADMIN_URL%>/api/applications/payrolls/get').params(params).send((res) => {
        if (!$Data.get('payrolls[0].id')) {
          $Data.set('payrolls[0].worker_id', $Data.get('worker.id'))
        }

        $Data.set('change_log.method', 'update')
        $Data.set('change_log.type', 'worker.payrolls')
        $Data.set('change_log.user_id', $Data.get('me.id'))
        $Data.set('change_log.record_id', $Data.get('worker.id'))
      })
    }
  })

  $Event.on('onSelectPayrollPrimary', (e) => {
    var index = e.get('index')
    var payrolls = $Data.get('payrolls')
    for (const i in payrolls) {
      if (index == i) continue
      payrolls[i].primary = 'no'
    }
    $Data.set('payrolls', payrolls)
  })

  $Event.on('onPressAddPayroll', () => {
    $Data.push('payrolls', {
      worker_id: $Data.get('worker.id'),
    })
  })

  $Event.on('onPressRemovePayroll', (e) => {
    $Data.splice('payrolls', e.get('index'), 1)
  })

  $Event.on('onPressSavePayrolls', (callback) => {
    var params = {
      payrolls: $Data.get('payrolls'),
      change_log: $Data.get('change_log'),
    }
    $Api.post('<%ADMIN_URL%>/api/applications/payrolls/save').params(params).send(res => {
      callback(res)
    })
  })
</script>
@endsection