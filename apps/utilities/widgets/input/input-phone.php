@include('widgets.dropdown')

@section('styles')
@parent
<style type="text/css">

</style>
@endsection


@section('markups')
@parent
<script id="input-phone.tpl" type="text/template">
  <div class="phone controls" class-disabled="{{disabled}}">
    <div class="code">
      <span class="code-text">{{$.code ? '+'+$.code : 'ISD'}}</span>
      <dropdown-search url="<%SITE_URL%>/common/api/country" value="{{$.code}}" placeholder="ISD" itemHeight="40" on-select="onSelectCode" />
    </div>
    <div class="number">
      <input size="1" type="text" style="{{style}}" class="controls number-input" minlength="6" maxlength="15" value="{{$.number}}" on-keyup="onKeyup" placeholder="{{placeholder}}" autocomplete="new-password" on-enter="onEnter" />
    </div>
  </div>
</script>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Tag('input-phone', '#input-phone.tpl');

  $Tag.observe('value', function() {
    var code = '',
      number = '',
      value = this.get('value') || '';
    value = value.replace(/\+/g, '');

    if (value.indexOf(' ') !== -1 && value.indexOf(' ') <= 4) {
      code = value.substr(0, value.indexOf(' ')).replace(/\s/g, '');
      number = value.substr(value.indexOf(' ') + 1).replace(/\s/g, '');
    } else {
      code = value.substr(0, 2).replace(/\s/g, '');
      number = value.substr(2).replace(/\s/g, '');
    }

    if (code === '' && this.get('default-isd')) {
      code = this.get('default-isd');
    }

    this.set('$.code', code);
    this.set('$.number', number);
    this.fire('setNumber');
  });

  $Tag.on('onKeyup', function(e) {
    var code = this.get('$.code').toString();
    if (!code) {
      this.set('$.number', '');
      $Event.fire('message.show', {
        type: 'warning',
        text: 'Choose ISD code first',
      });
      return;
    }

    var item = this.get('$.number');
    if (isNaN(item)) {
      this.set('$.number', item.replace(/\D/g, ''));
    }
    this.fire('setNumber');
  });

  $Tag.on('onSelectCode', function() {
    this.fire('setNumber');
  });

  $Tag.on('setNumber', function() {
    var code = this.get('$.code');
    var number = this.get('$.number');
    var value = `+${code} ${number}`;
    if (value.trim() == '+' || value.trim() == code) {
      value = '';
    }
    this.set('value', value);
  });

  $Tag.on('onEnter', function(e) {
    this.fire('enter', e);
  });
</script>
@endsection