<div class="row">
  {{#each trainings:index}}
    <div class="col-xs-12 col-sm-12 col-md-12" class-border-bottom-2="{{index < trainings.length - 1}}" class-mb-1="{{index < trainings.length - 1}}">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6">
          <div class="group">
            <label>Qualification<small class="required">*</small>:</label>
            <input type="text" class="controls" value="{{this.qualification}}" disabled="{{trainings[0].no_training}}" />
          </div>
          <div class="group">
            <label>Award Date<small class="required">*</small>:</label>
            <dropdown-date value="{{this.award_date}}" max="{{today}}" disabled="{{trainings[0].no_training}}" />
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
          <div class="group">
            <label class="d-flex justify-content-space-between align-items-center">
              <span>Institute<small class="required">*</small>:</span>
              {{#if index > 0}}
                <a class="color-danger" on-click="onPressRemoveTraining" disabled="{{trainings[0].no_training}}"><i class="icon-trash"></i></a>
              {{/if}}
            </label>
            <input type="text" class="controls" value="{{this.institute}}" disabled="{{trainings[0].no_training}}" />
          </div>
          <div class="group">
            <label>Course Length<small class="required">*</small>:</label>
            <input type="text" class="controls" value="{{this.course_length}}" disabled="{{trainings[0].no_training}}" />
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4">
          <div class="group">
            <label>Institute Contact Name<small class="required">*</small>:</label>
            <input type="text" class="controls" value="{{this.institute_contact_name}}" disabled="{{trainings[0].no_training}}" />
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4">
          <div class="group">
            <label>Institute Contact Phone<small class="required">*</small>:</label>
            <input type="text" class="controls" value="{{this.institute_contact_phone}}" disabled="{{trainings[0].no_training}}" />
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4">
          <div class="group">
            <label>Institute Contact Email<small class="required">*</small>:</label>
            <input type="text" class="controls" value="{{this.institute_contact_email}}" disabled="{{trainings[0].no_training}}" />
          </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="group">
            <label>Institute Address<small class="required">*</small>:</label>
            <textarea class="controls" rows="4" value="{{this.institute_address}}" disabled="{{trainings[0].no_training}}"></textarea>
          </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-6">
          <div class="group">
            <label>From Date:</label>
            <dropdown-date value="{{this.from_date}}" max="{{today}}" disabled="{{trainings[0].no_training}}" />
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
          <div class="group">
            <label>To Date:</label>
            <dropdown-date value="{{this.to_date}}" min="{{this.from_date}}" disabled="{{trainings[0].no_training}}" />
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
    <div class="group">
      <label>
        <input type="checkbox" checked="{{trainings[0].no_training}}" class="mr-1" on-change="onChangeNoTraining" /> No Previous Training and Education
      </label>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 mt-1">
    <div class="d-flex justify-content-space-between align-items-center">
      <div>
        <button class="btn primary" on-click="onPressSaveTrainings">Save</button>
      </div>
      <div>
        <button class="btn primary outline small" on-click="onPressAddTraining" disabled="{{trainings[0].no_training}}"><i class="icon-plus mr-0_5"></i> Add more</button>
      </div>
    </div>
  </div>
</div>


@section('scripts')
@parent
<script type="text/javascript">
  $Data.set('trainings', [])
  $Data.set('change_log', null)

  $Event.on('page.init', () => {
    if ($Data.get('tab') == 'trainings') {
      var params = {
        worker_id: $Data.get('worker.id'),
      }
      $Api.get('<%ADMIN_URL%>/api/applications/trainings/get').params(params).send((res) => {
        if (!$Data.get('trainings[0].id')) {
          $Data.set('trainings[0].no_training', 0)
          $Data.set('trainings[0].worker_id', $Data.get('worker.id'))
        }

        $Data.set('change_log.method', 'update')
        $Data.set('change_log.type', 'worker.trainings')
        $Data.set('change_log.user_id', $Data.get('me.id'))
        $Data.set('change_log.record_id', $Data.get('worker.id'))
      })
    }
  })

  $Event.on('onPressAddTraining', () => {
    $Data.push('trainings', {
      worker_id: $Data.get('worker.id'),
    })
  })

  $Event.on('onPressRemoveTraining', (e) => {
    $Data.splice('trainings', e.get('index'), 1)
  })

  $Event.on('onChangeNoTraining', (e) => {
    if ($Data.get('trainings[0].no_training')) {
      $Data.set('trainings[0].worker_id', $Data.get('worker.id'))
      $Data.set('trainings[0].no_training', 1)
      $Data.set('trainings[0].qualification', '')
      $Data.set('trainings[0].award_date', '')
      $Data.set('trainings[0].institute', '')
      $Data.set('trainings[0].course_length', '')
      $Data.set('trainings[0].institute_contact_name', '')
      $Data.set('trainings[0].institute_contact_phone', '')
      $Data.set('trainings[0].institute_contact_email', '')
      $Data.set('trainings[0].institute_address', '')
      $Data.set('trainings[0].from_date', '')
      $Data.set('trainings[0].to_date', '')
    }
  })

  $Event.on('onPressSaveTrainings', (callback) => {
    var params = {
      trainings: $Data.get('trainings'),
      change_log: $Data.get('change_log'),
    }
    $Api.post('<%ADMIN_URL%>/api/applications/trainings/save').params(params).send(res => {
      callback(res)
    })
  })
</script>
@endsection