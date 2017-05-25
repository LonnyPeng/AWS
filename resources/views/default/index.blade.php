@extends('layout.index')

@section('title', trans('Laravel'))

@section('style')
<style type="text/css">
	body {
		color: #fff;
		background-color: #ccc;
	}
</style>
@endsection

@section('content')
	<h1>Hello World</h1>
	<span><i class="fa fa-file-text"></i></span>
@endsection

@section('script')
<script type="text/javascript">
	window.onload = function () {
		console.log("lonny.p@eyebuydirect.com");
	};
</script>
@endsection