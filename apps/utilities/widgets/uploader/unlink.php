@section('markups')
@parent
<script id="uploader-unlink.tpl" type="text/template">
  <a class="{{class}}" on-click="onTrash">
    {{yield}}
  </a>
</script>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Tag('uploader-unlink', '#uploader-unlink.tpl');

  $Tag.on('onTrash', function() {
    var self = this;

    var value = self.get('value');

    var files = value;
    if (!Array.isArray(value)) {
      files = [value];
    }

    var params = {
      files: files,
    };
    $Api.post('<%SITE_URL%>/common/api/upload/unlink').params(params).send(function(res) {
      self.fire('remove', self, res);
      self.set('value', null);
    });
  });
</script>
@endsection