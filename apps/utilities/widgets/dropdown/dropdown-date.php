@section('styles')
@parent
<style type="text/css">
  .dropdown-menu.calendar-wrapper {
    min-width: 25rem;
  }

  .dropdown-calendar {
    width: 100%;
    margin: 0 auto;
    font-size: 0.9rem;
    border-spacing: 0;
    position: relative;
    box-sizing: content-box;
    background-color: inherit;
    border-collapse: separate;
  }

  .dropdown-calendar th,
  .dropdown-calendar td {
    margin: 0;
    padding: 0;
    text-align: center;
    border-right: 1px solid #ddd;
    border-bottom: 1px solid #ddd;
  }

  .balin-dark .dropdown-calendar td {
    background-color: #3a5367;
  }

  .dropdown-calendar td .date {
    padding: 0.8rem;
    display: flex;
    cursor: pointer;
    font-weight: normal;
    align-items: center;
    justify-content: center;
  }

  .dropdown-calendar td .date:hover,
  .dropdown-calendar td .date.today {
    background-color: #f7f7f7;
  }

  .dropdown-calendar td .today:hover,
  .dropdown-calendar td .date.selected {
    background-color: #dddddd;
  }

  .dropdown-calendar td .disabled {
    cursor: default;
  }

  .dropdown-calendar .nav-panel {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .btn-display {
    flex: 1;
    padding: 0.5rem;
  }

  .next-prev-btns {
    display: flex;
    border-left: 1px solid #ddd;
  }

  .next-prev-btns>a {
    padding: 0.5rem;
  }

  .nav-panel a {
    margin: 0;
  }

  .nav-panel a:hover {
    background-color: #fafafa;
  }

  .calendar-dropdown {
    max-width: 25rem;
  }

  .btn-today {
    display: flex;
    border-radius: 0;
    align-self: stretch;
    align-items: center;
    padding: 0 1rem !important;
    border-right: 1px solid #ddd;
  }

  .calendar-dropdown td:last-child,
  .calendar-dropdown td:first-child {
    background-color: #fafafa;
  }

  .calendar-dropdown td:last-child .date,
  .calendar-dropdown td:first-child .date {
    color: #999;
    font-weight: 100;
  }

  .show-years {
    display: flex;
    flex-wrap: wrap;
  }

  .show-years.months {
    padding: 2rem 0;
  }

  .show-year {
    flex: 25%;
    padding: 0.25rem 0;
  }

  .show-year span {
    height: 2rem;
    cursor: pointer;
    border-radius: 15px;
    font-weight: normal;
    align-items: center;
    padding: 0 0.75rem;
    display: inline-flex;
    justify-content: center;
    text-transform: uppercase;
  }

  .show-year span.selected {
    background-color: #ddd;
  }
</style>
@endsection


@section('markups')
@parent
<script id="dropdown-date.tpl" type="text/template">

  <div class="dropdown {{$.class}}" class-disabled="{{$.disabled}}" class-top="{{$.positionY=='top'}}" class-right="{{$.positionX=='right'}}" class-show="{{$.show}}" on-keyup="onType" style="{{$.style}}">
    <div class="dropdown-value">
      <input class="dropdown-select _dateInput" type="text" on-click="onToggle" on-keyup="onKeyUp" {{#if !value}}placeholder="{{format}}"{{/if}} value="{{value}}" />
      <button type="button" class="dropdown-reset" on-click="{{#if !value}}onToggle{{else}}onReset{{/if}}">
        {{#if !value}}
          <i class="{{$.icon}}"></i>
        {{else}}
          <i class="icon-close"></i>
        {{/if}}
      </button>
    </div>

    <div class="dropdown-menu calendar-wrapper calendar-dropdown" style="{{dropdownStyle}}">
      <table class="dropdown-calendar">
        <tr>
          <th colspan="7" style="padding:0;">
            <div class="nav-panel">
              <a class="btn-today" on-click="onPressToday">Today</a>
              <a class="btn-display" on-click="onPressDisplay">
                {{$.display}} <i class="icon-sort-{{skipMonth > 1 ? 'up' : 'down'}}"></i>
              </a>
              <div class="next-prev-btns">
                <a direction="-{{skipMonth}}" on-click="onPrevNext">
                  <i class="icon-angle-left"></i>
                </a>
                <a direction="+{{skipMonth}}" on-click="onPrevNext">
                  <i class="icon-angle-right"></i>
                </a>
              </div>
            </div>
          </th>
        </tr>
        {{#if showYears.length}}
          <tr>
            <td colspan="7">
              <div class="show-years">
                {{#each showYears:index}}
                  <div class="show-year">
                    <span class-selected="{{this==$.curYear}}" on-click="onPressYear">{{this}}</span>
                  </div>
                {{/each}}
              </div>
            </td>
          </tr>
        {{elseif showMonths.length}}
          <tr>
            <td colspan="7">
              <div class="show-years months">
                {{#each showMonths:index}}
                  <div class="show-year">
                    <span class-selected="{{this==$.curMonth}}" on-click="onPressMonth">{{this.substring(0, 3)}}</span>
                  </div>
                {{/each}}
              </div>
            </td>
          </tr>
        {{elseif !showYears.length && !showMonths.length}}
          <tr>
            {{#each $.week:index}}
              <th>{{this}}</th>
            {{/each}}
          </tr>
          {{#each $.days}}
            <tr>
              {{#each this}}
                <td on-click="{{(!this.text || ($.min && this.date < $.min) || ($.max && this.date > $.max)) ? '' : 'onSelect'}}">
                  <span class-selected="{{this.date==value}}" class-date="{{this.text}}" class-disabled="{{!this.text || ($.min && this.date < $.min) || ($.max && this.date > $.max)}}" class-today="{{this.date==$.today}}">{{this.text}}</span>
                </td>
              {{/each}}
            </tr>
          {{/each}}
        {{/if}}
      </table>
    </div>
  </div>

</script>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Tag('dropdown-date', '#dropdown-date.tpl');

  $Tag.on('onStop', function(e) {
    e.original.stopPropagation();
  });

  $Tag.on('init', function() {
    if (!this.get('format')) {
      this.set('format', 'YYYY-MM-DD');
    }

    this.yearsToShow = 24;
    this.set('skipMonth', 1);

    this.set('$.icon', 'icon-sort-down');
    this.set('$.curYear', this.date.format('YYYY'));
    this.set('$.curMonth', this.date.format('MMMM'));
    this.set('$.month', this.date.format('MMMM YYYY'));
    this.set('$.week', ['S', 'M', 'T', 'W', 'T', 'F', 'S']);
    this.set('$.today', new Date().format(this.get('format')));

    $Event.on('body.clicked', this.trigger('onHide'));
  });

  $Tag.observe('$.curMonth', function(month) {
    if (this.get('skipMonth') > 12) {
      this.set('$.display', this.start + ' - ' + this.end);
    } else if (this.get('skipMonth') == 12) {
      this.set('$.display', this.get('$.curYear'));
    } else {
      this.set('$.display', month + ' ' + this.get('$.curYear'));
    }
  });

  $Tag.observe('$.curYear', function(year) {
    if (this.get('skipMonth') > 12) {
      this.set('$.display', this.start + ' - ' + this.end);
    } else if (this.get('skipMonth') == 12) {
      this.set('$.display', this.get('$.curYear'));
    } else {
      this.set('$.display', this.get('$.curMonth') + ' ' + year);
    }
  });

  $Tag.observe('value', function(value) {
    this.date = new Date();

    if (value == '0000-00-00') {
      value = '';
      this.set('value', '');
    }

    if (value && value.length == 10) {
      this.date = this.date.parse(value);
      this.set('$.curYear', this.date.format('YYYY'));
      this.set('$.curMonth', this.date.format('MMMM'));
      this.set('$.month', this.date.format('MMMM YYYY'));
    }

    this.fire('renderCalendar');
  });

  $Tag.observe('min', function(min) {
    this.set('$.min', min);
  });

  $Tag.observe('max', function(max) {
    this.set('$.max', max);
  });

  $Tag.observe('style', function(style) {
    this.set('$.style', style);
  });

  $Tag.observe('class', function(newClass) {
    this.set('$.class', newClass);
  });

  $Tag.observe('disabled', function(disabled) {
    this.set('$.disabled', disabled);
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
    this.set('skipMonth', 1);
    this.set('showYears', []);
    this.set('showMonths', []);
    this.set('$.display', this.get('$.curMonth') + ' ' + this.get('$.curYear'));
    $Event.fire('onDropPosition', e, this);
    this.set('$.icon', 'icon-sort-up');
  });

  $Tag.on('onHide', function() {
    this.set('$.show', false);
    this.set('$.positionY', '');
    this.set('$.positionX', '');
    this.set('$.icon', 'icon-sort-down');
  });

  $Tag.on('onReset', function(e) {
    e.original.stopPropagation();
    this.set('value', null);
    this.set('$.curYear', this.date.format('YYYY'));
    this.set('$.curMonth', this.date.format('MMMM'));
    this.fire('clear', this);
  });

  $Tag.on('onType', function(e) {
    if (e.original.key === 'Escape') {
      return this.fire('onHide');
    }
  });

  $Tag.on('onSelect', function(e) {
    e.original.stopPropagation();
    var date = e.get('date');
    if (!date) return;

    this.date = this.date.parse(date);
    var value = this.date.format(this.get('format'));
    this.set('value', value);
    this.fire('select', this, value);
    this.fire('onHide');
  });


  $Tag.on('onPressToday', function(e) {
    e.original.stopPropagation();
    this.date = new Date();
    this.set('skipMonth', 1);
    this.set('showYears', []);
    this.set('value', this.date.format(this.get('format')));
    this.fire('onHide');
  });

  $Tag.on('onPressDisplay', function(e) {
    e.original.stopPropagation();

    if (this.get('skipMonth') >= 12) {
      this.set('skipMonth', 1);
      this.set('showYears', []);
      this.set('showMonths', []);
      this.set('$.display', this.get('$.curMonth') + ' ' + this.get('$.curYear'));
    } else {
      this.set('showMonths', []);
      this.set('skipMonth', this.yearsToShow * 12);
      this.fire('showYears', this.get('$.curYear'));
    }
  });

  $Tag.on('onPressYear', function(e) {
    e.original.stopPropagation();

    this.set('skipMonth', 12);
    this.set('showYears', []);
    this.set('$.curYear', e.node.innerText);
    this.date.setYear(this.get('$.curYear'));
    this.set('$.display', this.get('$.curYear'));

    this.set('showMonths', this.optionsMonths);
  });

  $Tag.on('onPressMonth', function(e) {
    e.original.stopPropagation();

    this.set('skipMonth', 1);
    this.set('showMonths', []);

    var index = this.optionsMonths.indexOf(this.get('$.curMonth'));

    var direction = e.get('index') - index;
    this.fire('onChange', direction * 1);
  });

  $Tag.on('onPrevNext', function(e) {
    e.original.stopPropagation();
    var direction = e.node.attrs('direction');

    if (this.get('skipMonth') > 12) {
      if (direction.indexOf('-') === 0) {
        this.fire('showYears', this.start - (this.yearsToShow / 2));
      } else {
        this.fire('showYears', this.end + ((this.yearsToShow / 2) + 1));
      }
    } else {
      this.fire('onChange', direction * 1);
    }
  });

  $Tag.on('onChange', function(direction) {
    this.date.setDate(1);
    this.date.setMonth(this.date.getMonth() + direction);
    this.set('$.curYear', this.date.format('YYYY'));
    this.set('$.curMonth', this.date.format('MMMM'));
    this.set('$.month', this.date.format('MMMM YYYY'));
    this.fire('renderCalendar');
  });

  $Tag.on('showYears', function(year) {
    this.set('showYears', []);
    this.start = parseInt(year) - 12;
    this.end = parseInt(year) + 11;
    for (var i = this.start; i <= this.end; i++) {
      this.push('showYears', i);
    }
    this.set('$.display', this.start + ' - ' + this.end);
  });

  var dateTimer;
  $Tag.on('onKeyUp', function(e) {
    var self = this;
    var key = e.original.key;
    var value = self.get('value');
    var monthDays = {
      '01': 31,
      '02': 28,
      '03': 31,
      '04': 30,
      '05': 31,
      '06': 30,
      '07': 31,
      '08': 31,
      '09': 30,
      '10': 31,
      '11': 30,
      '12': 31,
    };

    clearTimeout(dateTimer);
    dateTimer = setTimeout(() => {
      var year = parseInt(value);
      var leapYear = ((year % 4 == 0) && (year % 100 != 0)) || (year % 400 == 0);
      if (leapYear) {
        monthDays['02'] = 29;
      }

      if (value.length == 4 && key != 'Backspace') {
        self.set('value', value + '-');
      }

      var month = value.split('-')[1];
      if (value.length == 7 && key != 'Backspace') {
        if (month < 1 || month > 12) {
          self.set('value', value.slice(0, -1));
          return;
        }
        self.set('value', value + '-');
      }

      if (value.length > 10) {
        value = value.substring(0, 10);
        self.set('value', value);
      }
      var day = value.split('-')[2];
      if (value.length >= 10) {
        if (day < 1 || day > monthDays[month]) {
          self.set('value', value.slice(0, -1));
          return;
        }
        return;
      }
    }, 100);
  });

  $Tag.on('renderCalendar', function() {
    var days = [];
    var month = this.date.getMonth();
    var year = this.date.getFullYear();

    var firstDay = new Date(year, month, 1).getDay();
    var lastDate = new Date(year, month + 1, 0).getDate();

    month += 1;
    if (month < 10) {
      month = '0' + month;
    }

    for (var i = 0; i < 6; i++) {
      if (i * 7 - firstDay + 1 > lastDate) {
        break;
      }
      days[i] = [];
      for (var j = 0; j < 7; j++) {
        var day = i * 7 + j - firstDay + 1;
        if (i * 7 + j - firstDay + 1 > lastDate) {
          days[i][j] = {
            text: ''
          };
        } else if (day > 0) {
          if (day < 10) {
            day = '0' + day;
          }
          days[i][j] = {
            text: day,
            date: year + '-' + month + '-' + day
          };
        } else {
          days[i][j] = {
            text: ''
          };
        }
      }
    }
    this.set('$.days', days);

    var optionsMonths = [];
    this.optionsMonths = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    for (var i in this.optionsMonths) {
      optionsMonths.push({
        value: this.optionsMonths[i],
        label: this.optionsMonths[i].substring(0, 3),
      });
    }
    this.set('$.options_months', optionsMonths);

    var optionsYears = [];
    var minYear = year - 10;
    var maxYear = year + 10;
    for (var i = minYear; i <= maxYear; i++) {
      optionsYears.push({
        value: i,
        label: i,
      });
    }
    this.set('$.options_years', optionsYears);
  });
</script>
@endsection