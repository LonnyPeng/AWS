@extends('layout.index')

@section('title', '网页')

@section('style')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('static/dist/css/web.css' )}}" />
@stop

@section('content')
<div id="search">
	<form action="{{ URL('do/web') }}" method="post">
		<div class="row">
			<input type="text" name="url" value="" />
		</div>
		<div class="row">
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<button class="button" type="submit">Search</button>
		</div>
	</form>
</div>
<div class="content-img">
	<img src="" alt="Laravel">
</div>

<script type="text/javascript">
	$('#search form').submit(function () {
		var $$ = $(this);
		this.url.value &&
		$$.ajaxAuto({
			success: function (re) {
				if (re.status == 'ok') {
					$('.content-img img').attr("src", re.data);
				}
			}
		});
		return false;
	});
</script>
@stop