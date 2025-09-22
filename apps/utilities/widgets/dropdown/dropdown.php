@section('markups')
@parent
<script id="dropdown.tpl" type="text/template">
  <div class="dropdown {{class}} {{$.noSelectedClass}}" class-disabled="{{disabled || !options.length}}" class-top="{{$.positionY=='top'}}" class-right="{{$.positionX=='right'}}" class-show="{{$.show}}" on-keyup="onType" style="{{style}}">
    <span class="dropdown-value">
      <button type="button" class="dropdown-select" class-placeholder="{{$.value==placeholder || $.value == 'Choose Option...'}}" class-has-icon="{{$.icon}}" class-disabled="{{disabled}}" on-click="onToggle" title="{{$.value}}" style="{{dropdownStyle}}">
        {{#if $.icon}}<i class="{{$.icon}}"></i> {{/if}}{{$.value}}
      </button>
      {{#if $.clear}}
        <button type="button" class="dropdown-reset" on-click="onRemove"><i class="icon-close"></i></button>
      {{else}}
        <button type="button" class="dropdown-reset" class-disabled="{{disabled}}" on-click="onToggle"><i class="{{$.resetIcon}}"></i></button>
      {{/if}}
    </span>

    {{#if $.show}}
      <div class="dropdown-menu" on-click="onMenuClick" style="{{dropdownStyle}}">
        {{#if search}}
          <div class="search-filter-container" style="{{dropdownStyle}}">
            <div class="search-filter-wrapper">
              <i class="icon-search"></i>
              <input class="controls" size="1" type="text" value="{{$.query}}" on-keyup="onTypeSearch" placeholder="Search..." />
            </div>
          </div>
        {{/if}}
        <div class="dropdown-options" {{#if itemHeight}}on-scroll="onScroll"{{/if}}>
          {{#each $.options:index}}
            {{#if ((index >= $.startIndex && index <= $.endIndex) && itemHeight) || !itemHeight}}
              <button type="button" title="{{label}}" class="dropdown-item {{class}} key{{index}}" class-selected="{{$.selected==index || label==$.value}}" on-click="onClick" index="{{index}}" style="height:{{itemHeight}}px;{{dropdownStyle}}" class-dyHeight="{{itemHeight}}">
                {{#if this.icon}}<i class="left-icon {{this.icon}}"></i>{{/if}}
                <div class="dropdown-text">
                  <span>{{label}} {{#if details.length}}<br><small>{{details}}</small>{{/if}}</span>
                </div>
              </button>
            {{else}}
              <div style="height:{{itemHeight}}px"></div>
            {{/if}}
          {{/each}}
        </div>
      </div>
    {{/if}}
  </div>
</script>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Tag('dropdown', '#dropdown.tpl');

  $Tag.on('init', function() {
    this.set('$.startIndex', 0);
    this.set('$.endIndex', 20);

    $Event.fire('renderDropdown', this);
    $Event.on('body.clicked', this.trigger('onHide'));
  });

  $Tag.on('onScroll', function(e) {
    e.original.stopPropagation();

    var buffer = 20;
    var items = this.get('options');
    var itemHeight = this.get('itemHeight');
    var scrollPos = e.original.target.scrollTop;

    var startIndex = parseInt(scrollPos / itemHeight);
    var endIndex = startIndex + buffer;

    this.set('$.startIndex', startIndex);
    this.set('$.endIndex', endIndex);
  });

  $Tag.observe('value', function() {
    this.fire('onChange');
  });

  $Tag.observe('options', function(options) {
    this.set('$.options', options);
    this.fire('onChange');
  });

  $Tag.on('onChange', function() {
    var value, options, selected;

    value = this.get('value');
    options = this.get('options');

    if (!value) {
      this.set('$.value', false);
      this.set('$.clear', false);
      $Event.fire('renderDropdown', this);
    }

    if (!options || !options.length) {
      return;
    }

    selected = options.filter(function(option) {
      return option.value == value ? true : false;
    });

    if (!selected.length) {
      return;
    }

    if (selected[0].icon) {
      this.set('$.icon', selected[0].icon);
    }
    this.set('$.value', selected[0].label);
    this.set('$.clear', true);
  });

  $Tag.on('onMenuClick', function(e) {
    e.original.stopPropagation();
  });

  $Tag.on('onTypeSearch', function() {
    var self = this;
    var options = self.get('options');
    var query = self.get('$.query').toLowerCase();

    var filtered = options.filter(function(option) {
      var label = option.label.toLowerCase();
      if (label.indexOf(query) !== -1) {
        return option;
      }
    });
    self.set('$.options', filtered);
  });

  $Tag.on('onShow', function(e) {
    var dropdowns = document.querySelectorAll('.dropdown');
    for (var i = 0; i < dropdowns.length; i++) {
      dropdowns[i].classList.remove('show');
    }
    this.set('$.show', true);
    $Event.fire('onDropPosition', e, this);
    this.set('$.resetIcon', 'icon-sort-up');
  });

  $Tag.on('onToggle', function(e) {
    e.original.stopPropagation();
    if (this.get('$.show')) {
      this.fire('onHide');
    } else {
      this.fire('onShow', e);
    }
  });

  $Tag.on('onHide', function() {
    this.set('$.show', false);
    this.set('$.positionY', '');
    this.set('$.positionX', '');
    this.set('$.resetIcon', 'icon-sort-down');
  });

  $Tag.on('onClear', function() {
    this.set('$.query', '');
    this.set('$.selected', -1);
    this.set('$.options', this.get('options'));
  });

  $Tag.on('onRemove', function() {
    this.fire('onClear');
    this.set('value', '');
    this.set('$.icon', '');
    this.set('$.clear', false);
    this.set('$.value', this.get('placeholder') || 'Choose Option...');
    this.fire('clear', this);
  });

  $Tag.on('onClick', function(e) {
    e.original.stopPropagation();

    var value = e.get();
    this.fire('onClear');
    var index = e.node.attrs('index');
    this.fire('onSelect', value, index);
  });

  $Tag.on('onEnter', function() {
    var options = this.get('$.options');
    var index = this.get('$.selected');
    var value = options[index];
    this.fire('onSelect', value, index);
  });

  $Tag.on('onSelect', function(value, index) {
    if (!value) return;

    this.set('value', value.value);
    this.set('$.selected', index);
    this.fire('select', this, value);
    this.fire('onHide');
  });

  $Tag.on('onType', function(e) {
    if (e.original.key === 'Escape') {
      return this.fire('onHide');
    } else if (e.original.key == 'Enter') {
      return this.fire('onEnter');
    } else if (e.original.key == 'ArrowUp') {
      return this.fire('onArrowChange', 1);
    } else if (e.original.key == 'ArrowDown') {
      return this.fire('onArrowChange', -1);
    }
  });

  $Tag.on('onArrowChange', function(direction) {
    $Event.fire('arrowChange', this, direction);
  });


  $Event.on('renderDropdown', function(self) {
    self.set('$.show', false);
    self.set('$.selected', -1);
    self.set('$.resetIcon', 'icon-sort-down');

    if (self.get('$.value') == 'empty') {
      self.set('$.value', '');
    } else if (!self.get('$.value')) {
      if (self.get('placeholder-class')) {
        self.set('$.noSelectedClass', self.get('placeholder-class'));
      }
      self.set('$.value', self.get('placeholder') || (self.name == 'dropdown-multiple' ? 'Choose Options...' : 'Choose Option...'));
    }
  });

  $Event.on('arrowChange', function(self, direction) {
    if (self.arrowPressed) {
      self.arrowPressed = 0;
      return;
    }

    var options = self.get('$.options');
    var selected = self.get('$.selected');

    if (!options.length) {
      return;
    }

    self.arrowPressed = 1;
    selected -= direction;

    if (selected < 0) {
      selected = options.length - 1;
    }

    if (selected == options.length) {
      selected = 0;
    }

    if (self.get('$.query') && self.name == 'dropdown-multiple') {
      selected = calcSelected(self, selected, direction);
    }

    self.set('$.selected', selected);
    self.el.querySelector('.dropdown.show .dropdown-menu .key' + selected).scrollIntoViewIfNeeded();
  });

  function calcSelected(self, selected, direction) {
    var visibleIndexes = [];
    var dropdownItems = self.el.querySelectorAll('.dropdown.show .dropdown-item');
    for (var i in dropdownItems) {
      var dropdownItem = dropdownItems[i];
      if (typeof dropdownItem.getAttribute === 'undefined') {
        continue;
      }
      if (!dropdownItem.classList.contains('hide')) {
        visibleIndexes.push(parseInt(dropdownItem.getAttribute('index')));
      }
    }

    var selectedItem = self.el.querySelector('.dropdown.show .dropdown-menu .key' + selected);
    if (!selectedItem) {
      if (direction == -1) {
        selected = visibleIndexes[0];
      } else {
        selected = visibleIndexes[visibleIndexes.length - 1];
      }
    } else {
      if (selectedItem.classList.contains('hide')) {
        selected -= direction;
        selected = calcSelected(self, selected, direction);
      }
    }

    return selected;
  }

  $Event.on('onDropPosition', function(e, self) {
    if (self.el.querySelector('.controls')) {
      self.el.querySelector('.controls').focus();
    }
    var parent = self.get('parent');
    if (parent) {
      var parentElem = document.querySelector(parent);
      windowWidth = parentElem.clientWidth;
      windowHeight = parentElem.clientHeight;
    }

    var clientY = e.original.clientY;

    var windowWidth = document.body.clientWidth;
    var windowHeight = document.body.clientHeight;

    var dropdownMenu = self.el.querySelector('.dropdown-menu');
    if (!dropdownMenu) {
      return;
    }

    var menuWidth = dropdownMenu.clientWidth;
    var menuLeft = dropdownMenu.parentNode.getBoundingClientRect().left;

    if ((menuLeft + menuWidth) > windowWidth) {
      self.set('$.positionX', 'right');
    } else {
      self.set('$.positionX', '');
    }

    if (clientY > (windowHeight * 0.5)) {
      self.set('$.positionY', 'top');
    } else {
      self.set('$.positionY', '');
    }
  });
</script>
@endsection