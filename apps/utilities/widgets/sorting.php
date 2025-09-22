@section('styles')
@parent
<style type="text/css">

</style>
@endsection


@section('markups')
@parent
<script id="sorting.tpl" type="text/template">
  <a class="d-flex align-items-center {{class}}" on-click="onSort">
    {{yield}}
    <i class="ml-0_5" class-icon-sort-asc="{{$.order.column == column && $.direction == 'asc'}}" class-icon-sort-desc="{{$.order.column == column && $.direction == 'desc'}}" class-icon-sort="{{$.order.column != column}}" class-color-gray="{{$.order.column != column}}"></i>
  </a>
</script>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Tag('sorting', '#sorting.tpl')

  $Tag.observe('order', function(order) {
    if(!order) return
    this.set('$.order', order)
    this.set('$.direction', order.direction)
  })

  $Tag.on('onSort', function(e) {
    if (this.get('$.direction') == 'asc') {
      this.set('$.direction', 'desc')
    } else {
      this.set('$.direction', 'asc')
    }
    this.set('order.column', this.get('column'))
    this.set('order.direction', this.get('$.direction'))
    this.fire('click')
  })
</script>
@endsection