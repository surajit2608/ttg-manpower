@section('header')
<section id="header">
  <div class="row">
    <div class="col-xs-6">
      <h1>
        <a class="d-none show-xs mr-0_5" on-click="onToggleSidebarMenu"><i class="icon-menu"></i></a>
        <%$page%>
      </h1>
    </div>
    <div class="col-xs-6 end-xs">
      <div class="header-right">
        <div class="relative">
          <a class="btn primary relative outline round-5 p-0_5 ml-1 o-visible" on-click="onPressOpenNotificationTray">
            <i class="icon-bell"></i>
            {{#if $unreadNotificationCount}}
              <small class="absolute d-flex align-items-center justify-content-center bg-danger color-white round-5 w-px-20 h-px-20 top--0_5 right--0_5">{{$unreadNotificationCount}}</small>
            {{/if}}
          </a>
          <div class="notification-tray absolute top-100 right-0 mt-0_75 w-px-400 t-align-left border-1 bg-white round-0_25 box-shadow-2" class-d-none="{{!$isVisibleNotification}}" class-d-block="{{$isVisibleNotification}}">
            <div class="d-flex justify-content-space-between align-items-center ph-1 pv-0_5 border-bottom-1">
              <h3 class="f-weight-400">Notifications</h3>
              <a on-click="onPressMarkAllAsRead"><small>Mark all as read</small></a>
            </div>
            <ul class="p-0 list-none h-px-max-500 o-auto">
              {{#each $notifications:index}}
                <li>
                  <a class="d-flex align-items-start p-1 border-bottom-1" on-click="onPressNotificationItem">
                    {{#if sender.image}}
                      <img src="{{sender.image}}" alt="{{sender.name_initial || 'BDC'}}" />
                    {{else}}
                      <span data-letters="{{sender.name_initial || 'BDC'}}"></span>
                    {{/if}}
                    <div class="flex-1">
                      <p class="color-base mb-0_25">{{content}}</p>
                      <span class="d-flex align-items-center justify-content-space-between">
                        <small class="color-primary">{{ago}}</small>
                        {{#if status=='unread'}}<span class="d-inline-block round-5 w-px-10 h-px-10 bg-primary mr-0_5"></span>{{/if}}
                      </span>
                    </div>
                  </a>
                </li>
              {{else}}
                <li class="ph-1 pv-5">
                  <div class="empty">
                    <i class="icon-bell"></i>
                    <h3>No Notifications</h3>
                  </div>
                </li>
              {{/each}}
            </ul>
            <div class="border-top-1 t-align-center">
              <a class="d-block p-0_5" href="<%SITE_URL%>/notifications">See all</a>
            </div>
          </div>
        </div>
        <a href="<%SITE_URL%>/settings">
          <div class="profile-info">
            <div class="user-info">
              <span>{{me.first_name}}</span>
            </div>
            {{#if me.image}}
              <img src="{{me.image}}" alt="{{me.name_initial}}" />
            {{else}}
              <span data-letters="{{me.name_initial}}"></span>
            {{/if}}
          </div>
        </a>
      </div>
    </div>
  </div>

  @if(isset($include))
  @include($include)
  @endif
</section>

{{#if $isOpenMenu}}
  <div class="sidebar-ovarlay" on-click="onToggleSidebarMenu"></div>
{{/if}}
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Data.set('$isOpenMenu', false)
  $Data.set('$isVisibleNotification', false)

  $Event.on('page.init', () => {
    $Api.get('<%SITE_URL%>/api/notifications/tray').send()
  })

  $Event.on('onToggleSidebarMenu', () => {
    $Data.toggle('$isOpenMenu')
    if ($Data.get('$isOpenMenu')) {
      document.getElementById('sidebar').classList.add('open')
    } else {
      document.getElementById('sidebar').classList.remove('open')
    }
  })

  $Event.on('body.clicked', () => {
    $Data.set('$isVisibleNotification', false)
  })

  $Event.on('onPressOpenNotificationTray', (e) => {
    $Event.fire('stopPropagation', e)
    $Data.toggle('$isVisibleNotification')
  })

  $Event.on('onPressNotificationItem', (e) => {
    var params = {
      id: e.get('id')
    }
    $Api.post('<%SITE_URL%>/api/notifications/read').params(params).send((res) => {
      if (e.get('url')) {
        $Event.fire('page.redirect', e.get('url'))
      }
    })
  })

  $Event.on('onPressMarkAllAsRead', () => {
    $Api.post('<%SITE_URL%>/api/notifications/read').send()
  })
</script>
@endsection