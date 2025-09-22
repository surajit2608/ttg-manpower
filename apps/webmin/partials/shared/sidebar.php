<?php compileScss('sidebar'); ?>

@section('styles')
@parent
<link rel="stylesheet" href="<%SITE_URL%>/assets/css/sidebar.css?v=<%ASSETS_V%>" />
@endsection

@section('sidebar')
<nav class="menu-top">
  <div class="logo">
    <a href="<%ADMIN_URL%>/">
      <img src="<%SITE_URL%>/assets/images/logo.png" alt="logo" />
    </a>
  </div>

  <div>
    <a href="<%ADMIN_URL%>/dashboard" @if($page=='dashboard' ) class="active" @endif>
      <span><i class="icon-grid mr-0_5"></i> Dashboard</span>
    </a>
    @if(isset($me->permission['application_module']))
      <a href="<%ADMIN_URL%>/applications" @if($page=='applications' ) class="active" @endif>
        <span><i class="icon-clipboard1 mr-0_5"></i> Applications</span>
      </a>
    @endif
    @if(isset($me->permission['skill_set_module']))
      <!-- <a href="<%ADMIN_URL%>/skillsets" @if($page=='skillsets' ) class="active" @endif>
        <span><i class="icon-book-open mr-0_5"></i> Skill Sets</span>
      </a> -->
    @endif
    @if(isset($me->permission['worker_module']))
      <a href="<%ADMIN_URL%>/workers" @if($page=='workers' ) class="active" @endif>
        <span><i class="icon-users1 mr-0_5"></i> Workers</span>
      </a>
    @endif
    @if(isset($me->permission['user_module']))
      <a href="<%ADMIN_URL%>/users" @if($page=='users' ) class="active" @endif>
        <span><i class="icon-user1 mr-0_5"></i> Users</span>
      </a>
    @endif
    @if(isset($me->permission['client_module']))
      <a href="<%ADMIN_URL%>/clients" @if($page=='clients' ) class="active" @endif>
        <span><i class="icon-user-check mr-0_5"></i> Clients</span>
      </a>
    @endif
    @if(isset($me->permission['holiday_module']))
      <a href="<%ADMIN_URL%>/holidays" @if($page=='holidays' ) class="active" @endif>
        <span><i class="icon-calendar1 mr-0_5"></i> Holidays</span>
      </a>
    @endif
  </div>
</nav>

<nav class="menu-bottom">
  <a class="color-danger" href="<%ADMIN_URL%>/logout">
    <span><i class="icon-logout mr-0_5"></i> Logout</span>
  </a>
</nav>
@endsection