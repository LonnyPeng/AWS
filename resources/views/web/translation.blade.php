@extends('layout.index')

@section('title', '翻译')

@section('content')
<div id="search">
	<form action="{{ URL('do/web') }}" method="post">
		<div class="row">
			<input type="text" name="key" value="" />
		</div>
		<div class="row">
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<button class="button" type="submit">Search</button>
		</div>
	</form>
</div>
<div class="js-box" style="color: #0f0;"></div>

<script type="text/javascript">
	$('#search form').submit(function () {
		var $$ = $(this);
		this.key.value &&
		$$.ajaxAuto({
			success: function (re) {
				if (re.status == 'ok') {
					$('.js-box').html(re.data);
				}
			}
		});
		return false;
	});
</script>
@stop