@section('segments')
@parent
<modal id="add-skillset-modal" type="right">
  <div class="modal-header">
    <h4 class="title">{{skillset.id ? 'Edit' : 'Add'}} Skill Set</h4>
  </div>
  <div class="modal-body">
    <div class="group">
      <label>Name<small class="required">*</small>:</label>
      <input class="controls" type="text" value="{{skillset.name}}" on-enter="onPressSaveSkillset" />
    </div>
    <div class="group">
      <label>Hourly Wage<small class="required">*</small>:</label>
      <input-number value="{{skillset.wage}}" />
    </div>
    <div class="h-px-100"></div>
  </div>
  <div class="modal-footer">
    <button class="btn primary outline" target="add-skillset-modal" on-click="modal.close">Close</button>
    <button class="btn primary" on-click="onPressSaveSkillset">Save</button>
  </div>
</modal>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Event.on('onPressSaveSkillset', () => {
    var params = $Data.get('skillset')
    $Api.post('<%ADMIN_URL%>/api/skillsets/save').params(params).send()
  })

  $Event.on('add-skillset-modal.close', () => {
    $Data.set('skillset', {})
  })
</script>
@endsection