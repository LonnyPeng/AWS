<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use App\Http\Models\MemberModel as MemberModels;
use DB;

class UserController extends Controller
{
	public function register()
	{
		if(!isAjax()) {
			return false;
		}

		$email = trim(Input::get('email'));
		$password = trim(Input::get('password'));

		if (!$email || !$password) {
			return array('status' => 'error', 'msg' => '数据不完整');
		}

		if (!isMail($email)) {
			return array('status' => 'error', 'msg' => '邮箱格式不正确');
		}

		$models = new MemberModels();

		if ($models->getMemberInfo($email)) {
			return array('status' => 'error', 'msg' => '邮箱已注册');
		}

		$password = md5($password);
		$passwordToken = substr($password, 0, 2);
		$password = md5($password . ":" . $passwordToken) . ":" . $passwordToken;

		$sql = "INSERT INTO t_member 
				SET member_email = :member_email, 
				member_password = :member_password";
		$status = DB::insert($sql, array('member_email' => $email, 'member_password' => $password));
		if ($status) {
			sendApproveMail($email);
			return array('status' => 'ok', 'msg' => '注册成功');
		} else {
			return array('status' => 'error', 'msg' => '注册失败');
		}
	}

	public function Login()
	{
		if(!isAjax()) {
			return false;
		}

		$email = trim(Input::get('email'));
		$password = trim(Input::get('password'));

		if (!$email || !$password) {
			return array('status' => 'error', 'msg' => '数据不完整');
		}

		if (!isMail($email)) {
			return array('status' => 'error', 'msg' => '邮箱格式不正确');
		}

		if (!isMail($email)) {
			return array('status' => 'error', 'msg' => '邮箱格式不正确');
		}

		$models = new MemberModels();
		$memberInfo = $models->getMemberInfo($email);
		if (!$memberInfo) {
			return array('status' => 'error', 'msg' => '邮箱未注册');
		}

		$status = explode(":", $memberInfo['member_password']);
		if (count($status) < 1 || md5(md5($password) . ":" . $status[1]) != $status[0]) {
			return array('status' => 'error', 'msg' => '密码不正确');
		} else {
			return array('status' => 'ok', 'msg' => '登录成功');
		}
	}
}