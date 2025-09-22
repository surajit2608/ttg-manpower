@section('markups')
@parent
<script id="modal.tpl" type="text/template">
  <section id="{{id}}" class="modal {{class}} {{type}}" style="{{style}}" class-open="{{$.open}}">
    <div class="modal-content" style="width:{{width}};height:{{height}}">
      {{yield}}
    </div>
  </section>
</script>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Tag('modal', '#modal.tpl');

  $Tag.on('init', function() {

  });

  $Tag.on('onOpen', function(e) {
    this.set('$.open', true);
    document.body.classList.add('_modal');
    $Event.fire(this.get('id') + '.open');
  });

  $Tag.on('onClose', function(e) {
    this.set('$.open', false);
    document.body.classList.remove('_modal');
    $Event.fire(this.get('id') + '.close');
  });

  $Event.on('modal.open', function(data) {
    var target = data;
    if (data.node) {
      target = data.node.attrs('target');
    }
    $Tag.get(target).fire('onOpen');
  });

  $Event.on('modal.close', function(data) {
    var target = data;
    if (data.node) {
      target = data.node.attrs('target');
    }
    $Tag.get(target).fire('onClose');
  });

  document.addEventListener('keydown', function(e) {
    if (e.keyCode == 27) { // on Esc
      e.preventDefault();

      // Modal Close
      var modals = document.querySelectorAll('.modal.open');
      if (modals.length) {
        $Event.fire('modal.close', modals[modals.length - 1].getAttribute('id'));
      }
    }
  }, false);
</script>
@endsection