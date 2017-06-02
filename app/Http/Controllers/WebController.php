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
        if (!isPost()) {
            return false;
        }

        $key = trim(Input::get('key'));
        $tk = trim(Input::get('tk'));
        $tl = trim(Input::get('tl'));

        $result = $this->translationApi(array('tl' => $tl, 'text' => $key, 'tk' => $tk));

        return json_encode(array(
            'status' => 'ok',
            'msg' => "",
            'data' => $result,
        ));
    }

    /**
     * Google translation api
     *
     * @param array $tranInfo = array('tl' => 'zh-CN', 'text' => "Hello World", 'TKK' => '')
     * @return string
     */
    public function translationApi($tranInfo = array('tl' => 'en', 'text' => 'Hello World', 'tk' => ''), $status = false)
    {
        $langArr = array(
            "sq", "ar", "am", "az", "ga", "et", "eu", "be", "bg", "is", "pl", "bs", "fa", "af", "da", "de", "ru", "fr", "tl", "fi", 
            "fy", "km", "ka", "gu", "kk", "ht", "ko", "ha", "nl", "ky", "gl", "ca", "cs", "kn", "co", "hr", "ku", "la", "lv", "lo", 
            "lt", "lb", "ro", "mg", "mt", "mr", "ml", "ms", "mk", "mi", "mn", "bn", "my", "hmn", "xh", "zu", "ne", "no", "pa", "pt", 
            "ps", "ny", "ja", "sv", "sm", "sr", "st", "si", "eo", "sk", "sl", "sw", "gd", "ceb", "so", "tg", "te", "ta", "th", "tr", 
            "cy", "ur", "uk", "uz", "es", "iw", "el", "haw", "sd", "hu", "sn", "hy", "ig", "it", "yi", "hi", "su", "id", "jw", "en", 
            "yo", "vi", "zh-TW", "zh-CN", 
        );
        if (!isset($tranInfo['tl']) || !in_array($tranInfo['tl'], $langArr)) {
            $tranInfo['tl'] = 'en';
        }

        if (!isset($tranInfo['text'])) {
            return false;
        }

        $urlInfo = array(
            'url' => "https://translate.google.cn/translate_a/single",
            'params' => array(
                'client' => "t",
                'sl' => "auto",
                'tl' => $tranInfo['tl'],
                'dt' => array(
                    "at", "bd", "ex", "ld", "md",
                    "qca", "rw", "rm", "ss", "t",
                ),
                'tk' => $tranInfo['tk'],
                'q' => urlencode($tranInfo['text']),
            ),
        );
        
        $apiSstatus = curl($urlInfo, '', true);
        if ($apiSstatus['http_code'] != 200) {
            return "HTTP ERROR " . $apiSstatus['http_code'];
        }

        $html = curl($urlInfo);
        $data = json_decode($html);

        if ($status) {
            return $data;
        } else {
            $str = "";
            foreach ($data[0] as $row) {
                $str .= $row[0];
            }

            return $str;
        }
    }
}
