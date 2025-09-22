@section('styles')
@parent
<style type="text/css">
  .calendar {
    overflow: hidden;
    border-radius: 0.25rem;
  }

  .calendar-wrapper {
    min-width: 15rem;
  }

  .calendar-table {
    width: 100%;
    margin: 0 auto;
    font-size: 0.9rem;
    border-spacing: 0;
    position: relative;
    box-sizing: content-box;
    border-collapse: separate;
  }

  .calendar-table button {
    width: 100%;
    border: none;
    display: flex;
    background: none;
    border-radius: 50%;
    justify-content: center;
  }

  .calendar-table th,
  .calendar-table td {
    margin: 0;
    padding: 0.5rem 0;
    text-align: center !important;
    border-radius: 0 !important;
  }

  .calendar-table td .date {
    width: 2.5rem;
    height: 2.5rem;
    cursor: pointer;
    font-size: 1rem;
    border-radius: 50%;
    align-items: center;
    display: inline-flex;
    justify-content: center;
  }

  .calendar-table td .disabled {
    cursor: default;
  }

  .calendar-table td .deal {
    color: rgba(<%$gTxColor??'' %>, 1.0);
    background-color: rgba(<%$gBgColor??'' %>, 1.0);
  }

  .calendar-table td .deal:hover {
    color: inherit;
  }

  .calendar-table td:last-child .date,
  .calendar-table td:first-child .date,
  .calendar-table thead:nth-child(1) th:last-child,
  .calendar-table thead:nth-child(1) th:first-child {
    font-weight: bold;
  }

  .calendar-table .nav-panel {
    display: flex;
    padding: 0.5rem 0;
  }
</style>
@endsection


@section('markups')
@parent
<script id="calendar.tpl" type="text/template">

  <div class="calendar {{class}}" class-disabled="{{disabled}}">
    <div class="calendar-wrapper">
      <table class="calendar-table bordered">
        <thead>
          <tr>
            <th class="d-flex p-0_75 border-bottom-2">
              <button on-click="onPrevYear">
                <i class="icon-angle-left"></i>
                <i class="icon-angle-left" style="margin-left:-10px;"></i>
              </button>
              <button on-click="onPrevMonth"><i class="icon-angle-left"></i></button>
            </th>
            <th colspan="5" class="border-bottom-2">{{$.month}}</th>
            <th class="d-flex p-0_75 border-bottom-2">
              <button on-click="onNextMonth"><i class="icon-angle-right"></i></button>
              <button on-click="onNextYear" class="nextYear">
                <i class="icon-angle-right" style="margin-right:-10px;"></i>
                <i class="icon-angle-right"></i>
              </button>
            </th>
          </tr>
          <tr>
            {{#each $.week:index}}
              <th>{{this}}</th>
            {{/each}}
          </tr>
        </thead>
        <tbody>
          {{#each $.days}}
            <tr>
              {{#each this}}
                <td on-click="onSelect">
                  <span class-date="{{this.text}}" class-choosen="{{this.date==$.value}}" class-deal={{(deals.length && deals.indexOf(this.date)!==-1)}} class-disabled="{{((!this.text || !this.enabled) && this.date!=$.today) && (!deals || (deals.length && deals.indexOf(this.date)===-1))}}" class-today="{{this.date==$.today}}">
                    {{this.text}}
                  </span>
                </td>
              {{/each}}
            </tr>
          {{/each}}
        </tbody>
      </table>
    </div>
  </div>

</script>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Tag('calendar', '#calendar.tpl');

  $Tag.on('init', function() {
    if (!this.get('format')) {
      this.set('format', 'YYYY-MM-DD');
    }
    if (!this.get('value')) {
      this.set('$.value', this.get('format'));
    }
    this.set('$.week', ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT']);
  });

  $Tag.observe('value', function(value) {
    this.date = new Date();
    this.set('$.today', this.date.format(this.get('format')));
    var value = this.get('value');
    if (value) {
      this.date = this.date.parse(value);
    }
    this.set('$.month', this.date.format('MMMM YYYY'));
    this.set('$.value', this.date.format(this.get('format')));
    this.fire('renderCalendar');
  });

  $Tag.on('onSelect', function(e) {
    e.original.stopPropagation();
    var date = e.get('date');
    var enabled = e.get('enabled');
    if (!date) {
      return;
    }

    if ((date < this.get('$.today') || !enabled) && date != this.get('$.today')) {
      return;
    }

    this.date = this.date.parse(date);
    this.set('value', this.date.format(this.get('format')));
    this.fire('select', this.date.format('YYYY-MM-DD'));
  });

  $Tag.on('onPrevMonth', function(e) {
    e.original.stopPropagation();
    this.fire('onChangeMonth', -1);
  });

  $Tag.on('onNextMonth', function(e) {
    e.original.stopPropagation();
    this.fire('onChangeMonth', +1);
  });

  $Tag.on('onChangeMonth', function(direction) {
    this.date.setDate(1);
    this.date.setMonth(this.date.getMonth() + direction);
    this.set('$.month', this.date.format('MMMM YYYY'));
    this.fire('renderCalendar');
  });

  $Tag.on('onPrevYear', function(e) {
    e.original.stopPropagation();
    this.fire('onChangeYear', -12);
  });

  $Tag.on('onNextYear', function(e) {
    e.original.stopPropagation();
    this.fire('onChangeYear', +12);
  });

  $Tag.on('onChangeYear', function(direction) {
    this.date.setDate(1);
    this.date.setMonth(this.date.getMonth() + direction);
    this.set('$.month', this.date.format('MMMM YYYY'));
    this.fire('renderCalendar');
  });

  $Tag.on('renderCalendar', function() {
    var days = [];
    var date = new Date();
    var year = this.date.getFullYear();
    var month = this.date.getMonth();
    var allowedNoDays = this.get('allowedNoDays');

    var firstDay = new Date(year, month, 1).getDay();
    var lastDate = new Date(year, month + 1, 0).getDate();
    var currentDateTime = date.getTime();
    var nextValidDateTime = date.getTime() + allowedNoDays * 24 * 60 * 60 * 1000;
    var enabled = false;
    var dateTime;

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
        if (day < 10) {
          day = '0' + day;
        }
        if (i * 7 + j - firstDay + 1 > lastDate) {
          days[i][j] = {
            text: ''
          };
        } else if (day > 0) {
          dateTime = new Date(year, month - 1, day).getTime();
          if (dateTime < currentDateTime) {
            enabled = false;
          } else if (allowedNoDays == 0) {
            enabled = true;
          } else if (dateTime < nextValidDateTime) {
            enabled = true;
          } else {
            enabled = false;
          }
          days[i][j] = {
            text: day,
            date: year + '-' + month + '-' + day,
            enabled: enabled,
          };
        } else {
          days[i][j] = {
            text: ''
          };
        }
      }
    }
    this.set('$.days', days);
  });
</script>
@endsection