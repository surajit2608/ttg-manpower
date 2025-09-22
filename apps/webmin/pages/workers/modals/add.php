@section('segments')
@parent
<modal id="add-worker-modal" type="right">
  <div class="modal-header">
    <h4 class="title">{{worker.id ? 'Edit' : 'Add'}} Worker</h4>
  </div>
  <div class="modal-body">
    <div class="group">
      <label>Title<small class="required">*</small>:</label>
      <dropdown options="{{options_prefix}}" value="{{worker.title}}" placeholder="Choose Title" />
    </div>
    <div class="group">
      <label>First Name<small class="required">*</small>:</label>
      <input class="controls" type="text" value="{{worker.first_name}}" on-enter="onPressSaveWorker" />
    </div>
    <div class="group">
      <label>Middle Name:</label>
      <input class="controls" type="text" value="{{worker.middle_name}}" on-enter="onPressSaveWorker" />
    </div>
    <div class="group">
      <label>Last Name<small class="required">*</small>:</label>
      <input class="controls" type="text" value="{{worker.last_name}}" on-enter="onPressSaveWorker" />
    </div>
    <div class="group">
      <label>Date of Birth<small class="required">*</small>:</label>
      <dropdown-date value="{{worker.dob}}" max="{{today}}" />
    </div>
    <div class="group">
      <label>Gender<small class="required">*</small>:</label>
      <dropdown options="{{options_genders}}" value="{{worker.gender}}" placeholder="Choose Gender" />
    </div>

    <div class="group">
      <label>Email Address<small class="required">*</small>:</label>
      <input class="controls" type="text" value="{{worker.email}}" on-enter="onPressSaveWorker" />
    </div>
    <div class="group">
      <label>Phone<small class="required">*</small>:</label>
      <input type="text" class="controls" value="{{worker.phone}}" on-enter="onPressSaveWorker" />
    </div>
    <div class="group">
      <label>Username<small class="required">*</small>:</label>
      <input class="controls" type="text" value="{{worker.username}}" on-enter="onPressSaveWorker" />
    </div>
    <div class="group">
      <label>Password<small class="required">*</small>:</label>
      <input class="controls" type="password" value="{{worker.password}}" on-enter="onPressSaveWorker" />
    </div>
    <div class="group">
      <label>Password Hint:</label>
      <ul>
        <li>Password must be atleast 8 characters long.</li>
        <li>Password must be alpha-numeric.</li>
        <li>Password must contains atleast one special character.</li>
        <li>Password must contains atleast one capital letter.</li>
        <li>Password must contains atleast one small letter.</li>
      </ul>
    </div>
    <div class="h-px-100"></div>
  </div>
  <div class="modal-footer">
    <button class="btn primary outline" target="add-worker-modal" on-click="modal.close">Close</button>
    <button class="btn primary" on-click="onPressSaveWorker">Save</button>
  </div>
</modal>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Event.on('add-worker-modal.open', () => {
    $Api.get('<%ADMIN_URL%>/api/roles/options').send()
  })

  $Event.on('onPressSaveWorker', () => {
    var params = $Data.get('worker')
    $Api.post('<%ADMIN_URL%>/api/workers/save').params(params).send()
  })

  $Event.on('add-worker-modal.close', () => {
    $Data.set('worker', {})
  })
</script>
@endsection