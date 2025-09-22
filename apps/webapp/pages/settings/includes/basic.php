<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4">
    <div class="group">
      <label>Title<small class="required">*</small>:</label>
      <dropdown options="{{options_prefix}}" value="{{me.title}}" placeholder="Choose Title" />
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4">
    <div class="group">
      <label>First Name<small class="required">*</small>:</label>
      <input type="text" class="controls" value="{{me.first_name}}" />
    </div>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4">
    <div class="group">
      <label>Middle Name:</label>
      <input type="text" class="controls" value="{{me.middle_name}}" />
    </div>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4">
    <div class="group">
      <label>Last Name<small class="required">*</small>:</label>
      <input type="text" class="controls" value="{{me.last_name}}" />
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4">
    <div class="group">
      <label>Date of Birth<small class="required">*</small>:</label>
      <dropdown-date value="{{me.dob}}" max="{{today}}" />
    </div>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4">
    <div class="group">
      <label>Gender<small class="required">*</small>:</label>
      <dropdown options="{{options_genders}}" value="{{me.gender}}" placeholder="Choose Gender" />
    </div>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4">
    <div class="group">
      <label>Marital Status:</label>
      <dropdown options="{{options_marital_statuses}}" value="{{basic.marital_status}}" placeholder="Choose Marital Status" />
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4">
    <div class="group">
      <label>Profile Photo:</label>
      <div class="d-flex">
        <fancy-upload class="flex-1 m-0" value="{{me.image}}" folder="applications/dps" filename="dp" exts="image/png,image/jpeg,image/gif" size="5">
          <button class="btn primary outline block p-0_75 border-1">Browse Photo</button>
        </fancy-upload>
        {{#if me.image}}<a target="_blank" class="btn primary p-0_75 ml-1" href="<%FULL_URL%>{{me.image}}"><i class="icon-link"></i></a>{{/if}}
      </div>
    </div>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4">
    <div class="group">
      <label>Share Code:</label>
      <input type="text" class="controls" value="{{basic.share_code}}" />
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <h2 class="mb-1 mt-1 f-size-1_15 f-weight-400"><u>Contact information</u>:</h2>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4">
    <div class="group">
      <label>Email Address<small class="required">*</small>:</label>
      <input type="email" class="controls" value="{{me.email}}" />
    </div>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4">
    <div class="group">
      <label>Username<small class="required">*</small>:</label>
      <input type="text" class="controls" value="{{me.username}}" />
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4">
    <div class="group">
      <label>Phone<small class="required">*</small>:</label>
      <input type="text" class="controls" value="{{me.phone}}" />
    </div>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4">
    <div class="group">
      <label>Alternative Phone:</label>
      <input type="text" class="controls" value="{{basic.alternative_phone}}" />
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <h2 class="mb-1 mt-1 f-size-1_15 f-weight-400"><u>Identity information</u>:</h2>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4">
    <div class="group">
      <label>Nationality<small class="required">*</small>:</label>
      <dropdown options="{{options_nationalities}}" value="{{basic.nationality_id}}" placeholder="Choose Nationality" />
    </div>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4">
    <div class="group">
      <label>National Insurance Number:</label>
      <input type="text" class="controls" value="{{basic.ni_number}}" />
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4">
    <div class="group">
      <label>Passport Expiry:</label>
      <dropdown-date value="{{basic.passport_expiry}}" min="{{today}}" />
    </div>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4">
    <div class="group">
      <label>Passport Front:</label>
      <div class="d-flex">
        <fancy-upload class="flex-1 m-0" value="{{basic.passport_front}}" folder="applications/passports" filename="passport-front" exts="image/png,image/jpeg,image/gif" size="5">
          <button class="btn primary outline block p-0_75 border-1">Browse Passport Front</button>
        </fancy-upload>
        {{#if basic.passport_front}}<a target="_blank" class="btn primary p-0_75 ml-1" href="<%FULL_URL%>{{basic.passport_front}}"><i class="icon-link"></i></a>{{/if}}
      </div>
    </div>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4">
    <div class="group">
      <label>Passport Back:</label>
      <div class="d-flex">
        <fancy-upload class="flex-1 m-0" value="{{basic.passport_back}}" folder="applications/passports" filename="passport-back" exts="image/png,image/jpeg,image/gif" size="5">
          <button class="btn primary outline block p-0_75 border-1">Browse Passport Back</button>
        </fancy-upload>
        {{#if basic.passport_back}}<a target="_blank" class="btn primary p-0_75 ml-1" href="<%FULL_URL%>{{basic.passport_back}}"><i class="icon-link"></i></a>{{/if}}
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4">
    <div class="group">
      <label>VISA Type<small class="required">*</small>:</label>
      <dropdown options="{{options_visa_types}}" value="{{basic.visa_type}}" placeholder="Choose VISA Type" />
    </div>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4">
    <div class="group">
      <label>VISA Expiry<small class="required">*</small>:</label>
      <dropdown-date value="{{basic.visa_expiry}}" min="{{today}}" />
    </div>
  </div>
</div>

{{#if basic.visa_type=='Student'}}
  <div class="row">
    <div class="col-xs-12">
      <h2 class="mb-1 mt-1 f-size-1_15 f-weight-400"><u>College/University Schedules</u>:</h2>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4">
      <div class="group">
        <label>Session Start Date:</label>
        <dropdown-date value="{{class.start_date}}" />
      </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4">
      <div class="group">
        <label>Session End Date:</label>
        <dropdown-date value="{{class.end_date}}" min="{{class.start_date}}" />
      </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4">
      <div class="group">
        <label>University Letter:</label>
        <div class="d-flex">
          <fancy-upload class="flex-1 m-0" value="{{class.university_letter}}" folder="applications/letters" filename="university" exts="image/png,image/jpeg,image/gif" size="5">
            <button class="btn primary outline block p-0_75 border-1">Browse University Letter</button>
          </fancy-upload>
          {{#if class.university_letter}}<a target="_blank" class="btn primary p-0_75 ml-1" href="<%FULL_URL%>{{class.university_letter}}"><i class="icon-link"></i></a>{{/if}}
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <div class="d-flex justify-content-space-between align-items-center">
        <h2 class="mb-1 mt-1 f-size-1_15 f-weight-400"><u>Term Breaks</u>:</h2>
        <a on-click="onPressAddTermBreak"><i class="icon-plus"></i><span class="ml-0_5 hide-xs">Add Break</span></a>
      </div>
    </div>
    {{#each termbreaks}}
      <div class="col-xs-12 col-sm-6 col-md-4">
        <div class="group">
          <label>Break For:</label>
          <input type="text" class="controls" value="{{name}}" />
        </div>
      </div>
      <div class="col-xs-12 col-sm-6 col-md-4">
        <div class="group">
          <label>Break From:</label>
          <dropdown-date min="{{class.start_date}}" max="{{class.end_date}}" value="{{from}}" />
        </div>
      </div>
      <div class="col-xs-12 col-sm-6 col-md-4">
        <div class="group">
          <label>Break To:</label>
          <dropdown-date min="{{class.start_date}}" max="{{class.end_date}}" value="{{to}}" />
        </div>
      </div>
    {{else}}
      <div class="col-xs-12">
        <div class="group">
          <div class="empty p-0">
            <i class="icon-schedule_send"></i>
            <h3>No Term Breaks</h3>
          </div>
        </div>
      </div>
    {{/each}}
  </div>
  <div class="row">
    <div class="col-xs-12">
      <div class="group">
        <table class="table bordered tbl-layout-fixed">
          <tbody>
            <tr>
              <th width="150px">Day</th>
              <th>Start Time</th>
              <th>End Time</th>
            </tr>
            {{#each options_weekdays}}
              <tr>
                <th width="150px">{{label}}</th>
                <td><dropdown-time value="{{class[this.value+'_start']}}" /></td>
                <td><dropdown-time value="{{class[this.value+'_end']}}" /></td>
              </tr>
            {{/each}}
          </tbody>
        </table>
      </div>
    </div>
  </div>
{{/if}}

<div class="row">
  <div class="col-xs-12">
    <h2 class="mb-1 mt-1 f-size-1_15 f-weight-400"><u>Work Availability</u>:</h2>
  </div>
  <div class="col-xs-12">
    <div class="group">
      <table class="table bordered tbl-layout-fixed">
        <tbody>
          <tr>
            <th width="200px">Day</th>
            <th>From Time</th>
            <th>To Time</th>
          </tr>
          {{#each options_weekdays}}
            <tr>
              <th width="200px">{{label}}</th>
              <td>
                <dropdown-time value="{{availability[this.value+'_from']}}" placeholder="Choose From Time" />
              </td>
              <td>
                <dropdown-time value="{{availability[this.value+'_to']}}" placeholder="Choose To Time" />
              </td>
            </tr>
          {{/each}}
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <h2 class="mb-1 mt-1 f-size-1_15 f-weight-400"><u>Stay in UK</u>:</h2>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4">
    <div class="group">
      <label>Date of first entry to UK:</label>
      <dropdown-date value="{{basic.first_uk_entry}}" max="{{today}}" />
    </div>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4">
    <div class="group">
      <label>Do you need VISA to work or remain in UK:</label>
      <div class="d-flex">
        <label class="mr-2 f-weight-300"><input type="radio" name="{{basic.need_uk_visa}}" value="yes" class="ml-0_5" /> Yes</label>
        <label class="f-weight-300"><input type="radio" name="{{basic.need_uk_visa}}" value="no" class="ml-0_5" /> No</label>
      </div>
    </div>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4">
    <div class="group">
      <label>Upload Proof of Address<small class="required">*</small>:</label>
      <div class="d-flex">
        <fancy-upload class="flex-1 m-0" value="{{basic.address_document}}" folder="applications/addresses" filename="address" exts="image/png,image/jpeg,image/jpg" size="5">
          <button class="btn primary outline block p-0_75 border-1">Browse Driving License</button>
        </fancy-upload>
        {{#if basic.address_document}}<a target="_blank" class="btn primary p-0_75 ml-1" href="<%FULL_URL%>{{basic.address_document}}"><i class="icon-link"></i></a>{{/if}}
      </div>
      <small>Bank Statement, Credit Card Bill or Utility Bill</small>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4">
    <div class="group">
      <label>Do you have Driving License:</label>
      <div class="d-flex">
        <label class="mr-2 f-weight-300"><input type="radio" name="{{basic.have_own_transport}}" value="yes" class="ml-0_5" /> Yes</label>
        <label class="f-weight-300"><input type="radio" name="{{basic.have_own_transport}}" value="no" class="ml-0_5" /> No</label>
      </div>
    </div>
  </div>
  {{#if basic.have_own_transport == 'yes'}}
    <div class="col-xs-12 col-sm-6 col-md-4">
      <div class="group">
        <label>Driving License Type:</label>
        <dropdown options="{{options_driving_license_types}}" value="{{basic.license_type}}" placeholder="Choose License Type" />
      </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4">
      <div class="group">
        <label>Upload Driving License:</label>
        <fancy-upload class="flex-1 m-0" value="{{basic.license_document}}" folder="applications/licenses" filename="license" exts="image/png,image/jpeg,image/jpg" size="5">
          <button class="btn primary outline block p-0_75 border-1">Browse Driving License</button>
        </fancy-upload>
        {{#if basic.license_document}}<a target="_blank" class="btn primary p-0_75 ml-1" href="<%FULL_URL%>{{basic.license_document}}"><i class="icon-link"></i></a>{{/if}}
      </div>
    </div>
  {{/if}}
</div>

<div class="row">
  <div class="col-xs-12">
    <h2 class="mb-1 mt-1 f-size-1_15 f-weight-400"><u>Next of Kin</u>:</h2>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4">
    <div class="group">
      <label>Name:</label>
      <input type="text" class="controls" value="{{basic.next_of_kin_name}}" />
    </div>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4">
    <div class="group">
      <label>Relationship:</label>
      <dropdown options="{{options_relationships}}" value="{{basic.kin_relationship_id}}" placeholder="Choose Relationship" />
    </div>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4">
    <div class="group">
      <label>Phone:</label>
      <input type="text" class="controls" value="{{basic.kin_phone}}" />
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <h2 class="mb-1 mt-1 f-size-1_15 f-weight-400"><u>English Language Level</u>:</h2>
  </div>
</div>
<div class="group mb-0">
  <label>On the scale of 1 = Poor, 10 = Excellent</label>
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-4">
      <div class="group">
        <label>Spoken:</label>
        <dropdown options="{{options_spoken_lavels}}" value="{{basic.english_spoken_lavel}}" placeholder="Choose Spoken Level" />
      </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-4">
      <div class="group">
        <label>Written:</label>
        <dropdown options="{{options_written_lavels}}" value="{{basic.english_written_lavel}}" placeholder="Choose Written Level" />
      </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-4">
      <div class="group">
        <label>Reading:</label>
        <dropdown options="{{options_reading_lavels}}" value="{{basic.english_reading_lavel}}" placeholder="Choose Reading Level" />
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <h2 class="mb-1 mt-1 f-size-1_15 f-weight-400"><u>Criminal Records</u>:</h2>
  </div>
  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="group">
      <ul>
        <li class="mb-1">Have you ever been convicted of a criminal offence or found guilty by a Court of any offence in any country (excluding parking but including all motoring offences even where a spot fine has been administered by the police) or have you ever been put on probation (probation orders are now called community rehabilitation orders) or absolutely/conditionally discharged or bound over after being charged with any offence or is there any action pending against you?</li>
        <li class="mb-1">You need not declare convictions which are 'spent' under the Rehabilitation or Offenders Act 1974.</li>
        <div class="d-flex mb-1">
          <label class="mr-2 f-weight-300"><input type="radio" name="{{basic.criminal_record_1}}" value="yes" class="ml-0_5" /> Yes</label>
          <label class="f-weight-300"><input type="radio" name="{{basic.criminal_record_1}}" value="no" class="ml-0_5" /> No</label>
        </div>
        <li class="mb-1">Have you ever been convicted by a Court Martial or sentenced to detention or dismissal whist serving in the Armed Forces of the UK or any Commonwealth or foreign country?</li>
        <li class="mb-1">You need not declare convictions which are 'spent' under the Rehabalitation or Offenders Act 1974.</li>
        <div class="d-flex mb-1">
          <label class="mr-2 f-weight-300"><input type="radio" name="{{basic.criminal_record_2}}" value="yes" class="ml-0_5" /> Yes</label>
          <label class="f-weight-300"><input type="radio" name="{{basic.criminal_record_2}}" value="no" class="ml-0_5" /> No</label>
        </div>
        <li class="mb-1">Do you have any prosecutions pending?</li>
        <div class="d-flex mb-1">
          <label class="mr-2 f-weight-300"><input type="radio" name="{{basic.criminal_record_3}}" value="yes" class="ml-0_5" /> Yes</label>
          <label class="f-weight-300"><input type="radio" name="{{basic.criminal_record_3}}" value="no" class="ml-0_5" /> No</label>
        </div>
      </ul>
    </div>
    <div class="group">
      <label>Please list any unspent convictions, conditional discharges and cautions:</label>
      <textarea class="controls" rows="4" value="{{basic.unspent_convictions}}" placeholder="Date/Offence/Sentence"></textarea>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <h2 class="mb-1 mt-1 f-size-1_15 f-weight-400"><u>Registration Details</u>:</h2>
  </div>
  <div class="col-xs-12 col-sm-12 col-md-4">
    <div class="group">
      <label>Registration Date:</label>
      <dropdown-date value="{{me.registration_date}}" max="{{today}}" disabled="disabled" />
    </div>
  </div>
  <div class="col-xs-12 col-sm-12 col-md-4">
    <div class="group">
      <label>Job Applied For:</label>
      <dropdown options="{{options_applications}}" value="{{me.application_id}}" disabled="disabled" placeholder="Choose Job Applied For" />
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 mt-1">
    <div class="d-flex justify-content-space-between align-items-center">
      <div>
        <button class="btn primary" on-click="onPressSaveBasic">Save</button>
      </div>
      <div></div>
    </div>
  </div>
</div>


@section('scripts')
@parent
<script type="text/javascript">
  $Data.set('basic', null)
  $Data.set('class', null)
  $Data.set('termbreaks', [])
  $Data.set('availability', null)

  $Event.on('page.init', () => {
    if ($Data.get('tab') == 'basic') {
      $Api.get('<%SITE_URL%>/api/clients/options').send()
      $Api.get('<%SITE_URL%>/api/applications/options').send()
      $Api.get('<%SITE_URL%>/api/nationalities/options').send()
      $Api.get('<%SITE_URL%>/api/relationships/options').send()

      var params = {
        worker_id: $Data.get('me.id'),
      }
      $Api.get('<%SITE_URL%>/api/applications/basic/get').params(params).send((res) => {
        if (!$Data.get('basic.worker_id')) {
          $Data.set('basic.worker_id', $Data.get('me.id'))
        }
        if (!$Data.get('class.worker_id')) {
          $Data.set('class.worker_id', $Data.get('me.id'))
        }
        if (!$Data.get('availability.worker_id')) {
          $Data.set('availability.worker_id', $Data.get('me.id'))
        }
      })
    }
  })

  $Event.on('onPressSaveBasic', (callback) => {
    var params = {
      worker: $Data.get('me'),
      class: $Data.get('class'),
      basic: $Data.get('basic'),
      termbreaks: $Data.get('termbreaks'),
      availability: $Data.get('availability'),
    }
    $Api.post('<%SITE_URL%>/api/applications/basic/save').params(params).send(res => {
      callback(res)
    })
  })

  $Event.on('onPressAddTermBreak', () => {
    $Data.push('termbreaks', {
      name: '',
      from: '',
      to: ''
    })
  })
</script>
@endsection