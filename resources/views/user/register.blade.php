<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
        <title>Welcome to laravel</title>
        <link rel="icon" type="image/x-icon" href="{{ URL::asset('favicon.svg' )}}" />
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('static/dist/css/common.css' )}}" />
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('static/dist/css/user.css' )}}" />
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('static/dist/css/font.css') }}" />
        <script type="text/javascript" src="{{ URL::asset('static/dist/js/jquery-3.1.1.min.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('static/dist/js/core.ajaxauto.js' )}}"></script>
    </head>
    <body>
        <div>
        	<form method="POST" id="js-register">
        		<input type="text" name="email" />
        		<input type="password" name="password" />
        		<button type="submit">注册</button>
        	</form>
        </div>
        <script type="text/javascript">
        	$('#js-register').submit(function () {
        		var reg = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;

        		if (!this.email.value) {
        			window.alert('请输入邮箱');
        		} else if (!reg.test(this.email.value)) {
        			window.alert('邮箱格式不正确');
        		} else if (!this.password.value) {
        			window.alert('请输入密码');
        		} else if (this.password.value.length < 6) {
        			window.alert('密码强度太弱');
        		} else {
        			$(this).ajaxAuto();
        		}
        	});
        </script>
    </body>
</html>