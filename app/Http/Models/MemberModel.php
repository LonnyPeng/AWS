<?php

namespace App\Http\Models;

use App\Http\Models\CommonModel;
use DB;

class MemberModel extends CommonModel
{
	public function getTable($table = "", $files = "*", $initSql = array("setJoin" => '', "setWhere" => '', "setGroupBy" => '', "setOrderBy" => '', "setLimit" => ''))
	{
		$files = $this->setFile($files);
		$table = $this->setTable($table);
	    $sql = "SELECT {$files} FROM {$table}";
	    $sql = $this->setSql($sql, $initSql);

	    $result = DB::select($sql);
	    $result = array_map("toArray", $result);

	    return $result;
	}
}
