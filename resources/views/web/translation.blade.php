@extends('layout.index')

@section('title', '翻译')

@section('style')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('static/dist/css/web-translation.css' )}}" />
@stop

@section('script')
<script type="text/javascript" src="{{ URL::asset('static/dist/js/swfobject.js' )}}"></script>
@stop

@section('content')
<form action="{{ URL('do/translation') }}" method="post">
	<div id="search">
		<span>
			<select name="tl">
				@foreach($lanList as $row)
					<option value="{{ $row['lan_key'] }}" {{ $row['lan_key'] == 'zh-CN' ? 'selected' : '' }}>{{ $row['lan_name'] }}</option>
				@endforeach
			</select>
		</span>

		<span>
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<button class="button" type="submit">Search</button>
		</span>
	</div>
	<div id="box">
		<div id="left">
			<textarea name="key" value="" ></textarea>
			<span class="delete">
				<i class="fa fa-remove fa-2x"></i>
			</span>
		</div>
		<div id="right">
			<textarea class="js-box" readonly="readonly"></textarea>
			<div class="none" id="zxxTestArea"></div>
			<span id="forLoadSwf"></span>
		</div>
	</div>
</form>

<script type="text/javascript">
	// delete
	$('.delete').click(function () {
		$('textarea').val('');
		$('#zxxTestArea').html('');
	});

	$('textarea[name="key"]').keydown(function () {
		$(this).val() && $('form').trigger('submit');
	});

	$('form').submit(function () {
		var $$ = $(this);

		this.key.value &&
		$$.ajaxAuto({
			success: function (re) {
				if (re.status == 'ok') {
					$('.js-box, #zxxTestArea').html('');
					$('.js-box, #zxxTestArea').html(re.data);

					var copyCon = document.getElementById("zxxTestArea").innerHTML;
					var flashvars = {
					    content: encodeURIComponent(copyCon),
					    uri: window.location.origin + '/static/dist/images/flash_copy_btn.png'
					};
					var params = {
					    wmode: "transparent",
					    allowScriptAccess: "always"
					};
					swfobject.embedSWF(window.location.origin + "/static/dist/audio/clipboard.swf", "forLoadSwf", "52", "25", "9.0.0", null, flashvars, params);
				}
			}
		});
		return false;
	});
</script>
@stop