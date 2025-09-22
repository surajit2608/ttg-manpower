<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Address Autocomplete</title>
  <style>
    #autocomplete {
      width: 300px;
      padding: 10px;
    }

    .pac-logo:after {
      height: 0;
      padding: 0;
      display: none;
    }
  </style>
</head>

<body>
  <input id="autocomplete" placeholder="Enter your address" />

  <script>
    function initAutocomplete() {
      const input = document.getElementById('autocomplete')
      const autocomplete = new google.maps.places.Autocomplete(input)

      autocomplete.addListener('place_changed', () => {
        const selectedPlace = autocomplete.getPlace()
        if (!selectedPlace.geometry) {
          console.error('No geometry available for selected place.')
          return
        }

        const address = selectedPlace.formatted_address
        console.log('Selected Address:', address)

        // If you want to get geographic coordinates (latitude and longitude)
        if (selectedPlace.geometry.location) {
          const lat = selectedPlace.geometry.location.lat()
          const lon = selectedPlace.geometry.location.lng()
          console.log('Latitude:', lat)
          console.log('Longitude:', lon)
        }
      })
    }
  </script>
  <script src="https://maps.googleapis.com/maps/api/js?key=<?= GOOGLE_API_KEY ?>&libraries=places&callback=initAutocomplete" async defer></script>
</body>

</html>