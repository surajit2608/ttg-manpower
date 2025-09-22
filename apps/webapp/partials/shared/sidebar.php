<?php compileScss('sidebar'); ?>

@section('styles')
@parent
<link rel="stylesheet" href="<%SITE_URL%>/assets/css/sidebar.css?v=<%ASSETS_V%>" />
@endsection

@section('sidebar')
<nav class="menu-top">
  <div class="logo mb-0">
    <a href="<%SITE_URL%>/">
      <img src="<%SITE_URL%>/assets/images/logo.png" alt="logo" />
    </a>
  </div>
  <div class="d-flex f-dir-column ph-1 pb-1">
    <input class="controls ph-0_5 pv-0_25 mr-0_5 mb-0_5" placeholder="{{!punched.in_time ? 'In' : 'Out'}} note within 50 chars" value="{{punch_note}}" on-enter="onPressPunchInOut" disabled="{{punched.out_time}}" />
    <button type="button" class="btn primary small ph-1_5 round-0_25" on-click="onPressPunchInOut" class-disabled="{{punched.out_time}}">
      <i class="icon-schedule_send"></i><span class="ml-0_5">{{!punched.in_time ? 'Punch In' : 'Punch Out'}}</span>
    </button>
  </div>
  <div>
    <a href="<%SITE_URL%>/dashboard" @if($page=='dashboard' ) class="active" @endif>
      <span><i class="icon-grid mr-0_5"></i> Dashboard</span>
    </a>
    <a href="<%SITE_URL%>/attendance" @if($page=='attendance' ) class="active" @endif>
      <span><i class="icon-schedule_send mr-0_5"></i> My Attendance</span>
    </a>
    <a href="<%SITE_URL%>/leaves" @if($page=='leaves' ) class="active" @endif>
      <span><i class="icon-calendar1 mr-0_5"></i> My Leaves</span>
    </a>
  </div>
</nav>

<nav class="menu-bottom">
  <a class="color-danger" href="<%SITE_URL%>/logout">
    <span><i class="icon-logout mr-0_5"></i> Logout</span>
  </a>
</nav>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Event.on('page.init', () => {
    $Api.get('<%SITE_URL%>/api/attendance/check').send()
  })

  $Event.on('onPressPunchInOut', (e) => {
    if (navigator.geolocation) {
      $Event.fire('showLoading')
      navigator.geolocation.getCurrentPosition((position) => {
        var params = {
          note: $Data.get('punch_note'),
          latitude: position.coords.latitude,
          longitude: position.coords.longitude,
        }
        $Api.post('<%SITE_URL%>/api/attendance/save').params(params).send()
      }, (error) => {
        switch (error.code) {
          case error.PERMISSION_DENIED:
            $Event.fire('message.show', {
              type: 'error',
              text: 'Share your location'
            })
            console.log("User denied the request for Geolocation.")
            break
          case error.POSITION_UNAVAILABLE:
            $Event.fire('message.show', {
              type: 'error',
              text: 'Share your location'
            })
            console.log("Location information is unavailable.")
            break
          case error.TIMEOUT:
            $Event.fire('message.show', {
              type: 'error',
              text: 'Share your location'
            })
            console.log("The request to get user location timed out.")
            break
          case error.UNKNOWN_ERROR:
            $Event.fire('message.show', {
              type: 'error',
              text: 'Share your location'
            })
            console.log("An unknown error occurred.")
            break
        }
        $Event.fire('hideLoading')
      })
    } else {
      $Event.fire('message.show', {
        type: 'error',
        text: 'Share your location'
      })
    }
  })
</script>
@endsection