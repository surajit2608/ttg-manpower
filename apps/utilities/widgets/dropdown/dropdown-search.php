<?php
$isAdmin = false;
if (Request::is('/-builder/')) {
  $isAdmin = true;
}
?>

@section('styles')
@parent
<style type="text/css">
  .dropdown-wrapper {
    flex: 1;
    display: flex;
  }

  .dropdown-wrapper .dropdown {
    flex: 1;
  }

  .dropdown-wrapper .add-new-btn {
    align-self: stretch;
    margin-left: 0.5rem;
  }
</style>
@endsection


@section('markups')
@parent
<script id="dropdown-search.tpl" type="text/template">
  <div class="dropdown-wrapper">
    <div class="dropdown {{class}}" class-disabled="{{disabled}}" class-top="{{$.positionY=='top'}}" class-right="{{$.positionX=='right'}}" class-show="{{$.show}}" on-keyup="onType" style="{{style}}">
      <span class="dropdown-value">
        <button type="button" class="dropdown-select" class-disabled="{{disabled}}" on-click="onToggle" title="{{$.value}}">
          {{#if $.icon}}<i class="{{$.icon}}"></i> {{/if}}{{$.value ? $.value : placeholder}}
        </button>

        {{#if $.value && $.value != placeholder}}
          <button type="button" class="dropdown-reset" on-click="onClear"><i class="icon-close"></i></button>
        {{else}}
          <button type="button" class="dropdown-reset" class-disabled="{{disabled}}" on-click="onToggle"><i class="{{$.resetIcon}}"></i></button>
        {{/if}}
      </span>

      {{#if $.show}}
        <div class="dropdown-menu" on-click="onMenuClick" style="{{dropdownStyle}}">
          <div class="search-filter-container" style="{{dropdownStyle}}">
            <div class="search-filter-wrapper">
              <i class="icon-search"></i>
              <input class="controls" size="1" type="text" value="{{$.query}}" on-keyup="onTypeSearch" placeholder="Search..." />
            </div>
            {{#if options.length > $.limit}}
              <div class="search-pagination">
                <a style="border:0" on-click="onPressPrevSearchData"><i class="icon-angle-left"></i></a>
                <a style="border:0" on-click="onPressNextSearchData"><i class="icon-angle-right"></i></a>
              </div>
            {{/if}}
          </div>

          <div class="dropdown-options">
            {{#each $.options:index}}
              <button title="{{label}}" type="button" class="dropdown-item {{class}} key{{index}}" on-click="onClick" index="{{index}}" style="{{dropdownStyle}}" class-dyHeight="{{itemHeight}}">
                {{#if icon}}<i class="left-icon {{icon}}"></i>{{/if}}
                <div class="dropdown-text">
                  <span>
                    {{label}}
                    {{#if details.length}}<br><small>{{details}}</small>{{/if}}
                  </span>
                </div>
              </button>
            {{/each}}
          </div>
        </div>
      {{/if}}
    </div>

    {{#if $.addNewRecord}}
      <button type="button" class="btn btn-save add-new-btn" style="{{buttonStyle}}" on-click="onToggleNewDropdownItem" id="btn_entity_{{parentEntity}}" event-type="menu_button" event-id="entity_{{parentEntity}}" entity-id="0" record-id="0"><i class="icon-plus"></i></button>
    {{/if}}
  </div>
</script>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Tag('dropdown-search', '#dropdown-search.tpl');

  $Tag.on('onToggleNewDropdownItem', function(self) {
    $Event.fire('onPressViewForwardEvent', self);
  });

  $Tag.on('onSetOptions', function() {
    var options = this.get('options') || [],
      $options = [];
    this.skip = parseInt(this.limit) * (parseInt(this.page) - 1);

    var itemCount = this.get('options').length;
    var loop = this.skip + this.limit;
    if (loop > itemCount) {
      loop = itemCount;
    }

    for (var i = this.skip; i < loop; i++) {
      $options.push(options[i]);
    }

    this.set('$.options', $options);
    if (this.get('$.show')) {
      this.el.querySelector('.dropdown-options').scrollTop = 0;
    }
  });

  $Tag.on('onPressPrevSearchData', function() {
    var options = this.get('options');
    if (this.page <= 1) {
      return;
    }

    this.page--;
    this.fire('onSetOptions');
  });

  $Tag.on('onPressNextSearchData', function() {
    var options = this.get('options');
    if (options.length <= this.page * this.limit) {
      return;
    }

    this.page++;
    this.fire('onSetOptions');
  });

  $Tag.observe('url', function(url) {
    var self = this;

    self.page = 1;
    self.set('options', []);
    self.limit = self.get('limit') || 25;
    self.set('$.limit', self.limit);
    if (!self.get('placeholder')) {
      this.set('placeholder', 'Choose Option...');
    }

    var params = {};
    var url = self.get('url');
    $Api.$hideLoading = true;
    $Api.post(url).params(params).send(function(res) {
      self.set('options', res.data);
      self.fire('onSetOptions');
      self.fire('select', self, self.get('value'));
    });

    $Event.fire('renderDropdown', self);
    $Event.on('body.clicked', self.trigger('onHide'));
  });

  $Tag.observe('options', function(options) {
    if (!options) return;
    this.fire('onChange');
  });

  $Tag.observe('value', function(value) {
    if (!value) {
      this.set('$.value', this.get('placeholder') || '');
      return;
    }
    this.fire('onChange');
  });

  $Tag.observe('addNewRecord', function(addNewRecord) {
    this.set('$.addNewRecord', addNewRecord);
  });

  $Tag.on('onChange', function() {
    var $value = {};
    var value = this.get('value') || {};
    if (value && value.value) {
      value = value.value;
    }
    var options = this.get('options') || [];
    if (options.length) {
      var selected = options.findIndex(function(option) {
        return option.value == value;
      });

      if (selected === -1) {
        $value.value = '';
        $value.label = '';
      } else {
        $value.value = options[selected].value;
        $value.label = options[selected].label;
      }

      this.set('value', $value.value);
      this.set('$.value', $value.label);
      this.fire('select', this, $value);
    }
  })

  $Tag.on('onClear', function() {
    this.set('value', '');
    this.set('$.icon', '');
    this.set('$.query', '');
    this.set('$.selected', -1);
    this.set('$.value', this.get('placeholder'));
  });

  $Tag.on('onToggle', function(e) {
    e.original.stopPropagation();
    if (this.get('$.show')) {
      this.fire('onHide');
    } else {
      this.fire('onShow', e);
    }
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

  $Tag.on('onHide', function() {
    this.set('$.query', '');
    this.set('$.show', false);
    this.set('$.positionY', '');
    this.set('$.positionX', '');
    this.set('$.resetIcon', 'icon-sort-down');
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

  $Tag.on('onMenuClick', function(e) {
    e.original.stopPropagation();
  });

  $Tag.on('onTypeSearch', function(e) {
    var self = this;
    clearTimeout(self.timer);
    self.timer = setTimeout(function() {
      self.page = 1;
      var url = self.get('url');
      $Api.$hideLoading = true;
      var params = {
        q: self.get('$.query'),
      };
      $Api.post(url).params(params).send(function(res) {
        self.set('options', res.data);
        self.fire('onSetOptions');
        self.fire('select', self, self.get('value'));
      });
    }, 300);
  });

  $Tag.on('onArrowChange', function(direction) {
    $Event.fire('arrowChange', this, direction);
  });

  $Tag.on('onClick', function(e) {
    e.original.stopPropagation();
    var index = e.node.attrs('index');
    var value = e.get();
    this.fire('onSelect', value, index);
    this.fire('onHide');
  });

  $Tag.on('onEnter', function(e) {
    var options = this.get('$.options');
    var index = this.get('$.selected');
    var value = options[index];
    this.fire('onSelect', value, index);
    this.fire('onHide');
  });

  $Tag.on('onSelect', function(value, index) {
    if (!value) return;

    var self = this;
    var $options = self.get('$.options');
    var selected = $options.findIndex(function(option) {
      return option.value == value.value;
    });

    var params = {};
    var url = self.get('url');
    $Api.$hideLoading = true;
    $Api.post(url).params(params).send(function(res) {
      if (self.limit > res.data.length) {
        self.limit = res.data.length;
      }
      self.set('options', res.data);
      self.fire('onSetOptions');
    });

    self.set('$.selected', selected);
    self.set('value', value.value);
    self.set('$.value', value.label);
    self.fire('select', this, value);
  });
</script>
@endsection