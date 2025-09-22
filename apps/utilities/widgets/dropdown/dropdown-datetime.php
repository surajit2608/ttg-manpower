@section('styles')
@parent
<style type="text/css">
  .datetime-controls .dropdown:first-child {
    flex: 0.7;
    border-right: none !important;
    border-radius: 0.25rem 0 0 0.25rem;
  }

  .datetime-controls .dropdown:last-child {
    flex: 0.3;
    border-radius: 0 0.25rem 0.25rem 0;
  }

  .datetime-controls .dropdown.show .dropdown-menu {
    min-width: 25rem;
  }

  .datetime-controls .dropdown.show .dropdown-menu.time {
    right: 0;
    left: auto;
    min-width: 12.5rem;
  }
</style>
@endsection


@section('markups')
@parent
<script id="dropdown-datetime.tpl" type="text/template">

  <div class="space-between datetime-controls">
    <dropdown-date
      value="{{$.date}}"
      min="{{$.mindate}}"
      max="{{$.maxdate}}"
      style="{{$.style}}"
      class="{{$.class}}"
      format="{{$.format}}"
      disabled="{{$.disabled}}"
      dropdownStyle="{{$.dropdownStyle}}"
    />

    <dropdown-time
      value="{{$.time}}"
      min="{{$.mintime}}"
      max="{{$.maxtime}}"
      style="{{$.style}}"
      class="{{$.class}}"
      hidenow="{{$.hidenow}}"
      disabled="{{$.disabled}}"
      dropdownStyle="{{$.dropdownStyle}}"
    />
  </div>

</script>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Tag('dropdown-datetime', '#dropdown-datetime.tpl');

  $Tag.observe('value', function(value) {
    if (!value) {
      this.set('$.date', null);
      this.set('$.time', null);
      return;
    }

    var dateTime = value.split(' ');
    this.set('$.date', dateTime[0]);
    this.set('$.time', dateTime[1]);
  });

  $Tag.observe('min', function(min) {
    if (!min) {
      this.set('$.mindate', null);
      this.set('$.mintime', null);
      return;
    }

    min = min.split(' ');
    this.set('$.mindate', min[0]);
    this.set('$.mintime', min[1]);
  });

  $Tag.observe('max', function(max) {
    if (!max) {
      this.set('$.maxdate', null);
      this.set('$.maxtime', null);
      return;
    }

    max = max.split(' ');
    this.set('$.maxdate', max[0]);
    this.set('$.maxtime', max[1]);
  });

  $Tag.observe('style', function(style) {
    this.set('$.style', style);
  });

  $Tag.observe('dropdownStyle', function(dropdownStyle) {
    this.set('$.dropdownStyle', dropdownStyle);
  });

  $Tag.observe('class', function(newClass) {
    this.set('$.class', newClass);
  });

  $Tag.observe('disabled', function(disabled) {
    this.set('$.disabled', disabled);
  });

  $Tag.observe('format', function(format) {
    this.set('$.format', format);
  });

  $Tag.observe('hidenow', function(hidenow) {
    this.set('$.hidenow', hidenow);
  });

  $Tag.observe('$.date', function(date) {
    this.fire('onChange');
  });

  $Tag.observe('$.time', function(time) {
    this.fire('onChange');
  });

  $Tag.on('onChange', function() {
    var date = this.get('$.date');
    var time = this.get('$.time');
    this.set('value', date + ' ' + time);
  });
</script>
@endsection