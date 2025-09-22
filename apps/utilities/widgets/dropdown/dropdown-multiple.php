@section('markups')
@parent
<script id="dropdown-multiple.tpl" type="text/template">

  <div class="dropdown {{class}}" class-disabled="{{disabled || !options.length}}" class-top="{{$.positionY=='top'}}" class-right="{{$.positionX=='right'}}" class-show="{{$.show}}" on-keyup="onType" style="{{style}}">
    <div class="dropdown-value" title="{{$.value}}">
      <button type="button" class="dropdown-select" class-placeholder="{{$.value==placeholder || $.value == 'Choose Options...'}}" class-disabled="{{disabled}}" on-click="onToggle">{{$.value}}</button>
      <button type="button" class="dropdown-reset" class-disabled="{{disabled}}" on-click="onToggle"><i class="{{$.resetIcon}}"></i></button>
    </div>

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
              <button type="button" title="{{label}}" class-hide="{{$.hiddenItems[index]}}" class="dropdown-item {{class}} key{{index}}" class-selected="{{$.selectedItems[index]}}" on-click="onClick" index="{{index}}" style="height:{{itemHeight}}px;{{dropdownStyle}}" class-dyHeight="{{itemHeight}}">
                {{#if this.icon}}<i class="left-icon {{this.icon}}"></i>{{/if}}
                <div class="dropdown-text">
                  <span>{{label}} {{#if details.length}}<br><small>{{details}}</small>{{/if}}</span>
                  {{#if $.selectedItems[index]}}<i class="icon-check"></i>{{/if}}
                </div>
              </button>
            {{/if}}
          {{else}}
            <div style="height:{{itemHeight}}px"></div>
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
  $Tag('dropdown-multiple', '#dropdown-multiple.tpl');

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

  $Tag.observe('value', function(value) {
    this.fire('onChange', false);
  });

  $Tag.observe('options', function(options) {
    if (!options) return;

    this.set('$.options', options);
    this.fire('onChange', false);
    // this.fire('onChange', true);
  });

  $Tag.on('onChange', function(isSetValue) {
    var value, selected = [],
      options, selectedItems = [];

    value = this.get('value') || [];
    options = this.get('options') || [];

    if (!options || !options.length) {
      return;
    }

    for (var i in options) {
      this.set('$.selectedItems[' + i + ']', false);
      if (value.indexOf(options[i].value) !== -1) {
        selected.push(options[i]);
        this.set('$.selectedItems[' + i + ']', true);
      }
    }

    var $value = this.get('placeholder') || 'Choose Options...';
    if (selected.length > 1) {
      $value = selected[0].label + ' +' + (selected.length - 1) + ' more';
    } else if (selected.length) {
      $value = selected[0].label;
    }

    this.set('$.value', $value);

    if (isSetValue) {
      selected.map(function(item) {
        selectedItems.push(item.value);
      });
      this.set('value', selectedItems);
    }
  });

  $Tag.on('onMenuClick', function(e) {
    e.original.stopPropagation();
  });

  $Tag.on('onTypeSearch', function() {
    var self = this;
    var options = self.get('options');
    var query = self.get('$.query').toLowerCase();

    var filtered = options.filter(function(option, i) {
      var label = option.label.toLowerCase();
      self.set('$.hiddenItems[' + i + ']', true);
      if (label.indexOf(query) !== -1) {
        self.set('$.hiddenItems[' + i + ']', false);
      }
      return option;
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

  $Tag.on('onClick', function(e) {
    e.original.stopPropagation();
    var selected = e.get();
    var index = e.node.attrs('index');
    this.fire('onSelect', selected, index);
  });

  $Tag.on('onEnter', function() {
    var options = this.get('$.options');
    var index = this.get('$.selected');
    var selected = options[index];
    this.fire('onSelect', selected, index);
  });

  $Tag.on('onSelect', function(selected, index) {
    this.toggle('$.selectedItems[' + index + ']');
    var options = this.get('$.options');
    var $selectedItems = this.get('$.selectedItems');

    var selected = options.filter(function(item, index) {
      return $selectedItems[index];
    });

    var $value = this.get('placeholder') || 'Choose Options...';
    if (selected.length > 1) {
      $value = selected[0].label + ' +' + (selected.length - 1) + ' more';
    } else if (selected.length) {
      $value = selected[0].label;
    }

    var currentItem = {};
    var selectedItems = [];
    selected.map(function(item) {
      selectedItems.push(item.value);
      currentItem = item;
    });

    this.set('$.value', $value);
    this.set('value', selectedItems);
    this.fire('select', this, currentItem);
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
</script>
@endsection