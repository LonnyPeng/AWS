@extends('layout.index')

@section('title', '翻译')

@section('script')
<script type="text/javascript" src="{{ URL::asset('static/dist/js/tk.js') }}"></script>
@stop

@section('content')
<div id="search">
	<form action="{{ URL('do/translation') }}" method="post">
		<div class="row">
			<input type="text" name="key" value="" />
		</div>
		<div class="row">
			<input type="hidden" name="tk" value="" />
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<button class="button" type="submit">Search</button>
		</div>
	</form>
</div>
<div class="js-box" style="color: #0f0;"></div>

<script type="text/javascript">
	$('input[name="key"]').change(function () {
		$('input[name="tk"]').val(tk($(this).val(), '{{ TKK() }}'));
	});

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