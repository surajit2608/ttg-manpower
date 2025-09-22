@include('events.core')

@section('scripts')
@parent
<script type="text/javascript">
  $Event.on('page.next', function() {
    $Event.fire('page.paginate', 1)
  })

  $Event.on('page.prev', function() {
    $Event.fire('page.paginate', -1)
  })

  $Event.on('page.refresh', function() {
    $Data.set('pagination.page', 1)
    $Event.fire('page.paginate', 0)
  })

  $Event.on('page.redirect', function(url) {
    if (window.top) {
      window.top.location = url
    } else {
      window.location = url
    }
  })

  $Event.on('page.redirect.newtab', function(url) {
    window.open(url, '_blank')
  })

  $Event.on('delay.redirect', function(url) {
    setTimeout(function() {
      window.location = url
    }, 1000)
  })

  $Event.on('delay.redirect.newtab', function(url) {
    setTimeout(function() {
      window.open(url, '_blank')
    }, 1000)
  })

  $Event.on('page.paginate', function(direction) {
    var url = $Data.get('$url')
    var method = $Data.get('$method')
    if (!method) {
      method = 'get'
    }
    var $params = $Data.get('$params')

    if (!$params) {
      $params = {}
    }

    var params = {}
    for (var key in $params) {
      params[key] = $params[key]
    }

    params.page = $Data.get('pagination.page')
    params.page = parseInt(params.page) + direction

    if (!params.page < 1) {
      $Data.set('pagination.page', params.page)
    }

    document.body.classList.add('_requesting')

    setTimeout(function() {
      $Api[method](url).params(params).send()
    }, 0)
  })

  $Event.on('page.sort', function(e) {
    var column = e.node.attrs('column')
    var order_by = $Data.get('$search.order_by')
    var order_direction = $Data.get('$search.order_direction')

    if (order_by != column) {
      order_direction = 'none'
    }

    order_by = column

    if (order_direction == 'asc') {
      order_direction = 'desc'
      $Data.set('_sort_class', 'fa-chevron-up')
    } else {
      order_direction = 'asc'
      $Data.set('_sort_class', 'fa-chevron-down')
    }

    $Data.set('pagination.page', 1)
    $Data.set('$search.order_by', order_by)
    $Data.set('$search.order_direction', order_direction)

    $Event.fire('page.paginate', 0)
  })

  $Event.on('page.focus', function(e) {
    $Data.set('pageFocused', 'focused')
  })

  $Event.on('page.esc', function(e) {
    $Data.set('pageFocused', '')
  })

  $Event.on('page.back', function(e) {
    window.history.back()
  })

  $Event.on('body.clicked', function(index) {
    $Data.set('pageFocused', '')
  })

  $Event.on('showLoading', function() {
    $Data.set('$loading', true)
    document.body.classList.add('_requesting')
  })

  $Event.on('hideLoading', function() {
    $Data.set('$loading', false)
    document.body.classList.remove('_requesting', '_loading')
  })

  var $apiLoadingTimeout = null
  $Event.on('api.init', function($request) {
    $Data.set('$loading', true)
    if (!$Api.$hideLoading) {
      document.body.classList.add('_requesting')
    }
    clearTimeout($apiLoadingTimeout)
  })

  $Event.on('api.success', function($response) {
    if (!$response) {
      return
    }

    if (!$response.data) {
      $response.data = []
    }

    if ($response.data.options) {
      $Data.set('options', $response.data.options)
    }

    for (var key in $response.data) {
      $Data.set(key, $response.data[key])
    }

    if (!$response.events) {
      $response.events = []
    }

    for (var key in $response.events) {
      $Event.fire(key, $response.events[key])
    }
  })

  $Event.on('api.finished', function() {
    clearTimeout($apiLoadingTimeout)
    $apiLoadingTimeout = setTimeout(function() {
      $Api.$hideLoading = false
      $Data.set('$loading', false)
      document.body.classList.remove('_requesting', '_loading')
    }, 300)
  })

  $Event.on('api.error', function() {
    $Data.set('loading', false)
    document.body.classList.remove('_requesting', '_loading')
  })

  $Event.on('stopPropagation', function(e) {
    e.original.stopPropagation()
  })

  $Event.on('preventDefault', function(e) {
    e.original.preventDefault();
  })

  function date(format) {
    if (!format) format = 'YYYY-MM-DD'
    return new Date().format(format)
  }

  function setCookie(cname, cvalue, exdays) {
    const d = new Date()
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000))
    let expires = "expires=" + d.toUTCString()
    document.cookie = cname + "=" + cvalue + "" + expires + "path=/"
  }

  function getCookie(cname) {
    let name = cname + "="
    let ca = document.cookie.split('')
    for (let i = 0; i < ca.length; i++) {
      let c = ca[i]
      while (c.charAt(0) == ' ') {
        c = c.substring(1)
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length)
      }
    }
    return ""
  }

  function checkCookie(cname) {
    let cvalue = getCookie(cname)
    if (cvalue) {
      return true
    }
    return false
  }

  function copyToClipboard(text) {
    var dummyElement = document.createElement("textarea");
    document.body.appendChild(dummyElement);
    dummyElement.value = text;
    dummyElement.select();
    document.execCommand("copy");
    document.body.removeChild(dummyElement);
  }

  $Data.set('today', date())

  $Data.set('options_yes_no', [{
    value: 'no',
    label: 'No'
  }, {
    value: 'yes',
    label: 'Yes'
  }])

  $Data.set('options_prefix', [{
      value: 'Mr',
      label: 'Mr',
    },
    {
      value: 'Ms',
      label: 'Ms',
    },
    {
      value: 'Mrs',
      label: 'Mrs',
    },
    {
      value: 'Miss',
      label: 'Miss',
    },
    {
      value: 'Other',
      label: 'Other',
    },
  ])

  $Data.set('options_genders', [{
      value: 'Male',
      label: 'Male'
    },
    {
      value: 'Female',
      label: 'Female'
    },
    {
      value: 'Other',
      label: 'Other'
    },
  ])

  $Data.set('options_marital_statuses', [{
      value: 'Single',
      label: 'Single'
    },
    {
      value: 'Married',
      label: 'Married'
    },
    {
      value: 'Divorced',
      label: 'Divorced'
    },
    {
      value: 'Widowed',
      label: 'Widowed'
    },
  ])

  $Data.set('options_visa_types', [{
      value: 'Student',
      label: 'Student',
    },
    {
      value: 'Dependent',
      label: 'Dependent',
    },
    {
      value: 'U National',
      label: 'U National',
    },
    {
      value: 'Youth Mobility',
      label: 'Youth Mobility',
    },
    {
      value: 'British National',
      label: 'British National',
    },
  ])

  $Data.set('options_work_availabilities', [{
      value: 'anytime',
      label: 'Any Time',
    },
    {
      value: 'morning',
      label: 'Morning',
      details: '06:00 - 14:30',
    },
    {
      value: 'day',
      label: 'Day',
      details: '14:00 - 22:30',
    },
    {
      value: 'night',
      label: 'Night',
      details: '22:00 - 06:30',
    },
  ])

  $Data.set('options_driving_license_types', [{
      value: 'Full UK Driving License',
      label: 'Full UK Driving License',
    },
    {
      value: 'Provisional Driving License',
      label: 'Provisional Driving License',
    },
  ])

  $Data.set('options_spoken_lavels', [])
  $Data.set('options_written_lavels', [])
  $Data.set('options_reading_lavels', [])
  for (let i = 1; i < 10; i++) {
    $Data.push('options_spoken_lavels', {
      value: i,
      label: i
    })
    $Data.push('options_written_lavels', {
      value: i,
      label: i,
    })
    $Data.push('options_reading_lavels', {
      value: i,
      label: i,
    })
  }

  $Data.set('options_weekdays', [{
      value: 'monday',
      label: 'Monday',
    },
    {
      value: 'tuesday',
      label: 'Tuesday',
    },
    {
      value: 'wednesday',
      label: 'Wednesday',
    },
    {
      value: 'thursday',
      label: 'Thursday',
    },
    {
      value: 'friday',
      label: 'Friday',
    },
    {
      value: 'saturday',
      label: 'Saturday',
    },
    {
      value: 'sunday',
      label: 'Sunday',
    }
  ])
</script>
@endsection