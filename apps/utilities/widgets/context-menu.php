@section('styles')
@parent
<style type="text/css">
  .context-menu {
    width: 16rem;
    display: none;
    position: fixed;
    z-index: 999999;
    transition: 0.2s display ease-in;
    box-shadow: 1px 3px 4px 0 rgba(0, 0, 0, 0.15);
  }

  .context-menu.show {
    display: block;
  }

  .context-menu .menu-options {
    z-index: 1;
    padding: 0;
    overflow: hidden;
    list-style: none;
    border-radius: 0.25rem;
    background-color: #ffffff;
  }

  .context-menu .menu-option {
    z-index: 1;
    display: flex;
    cursor: pointer;
    font-weight: 500;
    font-size: 0.9rem;
  }

  .context-menu .menu-option i {
    display: flex;
    padding: 0.5rem;
    align-items: center;
    justify-content: center;
    border: 1px solid #ffffff;
    background-color: #f7f7f7;
  }

  .context-menu .menu-option hr {
    width: 100%;
    border-bottom: none;
    border-top: 1px solid #d7d7d7;
  }

  .context-menu .menu-option a {
    flex: 1;
    padding: 0.5rem;
    align-items: center;
    border: 1px solid #ffffff;
    background-color: #ffffff;
    align-self: stretch;
    display: flex;
    justify-content: space-between;
  }

  .context-menu .menu-option:hover i,
  .context-menu .menu-option:hover a {
    background: #f7f7f7;
  }

  @keyframes move {
    from {
      transform: translate(0%);
    }

    50% {
      transform: translate(-40%);
    }

    to {
      transform: transform(0%);
    }
  }
</style>
@endsection


@section('markups')
@parent
<script id="context-menu.tpl" type="text/template">
  <div class="context-parent">
    {{yield}}
  </div>
  <div class="context-menu">
    <ul class="menu-options">
      {{#each $.options}}
        {{#if role=='separator'}}
          <li class="menu-option"><hr /></li>
        {{else}}
          <li class="menu-option" on-click="onPressItem" class-disabled="{{disabled}}">
            {{#if icon}}<i class="{{icon}}"></i>{{/if}}
            <a>{{name}}{{#if info}}<small>{{info}}</small>{{/if}}</a>
          </li>
        {{/if}}
      {{/each}}
    </ul>
  </div>
</script>
@endsection



@section('scripts')
@parent
<script type="text/javascript">
  $Tag('context-menu', '#context-menu.tpl');

  $Tag.on('render', function() {
    const menu = this.el.querySelector('.context-menu');
    const parent = this.el.querySelector('.context-parent');

    let menuVisible = false;
    const toggleMenu = visible => {
      if (visible) {
        menu.classList.add('show');
      } else {
        menu.classList.remove('show');
      }
      menuVisible = !menuVisible;
    };

    const setPosition = (e) => {
      var clientX = e.clientX;
      var clientY = e.clientY;

      var menuWidth = menu.clientWidth;
      var menuHeight = menu.clientHeight;

      var windowWidth = document.body.clientWidth;
      var windowHeight = document.body.clientHeight;

      if (clientX > (windowWidth * 0.5)) {
        menu.style.left = `${e.pageX - menuWidth}px`;
      } else {
        menu.style.left = `${e.pageX}px`;
      }

      if (clientY > (windowHeight * 0.5)) {
        menu.style.top = `${e.pageY - menuHeight}px`;
      } else {
        menu.style.top = `${e.pageY}px`;
      }

      toggleMenu(true);
    };

    window.addEventListener('click', e => {
      toggleMenu(false);
    });

    parent.addEventListener('contextmenu', e => {
      e.preventDefault();
      setPosition(e);
      return false;
    });
  });

  $Tag.observe('options', function(options) {
    this.set('$.options', options);
  });

  $Tag.on('onPressItem', function(e) {
    $Event.fire(e.get('event'));
  });
</script>
@endsection