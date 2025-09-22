@section('styles')
@parent
<style type="text/css">
  .input-tags {
    width: 100%;
    border: none;
    display: flex;
    font-size: 1rem;
    padding: 0.5rem 0;
    position: relative;
    box-sizing: border-box;
    background: none !important;
  }

  .input-tags .tags {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: flex-start;
  }

  .input-tags .tags span {
    display: flex;
    white-space: nowrap;
    align-items: center;
    margin-right: 0.5rem;
    margin-bottom: 0.3rem;
    border-radius: 0.25rem;
    padding: 0.1rem 0.3rem;
    justify-content: center;
  }

  .input-tags .tags span a {
    color: #ec4254;
    margin-left: 0.25rem;
  }

  .input-tags input {
    flex: 1;
    border: none;
  }
</style>
@endsection


@section('markups')
@parent
<script id="input-tags.tpl" type="text/template">
  <div class="tag-controls">
    <input class="controls {{class}}" type="text" on-keydown="onKeyDown" on-enter="onEnter" on-blur="onBlur" value="{{$.tag}}" placeholder="{{placeholder}}" readonly="{{readonly}}" style="{{style}}" />
    <div class="input-tags">
      <div class="tags">
        {{#each $.value:index}}
          <span>{{this}}<a on-click="onDelete"><i class="icon-cancel"></i></a></span>
        {{/each}}
      </div>
    </div>
  </div>
</script>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Tag('input-tags', '#input-tags.tpl');

  $Tag.observe('value', function(value) {
    var $value = [];
    if (value) {
      $value = value.split(',');
    }
    this.set('$.value', $value);
  });

  $Tag.on('onKeyDown', function(e) {
    if (this.get('$.tag')) {
      return;
    }

    // backspace press
    var keyCode = e.original.which || e.original.keyCode;
    if (keyCode === 8) {
      var tags = this.get('$.value') || [];
      if (!tags.length) {
        return;
      }

      tags.pop();
      this.set('value', tags.join());
    }
  })

  $Tag.on('onEnter', function(e) {
    var $tag = this.get('$.tag');
    var tags = this.get('$.value') || [];
    if ($tag.trim()) {
      tags.push($tag);
    }

    this.set('value', tags.join());
    this.set('$.tag', '');
  });

  $Tag.on('onBlur', function(e) {
    var $tag = this.get('$.tag') || null;
    var tags = this.get('$.value') || [];

    if ($tag) {
      if ($tag.trim()) {
        tags.push($tag);
      }

      this.set('value', tags.join());
      this.set('$.tag', '');
    }
  });

  $Tag.on('onDelete', function(e) {
    e.original.stopPropagation();

    var index = e.get('index');
    var tags = this.get('$.value');
    tags.splice(index, 1);
    this.set('value', tags.join());
  });
</script>
@endsection