@section('markups')
@parent
<script id="message.tpl" type="text/template">
  <div class="message-box message-{{type}}" class-show="{{$.show}}" on-click="close">
    <p>{{{text}}}</p>
  </div>
</script>
@endsection



@section('scripts')
@parent
<script type="text/javascript">
  $Data.set('$.messages', []);

  $Tag('message', '#message.tpl');

  $Tag.on('init', function() {
    var self = this;

    var title = self.get('type');
    title = title.replace(title.charAt(0), title.charAt(0).toUpperCase());
    self.set('title', title);

    clearTimeout(self._timer1);
    self._timer1 = setTimeout(function() {
      self.set('$.show', true);
    }, 300);

    clearTimeout(self._timer2);
    self._timer2 = setTimeout(function() {
      self.set('$.show', false);
    }, 6600);

    clearTimeout(self._timer3);
    self._timer3 = setTimeout(function() {
      $Data.pop('$.messages');
    }, 6600);
  });

  $Tag.on('close', function(e) {
    var self = this;
    var index = e.node.attrs('index');

    self.set('$.show', false);
    clearTimeout(self._timer1);
    clearTimeout(self._timer2);
    clearTimeout(self._timer3);
    self._timer3 = setTimeout(function() {
      $Data.splice('$.messages', index, 1);
    }, 600);
  });

  $Event.on('message.show', function(message) {
    if ($Data.get('$.messages').length > 2) {
      $Data.pop('$.messages');
    }
    $Data.unshift('$.messages', message);
  });
</script>
@endsection