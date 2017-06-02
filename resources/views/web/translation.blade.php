@extends('layout.index')

@section('title', '翻译')

@section('script')
<script type="text/javascript" src="{{ URL::asset('static/dist/js/tk.js') }}"></script>
@stop

@section('content')
<div id="search" style="margin-left: 10px;">
	<form action="{{ URL('do/translation') }}" method="post">
		<div style="display: inline-block;">
			<select name="tl" style="border: 1px #007dc6 solid; height: 28px; padding-left: 2px;">
				@foreach($lanList as $row)
					<option value="{{ $row['lan_key'] }}">{{ $row['lan_name'] }}</option>
				@endforeach
			</select>
		</div>

		<div style="display: inline-block;">
			<input type="hidden" name="tk" value="" />
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<button class="button" type="submit">Search</button>
		</div>

		<div style="margin-top: 10px;">
			<textarea rows="10" cols="80" name="key" value="" style="border: 1px #007dc6 solid; border-radius: 5px; padding: 5px; font-size: 16px; color: #000;"></textarea>
		</div>
	</form>
</div>

<div class="js-box" style="margin: 10px; padding: 5px; width: 48%; min-height: 22px; color: #000; text-align: left; font-size: 16px; font-weight: bold; border: 2px #007dc6 solid; background-color: #eff;"></div>

<script type="text/javascript">
	var key = $('textarea[name="key"]').val();
	$('textarea[name="key"]').keydown(function () {
		if (this.value != key) {
			key = this.value;
			$('input[name="tk"]').val(tk(key, '{{ TKK() }}'));

			$('#search form').trigger('submit');
		}
	}); 

	$('textarea[name="key"]').change(function () {
		$('input[name="tk"]').val(tk($(this).val(), '{{ TKK() }}'));
	});

	$('#search form').submit(function () {
		var $$ = $(this);
		this.key.value &&
		$$.ajaxAuto({
			success: function (re) {
				if (re.status == 'ok') {
					$('.js-box').html('');
					$('.js-box').html(re.data);
				}
			}
		});
		return false;
	});
</script>
@stop