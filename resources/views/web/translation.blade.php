@extends('layout.index')

@section('title', '翻译')

@section('style')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('static/dist/css/web-translation.css' )}}" />
@stop

@section('script')
<!-- <script type="text/javascript" src="http://libs.baidu.com/swfobject/2.2/swfobject.js"></script> -->
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
		</div>
		<div class="js-box" id="right"></div>
	</div>
</form>

<!-- <div class="js-box" style="margin: 10px; padding: 5px; width: 48%; min-height: 22px; color: #000; text-align: left; font-size: 16px; font-weight: bold; border: 2px #007dc6 solid; background-color: #eff;" id="zxxTestArea"></div>
<span style="display: inline-block; width: 10px; height: 20px; border: 1px solid #f00;">
    <span id="forLoadSwf"></span>
</span> -->

<script type="text/javascript">
    // var copyCon = document.getElementById("zxxTestArea").innerHTML;
    // var flashvars = {
    //     content: encodeURIComponent(copyCon),
    //     uri: 'http://www.zhangxinxu.com/study/image/flash_copy_btn.png'
    // };
    // var params = {
    //     wmode: "transparent",
    //     allowScriptAccess: "always"
    // };
    // swfobject.embedSWF("http://www.zhangxinxu.com/study/js/clipboard.swf", "forLoadSwf", "52", "25", "9.0.0", null, flashvars, params);

    // function copySuccess(){
    //     //flash回调
    //     alert("复制成功！");
    // }
</script>

<script type="text/javascript">
	$('textarea[name="key"]').keydown(function () {
		$(this).val() && $('form').trigger('submit');
	});

	$('form').submit(function () {
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