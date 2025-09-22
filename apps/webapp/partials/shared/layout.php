<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8" />
  <meta name="HandheldFriendly" content="true" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <meta name="description" content="" />
  <meta name="keywords" content="" />

  <meta name="theme-color" content="" />
  <meta name="mobile-web-app-capable" content="yes" />

  <meta name="apple-mobile-web-app-title" content="" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="default" />

  <meta name="screen-orientation" content="portrait" />

  <link href="<%SITE_URL%>/favicon.png" rel="icon" type="image/png" />
  <link href="<%SITE_URL%>/favicon.png" rel="shortcut icon" type="image/x-icon" />

  <link href="" rel="apple-touch-icon" sizes="any" />
  <link href="" rel="icon" sizes="any" />

  <link rel="apple-touch-startup-image" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)" href="" />
  <link rel="apple-touch-startup-image" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)" href="" />
  <link rel="apple-touch-startup-image" media="(device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3)" href="" />
  <link rel="apple-touch-startup-image" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" href="" />
  <link rel="apple-touch-startup-image" media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2)" href="" />
  <link rel="apple-touch-startup-image" media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2)" href="" />
  <link rel="apple-touch-startup-image" media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2)" href="" />

  <link rel="manifest" href="<%SITE_URL%>/manifest.json" />

  <title>@yield('title') <%SITE_TITLE%></title>

  <link rel="stylesheet" href="<%SITE_URL%>/assets/css/flexboxgrid.min.css?v=<%ASSETS_V%>" />
  <link rel="stylesheet" href="<%SITE_URL%>/assets/css/icomoon.css?v=<%ASSETS_V%>" />
  <link rel="stylesheet" href="<%SITE_URL%>/assets/css/app.css?v=<%ASSETS_V%>" />
  <link rel="stylesheet" href="<%SITE_URL%>/assets/css/responsive.css?v=<%ASSETS_V%>" />
  <link rel="stylesheet" href="<%SITE_URL%>/assets/css/theme.css?v=<%ASSETS_V%>" />

  @yield('styles')

  <script type="text/javascript" src="<%SITE_URL%>/assets/js/jquery.min.js?v=<%ASSETS_V%>"></script>
  <script type="text/javascript" src="<%SITE_URL%>/assets/js/framework.min.js?v=<%ASSETS_V%>"></script>
  <script type="text/javascript" src="<%SITE_URL%>/assets/js/app.min.js?v=<%ASSETS_V%>"></script>
  <script type="text/javascript" src="<%SITE_URL%>/assets/js/register-sw.js?v=<%ASSETS_V%>"></script>

</head>

<body class="_loading">

  <section id="app"></section>

  <section class="_spinner">
    <div class="lds-ripple"><div></div><div></div></div>
  </section>

  
  <script id="app.tpl" type="text/template">
    <section id="sidebar">
      @yield('sidebar')
    </section>
    <section id="wrapper">
      @yield('header')
      <section id="scrollable">
        @yield('content')
      </section>
    </section>

    <section id="messages">
      {{#each $.messages:index}}
        <message type="{{type}}" text="{{text}}" index="{{index}}"></message>
      {{/each}}
    </section>

    @yield('segments')
  </script>

  @yield('markups')
  @yield('scripts')

  <script type="text/javascript">
    @if(isset($__root__) && !empty($__root__))
      @foreach($__root__ as $key => $value)
        var value = null;
        try {
          value = JSON.parse('<%%addslashes(json_encode($value))%%>');
        } catch {
          console.warn('Response File JSON Error');
        }
        $Data.set('<%$key%>', value);
      @endforeach
    @endif

    $Api.headers({
      'Auth-Session': '<%Session::getId()%>'
    });
  </script>

</body>

</html>