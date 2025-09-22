<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <link rel="icon" type="image/x-icon" href="<%SITE_URL%>/favicon.png" />
  <link rel="shortcut icon" type="image/x-icon" href="<%SITE_URL%>/favicon.png" />
  <meta name="HandheldFriendly" content="true" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

  <link rel="manifest" href="<%SITE_URL%>/manifest-admin.json" />

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
  <script type="text/javascript" src="<%SITE_URL%>/assets/js/register-admin-sw.js?v=<%ASSETS_V%>"></script>

</head>

<body class="_loading">

  <section id="app"></section>

  <section class="_spinner">
    <div class="lds-ripple">
      <div></div>
      <div></div>
    </div>
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
  </script>

</body>

</html>