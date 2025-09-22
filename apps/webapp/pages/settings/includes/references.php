<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="group">
      <h4 class="f-weight-500">Please give details of <span class="color-danger">TWO</span> people who have known you for <span class="color-danger">at least FIVE years</span> and who will be willing to provide a personal character reference for you. They <span class="color-danger">cannot</span> be previous employers or relatives:</h4>
    </div>
  </div>
</div>

<div class="row">
  {{#each references:index}}
    <div class="col-xs-12 col-sm-12 col-md-12" class-border-bottom-2="{{index < references.length - 1}}" class-mb-1="{{index < references.length - 1}}">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6">
          <div class="group">
            <label>Referee Name<small class="required">*</small>:</label>
            <input type="text" class="controls" value="{{this.referee_name}}" />
          </div>
          <div class="group">
            <label>Referee Email<small class="required">*</small>:</label>
            <input type="email" class="controls" value="{{this.referee_email}}" />
          </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-6">
          <div class="group">
            <label class="d-flex justify-content-space-between align-items-center">
              <span>Referee Phone<small class="required">*</small>:</span>
              {{#if index > 1}}
                <a class="color-danger" on-click="onPressRemoveReference"><i class="icon-trash"></i></a>
              {{/if}}
            </label>
            <input type="text" class="controls" value="{{this.referee_phone}}" />
          </div>
          <div class="group">
            <label>Referee Profession<small class="required">*</small>:</label>
            <input type="text" class="controls" value="{{this.referee_profession}}" />
          </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-6">
          <div class="group">
            <label>Referee Relationship<small class="required">*</small>: <small class="color-danger ml-0_5">Note: No blood relatives acceptable</small></label>
            <dropdown options="{{options_relationships}}" value="{{this.referee_relationship_id}}" placeholder="Choose Relationship" />
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
          <div class="group">
            <label>Do this person know you for last 5 years?<small class="required">*</small>:</label>
            <dropdown options="{{options_yes_no}}" value="{{this.know_last_5years}}" />
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="group">
            <label>Referee Address<small class="required">*</small>:</label>
            <textarea class="controls" rows="4" value="{{this.referee_address}}"></textarea>
          </div>
        </div>
      </div>
    </div>
  {{/each}}
</div>

<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 mt-1">
    <div class="d-flex justify-content-space-between align-items-center">
      <div>
        <button class="btn primary" on-click="onPressSaveReferences">Save</button>
      </div>
      <div>
        <button class="btn primary outline small" on-click="onPressAddReference"><i class="icon-plus mr-0_5"></i> Add more</button>
      </div>
    </div>
  </div>
</div>


@section('scripts')
@parent
<script type="text/javascript">
  $Data.set('references', [])

  $Event.on('page.init', () => {
    if ($Data.get('tab') == 'references') {
      $Api.get('<%SITE_URL%>/api/relationships/options').send()

      var params = {
        worker_id: $Data.get('me.id'),
      }
      $Api.get('<%SITE_URL%>/api/applications/references/get').params(params).send((res) => {
        if (!$Data.get('references[0].id')) {
          $Data.set('references[0].worker_id', $Data.get('me.id'))
          $Data.set('references[1].worker_id', $Data.get('me.id'))
        }
      })
    }
  })

  $Event.on('onPressAddReference', () => {
    $Data.push('references', {
      worker_id: $Data.get('me.id'),
    })
  })

  $Event.on('onPressRemoveReference', (e) => {
    $Data.splice('references', e.get('index'), 1)
  })

  $Event.on('onPressSaveReferences', (callback) => {
    var params = $Data.get('references')
    $Api.post('<%SITE_URL%>/api/applications/references/save').params(params).send(res => {
      callback(res)
    })
  })
</script>
@endsection