@section('styles')
@parent
<style type="text/css">
  .dropdown.topborder {
    border: none;
    background: none;
    border-radius: 0;
    border-top: 1px solid rgba(0, 0, 0, .15);
  }

  .dropdown.bottomborder {
    border: none;
    background: none;
    border-radius: 0;
    border-bottom: 1px solid rgba(0, 0, 0, .15);
  }

  .dropdown.leftborder {
    border: none;
    background: none;
    border-radius: 0;
    border-left: 1px solid rgba(0, 0, 0, .15);
  }

  .dropdown.rightborder {
    border: none;
    background: none;
    border-radius: 0;
    border-right: 1px solid rgba(0, 0, 0, .15);
  }

  .dropdown.noborder {
    border: none;
    background: none;
    border-radius: 0;
  }

  .dropdown-menu.timepicker.time {
    margin: 0;
    min-width: 16rem;
  }

  .dropdown-time {
    display: flex;
    align-items: center;
    justify-content: space-around;
  }

  .dropdown .dropdown-menu .dropdown-section {
    flex: 1;
    display: flex;
    padding: 0.5rem;
    border-top: none;
    align-items: center;
    flex-direction: column;
    border-bottom: 1px solid rgba(0, 0, 0, .15);
  }

  .dropdown.top .dropdown-menu.timepicker {
    flex-direction: column;
  }

  .dropdown-section:first-child {
    border-right: 1px solid rgba(0, 0, 0, .15);
  }

  .dropdown-section b {
    color: #2a0d62;
    margin-bottom: 1rem;
  }

  .dropdown-hhmm {
    width: 100%;
    display: flex;
    text-align: center;
    justify-content: space-evenly;
  }

  .dropdown-lists {
    padding: 0;
    list-style: none;
    display: inline-flex;
    flex-direction: column;
  }

  .dropdown-lists li {
    margin-bottom: 0.5rem;
  }

  .dropdown-lists li a {
    color: #656364;
    font-weight: 400;
    border-radius: 0.25rem;
    padding: 0.25rem 0.5rem;
    transition: background-color 0.3s ease, color 0.3s ease;
  }

  .dropdown-lists li a:hover {
    color: #2a0d62;
    background-color: #eae7f1;
  }

  .dropdown-lists li a.active {
    color: #ffffff;
    font-weight: 500;
    background-color: #2a0d62;
  }

  .dropdown-buttons {
    display: flex;
    padding: 0.5rem;
    justify-content: space-between;
  }

  .dropdown-buttons a {
    font-weight: 400;
    border-radius: 0.25rem;
    color: #656364 !important;
    font-size: 0.85rem !important;
    text-align: center !important;
    padding: 0.25rem 0.5rem !important;
    border: 1px solid rgba(0, 0, 0, .15) !important;
  }

  .dropdown-buttons a.outline {
    margin-left: 1rem !important;
  }

  .dropdown-buttons a.done {
    color: #ffffff !important;
    background-color: #2a0d62 !important;
  }

  .dropdown-btns-left,
  .dropdown-btns-right {
    display: flex;
    align-items: center;
  }

  .dropdown-ampm {
    display: flex;
    align-items: center;
    border: none !important;
    color: #656364 !important;
  }

  .dropdown-ampm a:first-child {
    border-radius: 0.25rem 0 0 0.25rem;
    border-right: 1px solid rgba(0, 0, 0, .15) !important;
  }

  .dropdown-ampm a:last-child {
    border-radius: 0 0.25rem 0.25rem 0;
  }

  .dropdown-ampm a.active {
    color: #ffffff !important;
    background-color: #2a0d62 !important;
  }
</style>
@endsection

@section('markups')
@parent
<script id="dropdown-time.tpl" type="text/template">

  <div class="dropdown {{class}}" class-disabled="{{disabled}}" class-top="{{$.positionY=='top'}}" class-right="{{$.positionX=='right'}}" class-show="{{$.show}}" on-keyup="onType" on-click="onStop" style="{{style}}">
    <div class="dropdown-value">
      {{#if $.show}}
        <input class="dropdown-select _timeInput" type="text" on-keyup="onKeyUp" value="{{value}}" />
      {{else}}
        <button type="button" class="dropdown-select" class-placeholder="{{$.value[0]=='HH' || $.value[1] == 'MM' || $.value[2] == 'A'}}" on-click="onShow">
          {{$.value[0]}}:{{$.value[1]}} {{$.value[2]}}
        </button>
      {{/if}}
      <button type="button" class="dropdown-reset" on-click="{{#if !value}}onToggle{{else}}onReset{{/if}}">
        {{#if !value}}
          <i class="{{$.icon}}"></i>
        {{else}}
          <i class="icon-close"></i>
        {{/if}}
      </button>
    </div>

    <div class="dropdown-menu time timepicker" style="{{dropdownStyle}}">
      <div class="dropdown-time">
        <div class="dropdown-section">
          <b>Hour</b>
          <div class="dropdown-hhmm">
            <ul class="dropdown-lists">
              {{#each $.hours:index}}
                {{#if index <= 5}}
                  <li><a class-active="{{this==parseInt($.value[0])}}" on-click="onPressHour">{{this < 10 ? '0'+this : this}}</a></li>
                {{/if}}
              {{/each}}
            </ul>
            <ul class="dropdown-lists">
              {{#each $.hours:index}}
                {{#if index > 5}}
                  <li><a class-active="{{this==parseInt($.value[0])}}" on-click="onPressHour">{{this < 10 ? '0'+this : this}}</a></li>
                {{/if}}
              {{/each}}
            </ul>
          </div>
        </div>
        <div class="dropdown-section">
          <b>Minute</b>
          <div class="dropdown-hhmm">
            <ul class="dropdown-lists">
              {{#each $.minutes:index}}
                {{#if index >= 0 && index < 6}}
                  <li><a class-active="{{this==parseInt($.value[1])}}" on-click="onPressMinute">{{this < 10 ? '0'+this : this}}</a></li>
                {{/if}}
              {{/each}}
            </ul>
            <ul class="dropdown-lists">
              {{#each $.minutes:index}}
                {{#if index >= 6 && index < 12}}
                  <li><a class-active="{{this==parseInt($.value[1])}}" on-click="onPressMinute">{{this < 10 ? '0'+this : this}}</a></li>
                {{/if}}
              {{/each}}
            </ul>
            <ul class="dropdown-lists">
              {{#each $.minutes:index}}
                {{#if index >= 12 && index < 18}}
                  <li><a class-active="{{this==parseInt($.value[1])}}" on-click="onPressMinute">{{this < 10 ? '0'+this : this}}</a></li>
                {{/if}}
              {{/each}}
            </ul>
            <ul class="dropdown-lists">
              {{#each $.minutes:index}}
                {{#if index >= 18 && index < 24}}
                  <li><a class-active="{{this==parseInt($.value[1])}}" on-click="onPressMinute">{{this < 10 ? '0'+this : this}}</a></li>
                {{/if}}
              {{/each}}
            </ul>
            <ul class="dropdown-lists">
              {{#each $.minutes:index}}
                {{#if index >= 24 && index < 30}}
                  <li><a class-active="{{this==parseInt($.value[1])}}" on-click="onPressMinute">{{this < 10 ? '0'+this : this}}</a></li>
                {{/if}}
              {{/each}}
            </ul>
            <ul class="dropdown-lists">
              {{#each $.minutes:index}}
                {{#if index >= 30 && index < 36}}
                  <li><a class-active="{{this==parseInt($.value[1])}}" on-click="onPressMinute">{{this < 10 ? '0'+this : this}}</a></li>
                {{/if}}
              {{/each}}
            </ul>
            <ul class="dropdown-lists">
              {{#each $.minutes:index}}
                {{#if index >= 36 && index < 42}}
                  <li><a class-active="{{this==parseInt($.value[1])}}" on-click="onPressMinute">{{this < 10 ? '0'+this : this}}</a></li>
                {{/if}}
              {{/each}}
            </ul>
            <ul class="dropdown-lists">
              {{#each $.minutes:index}}
                {{#if index >= 42 && index < 48}}
                  <li><a class-active="{{this==parseInt($.value[1])}}" on-click="onPressMinute">{{this < 10 ? '0'+this : this}}</a></li>
                {{/if}}
              {{/each}}
            </ul>
            <ul class="dropdown-lists">
              {{#each $.minutes:index}}
                {{#if index >= 48 && index < 54}}
                  <li><a class-active="{{this==parseInt($.value[1])}}" on-click="onPressMinute">{{this < 10 ? '0'+this : this}}</a></li>
                {{/if}}
              {{/each}}
            </ul>
            <ul class="dropdown-lists">
              {{#each $.minutes:index}}
                {{#if index >= 54 && index < 60}}
                  <li><a class-active="{{this==parseInt($.value[1])}}" on-click="onPressMinute">{{this < 10 ? '0'+this : this}}</a></li>
                {{/if}}
              {{/each}}
            </ul>
          </div>
        </div>
      </div>
      <div class="dropdown-buttons">
        <div class="dropdown-btns-left">
          <div class="dropdown-ampm">
            <a on-click="onPressAM" class-active="{{$.value[2]=='AM'}}">AM</a>
            <a on-click="onPressPM" class-active="{{$.value[2]=='PM'}}">PM</a>
          </div>
          {{#if !hidenow}}<a class="outline" on-click="onPressNow">Now</a>{{/if}}
        </div>
        <div class="dropdown-btns-right">
          <a class="done" on-click="onPressSet">Done</a>
        </div>
      </div>
    </div>
  </div>

</script>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Tag('dropdown-time', '#dropdown-time.tpl');

  $Tag.on('onStop', function(e) {
    e.original.stopPropagation();
  });

  $Tag.on('init', function() {
    var self = this;

    this.set('$.hours', []);
    for (var h = 1; h <= 12; h++) {
      this.push('$.hours', h);
    }

    this.set('$.minutes', []);
    for (var m = 0; m < 60; m++) {
      this.push('$.minutes', m);
    }

    this.set('$.icon', 'icon-sort-down');
    $Event.on('body.clicked', this.trigger('onHide'));
  });

  $Tag.observe('value', function(value) {
    this.date = new Date();
    this.set('$.now', this.date.format('hh-mm-A'));

    if (value && (value.length == 4 || value.length == 8)) {
      value = value.split(':');
      this.date.setHours(value[0]);
      this.date.setMinutes(value[1]);
      var $value = this.date.format('hh-mm-A');
    } else {
      var $value = 'HH-MM-A';
    }

    this.set('$.value', $value.split('-'));
    this.set('$.display', this.date.format('hh-mm-A').split('-'));
  });

  $Tag.observe('min', function(min) {
    if (!min) {
      return;
    }

    this.min = new Date();
    var parts = min.split(':');
    this.min.setHours(parts[0]);
    this.min.setMinutes(parts[1]);
  });

  $Tag.observe('max', function(max) {
    if (!max) {
      return;
    }

    this.max = new Date();
    var parts = max.split(':');
    this.max.setHours(parts[0]);
    this.max.setMinutes(parts[1]);
  });

  $Tag.on('onPressNow', function(e) {
    e.original.stopPropagation();
    this.date = new Date();
    if (this.min > this.date) {
      this.date = this.min;
    }

    this.set('value', this.date.format('HH:mm:ss'));
    this.fire('onHide');
  });

  $Tag.on('onPressSet', function(e) {
    e.original.stopPropagation();
    if (this.min < this.date) {
      this.date = this.min;
    }

    if (!this.get('value')) {
      this.set('value', this.date.format('HH:mm:ss'));
    }

    this.fire('onHide');
  });

  $Tag.on('onToggle', function(e) {
    e.original.stopPropagation();
    if (this.get('$.show')) {
      this.fire('onHide');
    } else {
      this.fire('onShow', e);
      this.el.querySelector('._timeInput').focus();
    }
  });

  $Tag.on('onShow', function(e) {
    var dropdowns = document.querySelectorAll('.dropdown');
    for (var i = 0; i < dropdowns.length; i++) {
      dropdowns[i].classList.remove('show');
    }
    this.set('$.show', true);
    document.querySelector('._timeInput').focus();
    $Event.fire('onDropPosition', e, this);
    this.set('$.icon', 'icon-sort-up');
  });

  $Tag.on('onHide', function(e) {
    this.set('$.show', false);
    this.set('$.positionY', '');
    this.set('$.positionX', '');
    this.set('$.icon', 'icon-sort-down');
  });

  $Tag.on('onReset', function(e) {
    e.original.stopPropagation();
    this.set('value', null);
  });

  $Tag.on('onType', function(e) {
    if (e.original.key === 'Escape') {
      return this.fire('onHide');
    }
  });

  $Tag.on('onPressHour', function(e) {
    e.original.stopPropagation();

    var hour = e.get();
    var $value = this.date.format('hh-mm-A').split('-');
    if ($value[2] == 'AM' && hour == 12) {
      hour = 0;
    }
    if ($value[2] == 'PM') {
      hour = parseInt(hour) + 12;
    }
    this.date.setHours(hour);
    this.set('value', this.date.format('HH:mm:ss'));
  });

  $Tag.on('onPressMinute', function(e) {
    e.original.stopPropagation();

    this.date.setMinutes(e.get());
    this.set('value', this.date.format('HH:mm:ss'));
  });

  $Tag.on('onPressAM', function(e) {
    e.original.stopPropagation();

    var $value = this.date.format('hh-mm-A').split('-');
    if (parseInt($value[0]) == 12) {
      $value[0] = 0;
    }
    this.date.setHours($value[0]);
    this.set('value', this.date.format('HH:mm:ss'));
  });

  $Tag.on('onPressPM', function(e) {
    e.original.stopPropagation();

    var $value = this.date.format('hh-mm-A').split('-');
    if ($value[0] != 12) {
      $value[0] = parseInt($value[0]) + 12;
    }
    this.date.setHours($value[0]);
    this.set('value', this.date.format('HH:mm:ss'));
  });

  var timeTimer;
  $Tag.on('onKeyUp', function(e) {
    e.original.stopPropagation();
    var self = this;
    var key = e.original.key;
    var value = self.get('value');

    clearTimeout(timeTimer);
    timeTimer = setTimeout(() => {
      var hour = parseInt(value);
      if (value.length == 2 && key != 'Backspace') {
        if (hour < 0 || hour > 23) {
          self.set('value', value.slice(0, -1));
          return;
        }
        self.set('value', value + ':');
      }

      var minute = value.split(':')[1];
      if (value.length == 5 && key != 'Backspace') {
        if (minute < 0 || minute > 59) {
          self.set('value', value.slice(0, -1));
          return;
        }
        self.set('value', value + ':');
      }

      if (value.length > 8) {
        value = value.substring(0, 8);
        self.set('value', value);
      }
      var second = value.split(':')[2];
      if (value.length >= 8) {
        if (second < 0 || second > 59) {
          self.set('value', value.slice(0, -1));
          return;
        }
        self.set('value', value.substring(0, 8));
        return;
      }
    }, 100);
  });
</script>
@endsection