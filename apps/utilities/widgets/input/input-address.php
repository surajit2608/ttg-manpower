@section('styles')
@parent
<style type="text/css">
  .pac-logo:after {
    height: 0;
    display: none;
  }
</style>
@endsection


@section('markups')
@parent
<script id="input-address.tpl" type="text/template">
  <input type="text" class="controls autocomplete" value="{{value}}" />
</script>
@endsection


@section('scripts')
@parent
<script src="https://maps.googleapis.com/maps/api/js?key=<?= GOOGLE_API_KEY ?>&libraries=places&callback=initAutocomplete" async defer></script>
<script type="text/javascript">
  $Tag('input-address', '#input-address.tpl');

  function initAutocomplete() {
    setTimeout(() => {
      document.querySelectorAll('.autocomplete').forEach(input => {
        let autocomplete = new google.maps.places.Autocomplete(input)

        autocomplete.addListener('place_changed', () => {
          let selectedPlace = autocomplete.getPlace()
          if (!selectedPlace.geometry) {
            console.error('No geometry available for selected place.')
            return
          }

          let address = selectedPlace.formatted_address
          if (selectedPlace.geometry.location) {
            let lat = selectedPlace.geometry.location.lat()
            let lon = selectedPlace.geometry.location.lng()
            console.log('Latitude: ', lat, 'Longitude: ', lon)
          }
        })
      })
    }, 1000)
  }

  $Tag.observe('value', (value) => {

  })
</script>
@endsection