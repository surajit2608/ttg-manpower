@section('styles')
@parent
<style type="text/css">
  .custom-rating {
    display: flex;
    position: relative;
    white-space: normal;
  }

  .rating {
    float: left;
    border: none;
    min-width: max-content;
  }

  .rating>input {
    display: none;
  }

  .rating>label:before {
    margin: 5px;
    content: "\f005";
    font-size: 2.5rem;
    display: inline-block;
    font-family: 'FontAwesome';
  }

  .custom-rating.small .rating>label:before {
    font-size: 1.5rem;
  }

  .rating.disabled {
    user-select: none;
  }

  .rating>.half:before {
    content: "\f089";
    position: absolute;
  }

  .rating>label {
    margin: 0;
    color: #ddd;
    float: right;
  }

  .rating>input:checked~label,
  .rating:not(:checked)>label:hover,
  .rating:not(:checked)>label:hover~label {
    color: #FFD700;
  }

  .rating>input:checked+label:hover,
  .rating>input:checked~label:hover,
  .rating>label:hover~input:checked~label,
  .rating>input:checked~label:hover~label {
    color: #FFED85;
  }
</style>
@endsection


@section('markups')
@parent
<script id="rating.tpl" type="text/template">
  <div class="custom-rating {{class}}">
    <fieldset class="rating" class-disabled="{{readonly}}">
      {{#each $.rating}}
        <input twoway="false" disabled="{{readonly}}" type="radio" id="star{{rate}}{{class}}{{$.name}}" name="{{$.name}}" value="{{rate}}" checked="{{rate==value}}" on-change="onChangeRating" />
        <label disabled="{{readonly}}" class="{{class}}" for="star{{rate}}{{class}}{{$.name}}" title="{{rate}} {{rate==1 ? 'star' : 'stars'}}"></label>
      {{/each}}
    </fieldset>
  </div>
</script>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Tag('rating', '#rating.tpl');

  $Tag.on('init', function() {
    var random = Math.random() * 10;
    this.set('$.name', random);

    var rating = [];
    for (var i = this.get('max'); i > 0; i = i - 0.5) {
      var rate = Number(i);
      var className = 'half';
      if (Number.isInteger(rate)) {
        className = 'full';
      }
      rating.push({
        rate: rate,
        class: className,
      });
    }
    this.set('$.rating', rating);
  });

  $Tag.on('onChangeRating', function(self) {
    this.set('value', self.get('rate'));
  });
</script>
@endsection