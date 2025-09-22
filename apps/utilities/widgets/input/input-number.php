@section('styles')
@parent
<style type="text/css">
  .number-controls {
    flex: 1;
    display: flex;
    overflow: hidden;
    align-items: center;
    justify-content: space-between;
  }

  .number-controls .controls {
    flex: 1;
    color: initial;
    overflow: hidden;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
    border-right: none;
    align-self: stretch;
    margin: 0 !important;
  }

  .number-controls.currency .controls {
    border-radius: 0;
  }

  .number-controls span {
    display: flex;
    align-self: stretch;
    align-items: center;
    justify-content: center;
    padding: 0 0.5rem !important;
    border-radius: 0.25rem 0 0 0.25rem;
  }

  .number-controls .btn {
    flex: 1;
    margin: 0;
    display: flex;
    font-size: 1.15rem;
    align-items: center;
    align-self: stretch;
    font-size: inherit !important;
    padding: 0.78rem 0.5rem !important;
  }

  .number-controls .btn:first-child {
    border-radius: 0 !important;
  }

  .number-controls .btn:last-child {
    margin-left: -1px;
    border-radius: 0 0.2rem 0.2rem 0 !important;
  }

  .number-controls-icon {
    display: flex;
    align-self: stretch;
  }

  .unit-name {
    opacity: 0.8;
    display: flex;
    color: #ffffff;
    padding: 0.5rem;
    margin-left: 1px;
    font-weight: bold;
    align-items: center;
    align-self: stretch;
    background-color: #3320AD;
    font-size: 1rem !important;
    border-top-right-radius: 0.25rem;
    border-bottom-right-radius: 0.25rem;
    border-top-left-radius: 0 !important;
    border-bottom-left-radius: 0 !important;
  }

  .number-controls .btn.noround:last-child {
    border-radius: 0 !important;
  }
</style>
@endsection


@section('markups')
@parent
<script id="input-number.tpl" type="text/template">
  <div class="number-controls {{class}}" class-currency="{{currency}}" on-click="onFocus">
    {{#if currency}}<span style="{{iconStyle}}{{style}}">{{currency}}</span>{{/if}}
    <input type="text" class="controls" size="{{size}}" style="{{style}}" value="{{value}}" required="{{required}}" readonly="{{$.readonly}}" placeholder="{{this.placeholder}}" on-keyup="onKeyUp" on-keydown="onKeyDown" on-focus="onFocus" on-blur="onBlur" on-enter="onEnter" />
    <div class="number-controls-icon">
      <button type="button" class-disabled="{{$.readonly}}" class="btn border-1" direction="-{{step}}" on-click="onClick" on-mousedown="onMouseDown" on-mouseup="onMouseUp" on-mouseleave="onMouseUp" style="{{buttonStyle}}"><i class="icon-minus-circle"></i></button>
      <button type="button" class-noround="{{$.unit.label}}" class-disabled="{{$.readonly}}" class="btn border-1" direction="+{{step}}" on-click="onClick" on-mousedown="onMouseDown" on-mouseup="onMouseUp" on-mouseleave="onMouseUp" style="{{buttonStyle}}"><i class="icon-plus-circle"></i></button>
    </div>
    {{#if $.unit.label}}<div class="unit-name" style="{{buttonStyle}}">{{$.unit.label}}</div>{{/if}}
  </div>
</script>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Tag('input-number', '#input-number.tpl');

  $Tag.on('init', function() {
    if (!this.get('step')) {
      this.set('step', 1);
    }
  });

  $Tag.on('onValueChange', function(step) {
    var min = Number(this.get('min')),
      max = Number(this.get('max'));
    value = Number(this.get('value'));

    this.el.querySelector('input').focus();

    value += Number(step);

    if (this.get('min') !== '' && value < min) {
      return;
    }

    if (this.get('max') !== '' && value > max) {
      return;
    }

    if (isFloat(value)) {
      value = value.toFixed(2);
    }

    this.set('value', value);
  });

  $Tag.on('onClick', function(e) {
    this.fire('onValueChange', e.node.attrs('direction'));
  });

  $Tag.on('onMouseDown', function(e) {
    var self = this;
    self.timeout = setTimeout(function() {
      self.interval = setInterval(function() {
        self.fire('onClick', e);
      }, 50);
    }, 300);
  });

  $Tag.on('onMouseUp', function() {
    clearTimeout(this.timeout);
    clearInterval(this.interval);
  });

  $Tag.observe('value', function(value) {
    this.fire('change', this);
  });

  $Tag.observe('unit', function(unit) {
    this.set('$.unit', unit);
  });

  $Tag.observe('readonly', function(readonly) {
    this.set('$.readonly', readonly);
  });

  $Tag.on('onKeyDown', function(e) {
    var step = this.get('step');
    if (e.original.key == 'ArrowUp') {
      return this.fire('onValueChange', `+${step}`);
    } else if (e.original.key == 'ArrowDown') {
      return this.fire('onValueChange', `-${step}`);
    }
  });

  $Tag.on('onKeyUp', function(e) {
    if (e.original.key === 'Escape') {
      return this.fire('esc');
    }

    var value = this.get('value');

    this.set('value', new String(value));
    this.set('value', this.get('value').trim());
    this.set('value', this.get('value').replace('e', ''));

    value = this.get('value');
    this.el.querySelector('input').focus();

    if (value != '-' && isNaN(Number(value))) {
      var lIndex = value.lastIndexOf(e.original.key);
      value = value.substr(0, lIndex) + value.substr(lIndex + 1, value.length - 1)
      if (isNaN(Number(value))) {
        value = '';
      }
      this.set('value', value);
    }
  });

  $Tag.on('onFocus', function(e) {
    e.original.stopPropagation();

    if (this.get('$.readonly')) {
      return;
    }

    if (this.get('value') == 0) {
      this.set('value', '');
    }
    this.fire('focus', this);
  });

  $Tag.on('onBlur', function() {
    if (this.get('$.readonly')) {
      return;
    }

    var min = Number(this.get('min')),
      max = Number(this.get('max')),
      value = Number(this.get('value'));
    if (this.get('min') !== '' && value < min)
      this.set('value', min);
    if (this.get('max') !== '' && value > max)
      this.set('value', max);

    this.fire('blur', this);
  });

  $Tag.on('onEnter', function() {
    if (this.get('$.readonly')) {
      return;
    }

    this.fire('enter', this);
  });

  function isInt(n) {
    return Number(n) === n && n % 1 === 0;
  }

  function isFloat(n) {
    return Number(n) === n && n % 1 !== 0;
  }
</script>
@endsection