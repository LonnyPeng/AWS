@extends('layout.index')

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
@endsection

@section('script')
<script type="text/javascript">
	window.onload = function () {
		console.log("lonny.p@eyebuydirect.com");
	};
</script>
@endsection