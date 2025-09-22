@extends('shared.layout')
@include('shared.events')
@include('shared.header', [
'page' => 'Test',
])
@include('shared.sidebar', [
'page' => 'test',
])


@include('widgets.input')
@include('widgets.modal')
@include('widgets.upload')
@include('widgets.sorting')
@include('widgets.message')
@include('widgets.dropdown')


@section('title')
Test -
@endsection


@section('styles')
@parent
<style media="screen">

</style>
@endsection


@section('content')
<div class="content">
  <input-address value="{{address}}" />
</div>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Data.set('address', 'Kolkata')

  $Event.on('page.init', () => {
    $Event.fire('hideLoading', true)
  })
</script>
@endsection