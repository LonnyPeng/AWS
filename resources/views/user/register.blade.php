@extends('layout.user')

@section('title', 'Welcome to laravel')

@section('content')
    <div>
        <form action="{{ URL('do/register')}}" method="POST" id="js-register">
            <input type="text" name="email" />
            <input type="password" name="password" />
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <button type="submit">注册</button>
        </form>
    </div>
    <script type="text/javascript">
        $('#js-register').submit(function () {
            var reg = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;

            if (!this.email.value) {
                $.warning('请输入邮箱');
            } else if (!reg.test(this.email.value)) {
                $.warning('邮箱格式不正确');
            } else if (!this.password.value) {
                $.warning('请输入密码');
            } else if (this.password.value.length < 6) {
                $.warning('密码强度太弱');
            } else {
                $(this).ajaxAuto();
            }

            return false;
        });
    </script>
@endsection
