<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use App\Http\Models\MemberModel as MemberModels;
use DB;

class WebController extends Controller
{
	protected $maxTime = 10;

    public function index()
    {
    	if (!isAjax()) {
    		return false;
    	}

    	$models = new MemberModels();

        $startTime = time();
        $url = trim(Input::get('url'));
        if (!preg_match('/^http:\/\//i', $url)) {
            $url = "http://" . $url;
        }

        $where = sprintf("web_name = '%s'", $url);
        $recult = $models->getTable("t_save_web", "web_file", array("setWhere" => $where));
        if ($recult) {
             $updateFileName = $recult[0]['web_file'];
        } else {
            $file = WWW_ROOT . "update/";
            $updateFile = date('Y') . "/" . date('md') . "/";
            $updateFileName = $updateFile . md5(microtime() . $url);
            makeFile($file . $updateFile);

            $strArr = array(
                "phantomjs",
                WWW_ROOT . "static/dist/js/save_img.js",
                $url,
                $file . $updateFileName . ".jpg",
                $file . $updateFileName . ".html",
                "2>&1",
            );

            exec(implode(" ", $strArr), $log, $status);
            //print_r(implode(" ", $strArr));die;

            for ($i=0;;$i++) {
                if (time() - $startTime > $this->maxTime) {
                    break;
                }
                if (file_exists($file . $updateFileName . ".jpg")) {
                	$sql = "INSERT INTO t_save_web 
                			SET web_name = :web_name,
                            web_ip = '127.0.0.1', 
                			web_file = :web_file";
                	DB::insert($sql, array('web_name' => $url, 'web_file' => $updateFileName));
                    break;
                }
            }
        }

        $src = "http://" . $_SERVER['HTTP_HOST'] . '/update/' . $updateFileName . '.jpg';

        return json_encode(array(
        	'status' => 'ok',
        	'msg' => "",
        	'data' => $src,
        ));
    }

    public function translation()
    {
        if (!isAjax()) {
            return false;
        }

        $key = trim(Input::get('key'));
        $tl = trim(Input::get('tl'));

        $result = translateGoogleApi(['tl' => $tl, 'text' => $key]);

        return json_encode(array(
            'status' => 'ok',
            'msg' => "",
            'data' => $result,
        ));
    }
}
