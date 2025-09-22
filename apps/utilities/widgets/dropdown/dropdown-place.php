@section('styles')
@parent
<style type="text/css">

</style>
@endsection


@section('markups')
@parent
<script id="dropdown-place.tpl" type="text/template">
  <div class="placeauto">
    <input type="text" class="controls" />
  </div>
</script>
@endsection


@section('scripts')
@parent
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=<?= GOOGLE_API_KEY ?>&libraries=places"></script>
<script type="text/javascript">
  $Tag('dropdown-place', '#dropdown-place.tpl');

  $Tag.on('render', function() {
    var self = this;
    google.maps.event.addDomListener(window, 'load', () => {
      var input = self.el.querySelector('input');
      var autocomplete = new google.maps.places.Autocomplete(input);
    });
  });
</script>
@endsection