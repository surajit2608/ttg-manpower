@section('markups')
@parent
<script id="input-geolocation.tpl" type="text/template">
  <div class="geolocation {{class}}" class-disabled="{{disabled}}">
    <div class="controls" style="{{style}}">{{$.value}}&nbsp;</div>
  </div>
</script>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Tag('input-geolocation', '#input-geolocation.tpl')

  $Tag.on('init', function() {
    this.fire('getLocation')
  })

  $Tag.observe('value', function(value) {
    var self = this
    if (typeof value === 'undefined') {
      return
    }
    if (!value) {
      value = []
    }

    setTimeout(function() {
      if (Array.isArray(value)) {
        self.set('$.value', value.join())
      } else {
        self.set('$.value', value)
      }
    }, 300)
  })

  $Tag.on('getLocation', function() {
    var self = this

    if (window.navigator.geolocation) {
      window.navigator.geolocation.getCurrentPosition(function(position) {
        self.fire('showPosition', position, self)
      }, function(error) {
        self.fire('showError', error, self)
      })
    } else {
      $Event.fire('message.show', {
        type: 'info',
        text: 'Geolocation is not supported by this browser',
      })
    }
  })

  $Tag.on('showPosition', function(position, self) {
    self.set('value', [position.coords.latitude, position.coords.longitude])
  })

  $Tag.on('showError', function(error, self) {
    console.log(error.message)
    switch (error.code) {
      case error.PERMISSION_DENIED:
        console.log('User denied the request for Geolocation')
        // $Event.fire('message.show', {
        //   type: 'info',
        //   text: 'User denied the request for Geolocation',
        // })
        break
      case error.POSITION_UNAVAILABLE:
        console.log('Location information is unavailable')
        // $Event.fire('message.show', {
        //   type: 'info',
        //   text: 'Location information is unavailable',
        // })
        break
      case error.TIMEOUT:
        console.log('The request to get user location timed out')
        // $Event.fire('message.show', {
        //   type: 'info',
        //   text: 'The request to get user location timed out',
        // })
        break
      case error.UNKNOWN_ERROR:
        console.log('An unknown error occurred')
        // $Event.fire('message.show', {
        //   type: 'info',
        //   text: 'An unknown error occurred',
        // })
        break
    }
  })
</script>
@endsection