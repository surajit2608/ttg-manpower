@section('segments')
@parent
<modal id="delete-skillset-modal" type="center">
  <div class="modal-header">
    <h4 class="modal-title">Delete Skill Set</h4>
  </div>
  <div class="modal-body">
    <div class="group">Are you sure you would like to delete <b>{{skillset.name}}</b>? This action can not be undone if performed.</div>
  </div>
  <div class="modal-footer">
    <button class="btn primary outline" target="delete-skillset-modal" on-click="modal.close">Close</button>
    <button class="btn primary" on-click="onPressDeleteSkillset">Delete</button>
  </div>
</modal>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Event.on('onPressDeleteSkillset', () => {
    var params = $Data.get('skillset')
    $Api.delete('<%ADMIN_URL%>/api/skillsets/delete').params(params).send()
  })

  $Event.on('delete-skillset-modal.close', () => {
    $Data.set('skillset', {})
  })
</script>
@endsection