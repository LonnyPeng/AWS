<?php

if (! function_exists('isPost')) {
    /**
     * Whether or not the POST request
     *
     * @return boolean
     */
    function isPost()
    {
        return isset($_SERVER['REQUEST_METHOD']) && 'POST' === $_SERVER['REQUEST_METHOD'];
    }
}

if (! function_exists('isAjax')) {
    /**
     * Whether or not the AJAX request
     *
     * @return boolean
     */
    function isAjax()
    {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH'])
                && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
                || (isset($_REQUEST['X-Requested-With'])
                && $_REQUEST['X-Requested-With'] == 'XMLHttpRequest');
    }
}

if (! function_exists('isJson')) {
    /**
     * Whether or not the JSON
     *
     * @param string $string
     * @return boolean
     */
    function isJson($string = "")
    {
        if (!is_string($string)) {
            return false;
        }

        $result = json_decode($string);
        if (is_object($result)) {
            return true;
        } else {
            return false;
        }
    }
}

if (! function_exists('openJson')) {
    /**
     * If string is json, to array
     *
     * @param string $string
     * @return array
     */
    function openJson($string = '')
    {
        if (!is_string($string)) {
            return false;
        }

        if (!isJson($string)) {
             return false;
        }

        return json_decode($string, true);
    }
}

if (! function_exists('openCsv')) {
    /**
     * Read csv file
     *
     * @param string $path
     * @return array
     */
    function openCsv($path = "")
    {
        if (!file_exists($path) || is_dir($path)) {
            return false;
        }

        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if (strtolower(trim($ext)) !== "csv") {
            return false;
        }

        $data = array();
        $handle = fopen($path, "r");
        while ($re = fgetcsv($handle)) {
            if (!implode("", $re)) {
                break;
            }
            $data[] = $re;
        }

        return $data;
    }
}

if (! function_exists('openXml')) {
    /**
     * Read xml file
     *
     * @param string $path
     * @return array
     */
    function openXml($path = "")
    {
        if (!file_exists($path) || is_dir($path)) {
            return false;
        }

        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if (strtolower(trim($ext)) !== "xml") {
            return false;
        }

        $xml = simplexml_load_file($path);
        if (is_object($xml)) {
            $xml = json_decode(json_encode($xml), true);
        }

        return $xml;
    }
}

if (! function_exists('saveCsv')) {
    /**
     * Save csv file
     *
     * @param array $param
     * @param string $path
     * @return boolean
     */
    function saveCsv($param = array(), $path = "")
    {
        if (file_exists($path) && !is_dir($path)) {
            return false;
        }

        $pathinfo = pathinfo($path);
        if (!isset($pathinfo['extension'])) {
            return false;
        }
        if (strtolower(trim($pathinfo['extension'])) !== "csv") {
            return false;
        }

        if (!makeFile($path)) {
            return false;
        }

        $handle = fopen($path, 'r+');
        foreach ($param as $row) {
            if (!is_array($row)) {
                continue;
            }
            fputcsv($handle, array_map("setText", $row));
        }
        fclose($handle);

        return true;
    }
}

if (! function_exists('csvHeader')) {
    /**
     * Download the csv file
     * 
     * @param string $filename = ""
     */
    function csvHeader($filename = "")   
    {
        header("Content-type:text/csv");   
        header("Content-Disposition:attachment;filename={$filename}");   
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');   
        header('Expires:0');   
        header('Pragma:public');  
    }
}

if (! function_exists('setText')) {
    /**
     * Encoding conversion
     * 
     * @param string $str = ""
     * @return string $str
     */
    function setText($str = "")
    {
        $str = trim($str);
        $str = sprintf("%s", $str);
        $str = iconv("UTF-8", "GBK//IGNORE", $str);
        $str .= "\t";

        return $str;
    }
}

if (! function_exists('sortArray')) {
    /**
     * Sort $array by $sortarray
     *
     * @param array $array
     * @param array $sortArray
     * @return array
     */
    function sortArray($array = array(), $sortArray = array())
    {
        uasort($array, function ($a, $b) use($sortArray) {
            $aIndex = array_search($a, $sortArray);
            $bIndex = array_search($b, $sortArray);
            if ($aIndex < $bIndex) {
                return -1;
            } else {
                return 1;
            }
        });

        return array_values($array);
    }
}

if (! function_exists('toArray')) {
    if (! function_exists('toArray')) {
        function toArray($value)
        {
            return json_decode(json_encode($value), true);
        }
    }
}

if (! function_exists('makeFile')) {
    /**
     * Create new file
     *
     * @param string $path
     * @return boolean
     */
    function makeFile($path = "")
    {
        $path = trim($path);
        if (!$path) {
            return false;
        }

        $path = preg_replace("/\\\\/", "/", $path);

        $filename = substr($path, strripos($path, "/") + 1);
        $ext = substr($filename, strripos($filename, ".") + 1);
        if (!$ext) {
            $filename = "";
        }

        $dirPathInfo = explode("/{$filename}", $path);
        array_pop($dirPathInfo);
        $dirPath = implode("/", $dirPathInfo);

        if ($filename) {
            if (is_dir($path)) {
                return false;
            }

            if (file_exists($path)) {
                return true;
            }
        } else {
            if (is_dir($path)) {
                return true;
            }
        }

        // make dir
        if (!is_dir($dirPath)) {
            if (file_exists($dirPath)) {
                return false;
            }

            if (!@mkdir($dirPath, 0777, true)) {
                if (!is_dir($dirPath)) {
                    return false;
                }
            }
        }

        // make file
        if ($filename) {
            $handle = fopen($path, 'a');
            fclose($handle);
        }

        if (file_exists($path)) {
            return true;
        } else {
            return false;
        }
    }
}

if (! function_exists('getFileInfo')) {
    /**
     * Get the file information
     *
     * @param string $filename
     * @return array
     */
    function getFileInfo($filename = "")
    {
        $pregArr = array(
            "/\f/i" => "/f", "/\n/i" => "/n", "/\r/i" => "/r",
            "/\t/i" => "/t", "/\v/i" => "/v", "/\\\\/" => "/",
        );
        $imgType = array("jpg", "gif", "png");

        // init file path
        foreach ($pregArr as $key => $value) {
            $filename = preg_replace($key, $value, $filename);
        }

        if (!file_exists($filename)) {
            return false;
        }

        $pathinfo = pathinfo($filename);
        if (isset($pathinfo['extension']) && in_array(strtolower($pathinfo['extension']), $imgType)) {
            $imgInfo = getimagesize($filename);
            $pathinfo = array_merge($imgInfo, $pathinfo);
        }

        return $pathinfo;
    }
}

if (! function_exists('searchDir')) {
    /**
     * Read the file directory
     * 
     */
    function searchDir($path = "", &$data = array())
    {
        if (is_dir($path)) {
            $handle = opendir($path);
            while ($re = readdir($handle)) {
                if (in_array($re, array(".", ".."))) {
                    continue;
                }
                searchDir($path . '/' . $re, $data);
            }
            closedir($handle);
        } else {
            $data[] = $path;
        }
    }
}

if (! function_exists('getDir')) {
    /**
     * Read the file directory
     * 
     * @param string $dir = ""
     * @return array
     */
    function getDir($dir = "")
    {
        $data = array();
        searchDir($dir, $data);

        return $data;
    }
}

if (! function_exists('randId')) {
    /**
     * Generate  random
     *
     * @param int $bits
     * @return string
     */
    function randId()
    {
        $key = array(
            mt_rand(),
            microtime(),
            uniqid(mt_rand(), true),
        );
        shuffle($key);
        $str = strtoupper(md5(implode("", $key)));
        
        return implode("-", array(
            substr($str, 0, 8),
            substr($str, 8, 4),
            substr($str, 12, 4),
            substr($str, 16, 4),
            substr($str, 20, 12),
        ));
    }
}

if (! function_exists('randPassword')) {
    /**
     * Generate a random password
     *
     * @param $length
     *
     * @return string
     */
    function randPassword($length = '') {
        $length = (int) $length;
        if ($length < 8) {
            $length = mt_rand(8, 32);
        }

        $data = array(
            'n' => ceil($length * 0.3),
            'l' => ceil($length * 0.4),
            'u' => ceil($length * 0.1),
        );
        $o = $length - $data['n'] - $data['l'] - $data['u'];
        if ($o) {
            $data['o'] = $o;
        } else {
            $data['l'] -= 1;
            $data['o'] = 1;
        }

        $str = "";
        for ($i=0; $i<$length; $i++) {
            foreach ($data as $key => $value) {
                if ($value <= 0) {
                    unset($data[$key]);
                }
            }

            $n = chr(mt_rand(48, 57));
            $l = chr(mt_rand(97, 122));
            $u = chr(mt_rand(65, 90));

            $oArr = array(
                mt_rand(33, 47), mt_rand(58, 64), 
                mt_rand(92, 96), mt_rand(123, 125),
            );
            $o = chr($oArr[array_rand($oArr, 1)]);

            $ke = array_rand($data, 1);

            $str .= $$ke;
            $data[$ke] -= 1;
        }

        return $str;
    }
}

if (! function_exists('convert')) {
    /**
     * Better display of byte size
     *
     * @param number $size
     * 
     * convert(memory_get_usage());
     *
     * @return string
     */
    function convert($size = "") { 
        $unit = array(
            "Bytes", "KB", "MB", 
            "GB", "TB", "PB", 
            "EB", "ZB", "YB",
        ); 

        $i = floor(log($size, 1024));

        return @round($size / pow(1024, ($i)), 2) . ' ' . $unit[$i]; 
    }
}

if (! function_exists('getUrl')) {
    /**
     * Set the URL
     * 
     * @param string $url = ""
     * @return array
     */
    function getUrl($url = "")
    {
        $url = trim($url);
        if (!$url) {
            return false;
        }

        $urlInfo = explode("?", $url);
        if (isset($urlInfo[0])) {
            $urlInfo['url'] = $urlInfo[0];
            unset($urlInfo[0]);
        }

        if (isset($urlInfo[1])) {
            $urlInfo['params'] = array();
            foreach (explode("&", $urlInfo[1]) as $value) {
                if ($value) {
                    $rows = explode("=", $value);
                    $urlInfo['params'][$rows[0]] = isset($rows[1]) ? $rows[1] : '';
                }
            }
            unset($urlInfo[1]);
        }

        return $urlInfo;
    }
}

if (! function_exists('urlInit')) {
    /**
     * Dispose of legitimate URLs
     * 
     * @param string $url = ""
     * @return string
     */
    function urlInit($url = "") 
    {
        $url = strtolower(trim($url));
        if (!$url) {
            return false;
        }

        $errorUrl = array(
            "http://", 
            "https://",
        );
        if (in_array($url, $errorUrl)) {
            return false;
        }

        if (preg_match("/^\/|^#|^javascript|^\?/i", $url)) {
            return false;
        }

        if (!preg_match("/^http:\/\/|^https:\/\//i", $url)) {
            if (preg_match("/^\/\//", $url)) {
                $url = "http:{$url}";
            } else {
                $url = "http://{$url}";
            }
        }

        if (preg_match("/\/$/", $url)) {
            $url = substr($url, 0, strlen($url) - 1);
        }
        if (preg_match('/\/#$/i', $url)) {
            $url = substr($url, 0, strlen($url) - 2);
        }

        return $url;
    }
}

if (! function_exists('curl')) {
    /**
     * Use the curl virtual browser
     *
     * @param array $urlInfo = array('url' => "https://www.baidu.com/", 'params' => array('key' => 'test'), 'cookie' => 'cookie')
     * @param string $type = 'GET|POST'
     * @param boolean $info = false|true
     * @return string|array
     */
    function curl($urlInfo, $type = "GET", $info = false) {
        $type = strtoupper(trim($type));

        if (isset($urlInfo['cookie'])) {
            $cookie = $urlInfo['cookie'];
            unset($urlInfo['cookie']);
        }

        if ($type == "POST") {
            $url = $urlInfo['url'];
            $data = $urlInfo['params'];
        } else {
            $urlArr = parse_url($urlInfo['url']);

            if (isset($urlInfo['params'])) {
                $params = "";
                foreach ($urlInfo['params'] as $key => $row) {
                    if (is_array($row)) {
                        foreach ($row as $value) {
                            if ($params) {
                                $params .= "&" . $key . "=" . $value;
                            } else {
                                $params .= $key . "=" . $value;
                            }
                        }
                    } else {
                        if ($params) {
                            $params .= "&" . $key . "=" . $row;
                        } else {
                            $params .= $key . "=" . $row;
                        }
                    }
                }
                
                if (isset($urlArr['query'])) {
                    if (preg_match("/&$/", $urlArr['query'])) {
                        $urlArr['query'] .= $params;
                    } else {
                        $urlArr['query'] .= "&" . $params;
                    }
                } else {
                    $urlArr['query'] = $params;
                }
            }

            if (isset($urlArr['host'])) {
                if (isset($urlArr['scheme'])) {
                    $url = $urlArr['scheme'] . "://" . $urlArr['host'];
                } else {
                    $url = $urlArr['host'];
                }

                if (isset($urlArr['port'])) {
                    $url .= ":" . $urlArr['port'];
                }
                if (isset($urlArr['path'])) {
                    $url .= $urlArr['path'];
                }
                if (isset($urlArr['query'])) {
                    $url .= "?" . $urlArr['query'];
                }
                if (isset($urlArr['fragment'])) {
                    $url .= "#" . $urlArr['fragment'];
                }
            } else {
                $url = $urlInfo['url'];
            }
        }
        
        $httpHead = array(
            "Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
            "Cache-Control:no-cache",
            "Connection:keep-alive",
            "Pragma:no-cache",
            "Upgrade-Insecure-Requests:1",
        );
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        if (isset($cookie)) {
            curl_setopt($ch, CURLOPT_COOKIE , $cookie);
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHead);
        curl_setopt($ch, CURLOPT_ENCODING , "gzip");
        if ($type == "POST") {
            curl_setopt($ch, CURLOPT_POST, 1);
            @curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        } else {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        }
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_NOBODY, 0);
        $result = curl_exec($ch);
        $curlInfo = curl_getinfo($ch);
        curl_close($ch); 
        
        if ($info) {
            return $curlInfo;
        } else {
            return $result;
        }
    }
}

if (! function_exists('curlMulti')) {
    /**
     * Use the curl multi virtual browser
     *
     * @param array $urlInfos = array(
     *     array('url' => "https://www.baidu.com/", 'params' => array('key' => 'test'), 'cookie' => 'cookie', 'type' => 'GET'),
     *     array('url' => "https://www.google.com/", 'params' => array('key' => 'test'), 'cookie' => 'cookie', 'type' => 'POST'),
     * )
     * @param string $type = 'GET|POST'
     * @param boolean $info = false|true
     * @return string|array
     */
    function curlMulti($urlInfos = array()) {
        $curlArray = $data =  array();
        $httpHead = array(
            "Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
            "Cache-Control:no-cache",
            "Connection:keep-alive",
            "Pragma:no-cache",
            "Upgrade-Insecure-Requests:1",
        );
        $mh = curl_multi_init();

        foreach($urlInfos as $key => $urlInfo) {
            if (isset($urlInfo['type'])) {
                $type = strtoupper(trim($urlInfo['type']));
                unset($urlInfo['type']);
            } else {
                $type = 'GET';
            }

            if (isset($urlInfo['cookie'])) {
                $cookie = $urlInfo['cookie'];
                unset($urlInfo['cookie']);
            }

            if ($type == "POST") {
                $url = $urlInfo['url'];
                $data = $urlInfo['params'];
            } else {
                $urlArr = parse_url($urlInfo['url']);

                if (isset($urlInfo['params'])) {
                    $params = "";
                    foreach ($urlInfo['params'] as $ke => $row) {
                        if (is_array($row)) {
                            foreach ($row as $value) {
                                if ($params) {
                                    $params .= "&" . $ke . "=" . $value;
                                } else {
                                    $params .= $ke . "=" . $value;
                                }
                            }
                        } else {
                            if ($params) {
                                $params .= "&" . $ke . "=" . $row;
                            } else {
                                $params .= $ke . "=" . $row;
                            }
                        }
                    }

                    if (isset($urlArr['query'])) {
                        if (preg_match("/&$/", $urlArr['query'])) {
                            $urlArr['query'] .= $params;
                        } else {
                            $urlArr['query'] .= "&" . $params;
                        }
                    } else {
                        $urlArr['query'] = $params;
                    }
                }

                if (isset($urlArr['host'])) {
                    if (isset($urlArr['scheme'])) {
                        $url = $urlArr['scheme'] . "://" . $urlArr['host'];
                    } else {
                        $url = $urlArr['host'];
                    }

                    if (isset($urlArr['port'])) {
                        $url .= ":" . $urlArr['port'];
                    }
                    if (isset($urlArr['path'])) {
                        $url .= $urlArr['path'];
                    }
                    if (isset($urlArr['query'])) {
                        $url .= "?" . $urlArr['query'];
                    }
                    if (isset($urlArr['fragment'])) {
                        $url .= "#" . $urlArr['fragment'];
                    }
                } else {
                    $url = $urlInfo['url'];
                }
            }

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            if (isset($cookie)) {
                curl_setopt($ch, CURLOPT_COOKIE , $cookie);
            }
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHead);
            curl_setopt($ch, CURLOPT_ENCODING , "gzip");
            if ($type == "POST") {
                curl_setopt($ch, CURLOPT_POST, 1);
                @curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            } else {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            }
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36");
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_NOBODY, 0);

            $curlArray[$key] = $ch;
            curl_multi_add_handle($mh, $curlArray[$key]);
        }

        $running = 0;
        do {
            usleep(10000);
            curl_multi_exec($mh, $running);
        } while($running > 0);

        foreach($urlInfos as $key => $urlInfo) {
            $data[$key] = curl_multi_getcontent($curlArray[$key]);
            curl_multi_remove_handle($mh, $curlArray[$key]);
        }
        curl_multi_close($mh);

        return $data;
    }
}

if (! function_exists('pregHtml')) {
    /**
     * Regular match HTML
     *
     * @param string $html = ""
     * @param string $preg = ""
     * @param boolean $status = true|false
     * @return string
     */
    function pregHtml($html = "", $preg = "", $status = true)
    {
        $pregInit = array(
            'clear' => "/\f|\n|\r|\t|\v/",
            'spaces' => "/[ ]{2,}/",
            'css' => "/<style[^>]*>.+?<\/style>/i",
            'js' => "/<script[^>]*>.+?<\/script>/i",
            'nojs' => "/<noscript[^>]*>.+?<\/noscript>/i",
            'notes' => "/<!.*?>/",
        );

        //init
        $html = trim($html);
        foreach ($pregInit as $key => $value) {
            switch ($key) {
                case 'clear':
                    $html = preg_replace($value, "", $html);
                    break;
                case 'spaces':
                    $html = preg_replace($value, " ", $html);
                    break;
                default:
                    if ($status) {
                        $src = pregHtml($html, $value, false);
                        if (is_array($src)) {
                            foreach ($src as $val) {
                                $html = str_replace($val, "", $html);
                            }
                        } else {
                            $html = str_replace($src, "", $html);
                        }
                    }
                    break;
            }
        }

        if (!$preg) {
            return $html;
        }

        //action
        preg_match_all($preg, $html, $pregArr);

        if (isset($pregArr[1])) {
            if (count($pregArr[1]) == 1) {
                $pregArr = $pregArr[1][0];
            } else {
                $pregArr = $pregArr[1];
            }
        } else {
            if (count($pregArr[0]) == 1) {
                $pregArr = $pregArr[0][0];
            } else {
                $pregArr = $pregArr[0];
            }
        }

        return is_array($pregArr) ? array_unique($pregArr) : $pregArr;
    }
}

if (! function_exists('getTags')) {
    /**
     * Get the HTML tag
     *
     * @param string $str = ""
     * @return array
     */
    function getTags($str = "")
    {
        $oneTag = array(
            "meta", "link", "input", "img", "br", "hr", "param",
        );
        $data = $tagArr = array();

        for($i=0;;$i++) {
            $str = trim($str);
            if (preg_match("/^</", $str)) {
                if (preg_match("/^<\//", $str)) {
                    //right tag
                    $lastStatus = stripos($str, ">");
                    $rightTag = substr($str, 0, $lastStatus + 1);
                    $tag = pregHtml($rightTag, "/^<\/([a-z1-6]+)>/i");

                    foreach ($tagArr as $key => $value) {
                        $valTag = pregHtml($value, "/^<([a-z1-6]+)[\s]?.*[\/]?>/i");
                        if ($tag == $valTag) {
                            $leftTag = $value;
                            $tagKey = $key;
                        }
                    }

                    $lastDataKey = array_search(end($data[$leftTag]), $data[$leftTag]);
                    foreach ($data[$leftTag] as $key => $value) {
                        if (!isset($value['right'])) {
                            $lastDataKey = $key;
                        }
                    }

                    $data[$leftTag][$lastDataKey]['right'] = $rightTag;
                    unset($tagArr[$tagKey]);

                    $str = substr($str, $lastStatus + 1, strlen($str) - $lastStatus);
                } else {
                    //left tag
                    $lastStatus = stripos($str, ">");
                    $leftTag = substr($str, 0, $lastStatus + 1);
                    $tag = pregHtml($leftTag, "/^<([a-z1-6]+)[\s]?.*[\/]?>/i");

                    $data[$leftTag][$i]['tags'] = $tagArr;
                    $data[$leftTag][$i]['left'] = $leftTag;
                    if (preg_match("/\/>$/", $leftTag) || in_array($tag, $oneTag)) {
                        //no right tag
                        $data[$leftTag][$i]['right'] = "";
                    } else {
                        //have right tag
                        $tagArr[] = $leftTag;
                    }

                    $str = substr($str, $lastStatus + 1, strlen($str) - $lastStatus);
                }
            } else {
                //content
                $startStatus = stripos($str, "<");
                $content = substr($str, 0, $startStatus);
                $lastTagKey = end($tagArr);
                $currentData= $data[$lastTagKey];
                $data[$lastTagKey][array_search(end($currentData), $currentData)]['content'] = $content;

                $str = substr($str, $startStatus, strlen($str) - $startStatus);
            }

            if (!$str) {
                break;
            }
        }

        return $data;
    }
}

if (! function_exists('translation')) {
    /**
     * Google translation 01
     *
     * @param array $tranInfo = array('tl' => 'zh-CN', 'text' => "Hello World")
     * @return array
     */
    function translation($tranInfo = array('tl' => 'en', 'text' => 'Hello World'))
    {
        if (!isset($tranInfo['tl']) || !isset($tranInfo['text'])) {
            return false;
        }

        $urlInfo = array(
            'url' => 'http://translate.google.com/translate_t',
            'params' => array(
                'client' => 't',
                'sl' => 'auto',
                'tl' => $tranInfo['tl'],
                'ie' => 'UTF-8',
                'text' => $tranInfo['text'],
            ),
        );
        $html = curl($urlInfo);

        $title = urldecode($tranInfo['text']);
        $title = preg_replace("/[ ]+/", " ", $title);
        $pregArr = array(
            'key_1' => "/<span[\s]?title[\s]*=[\s]*[\"|']?{$title}[\"|']?[^>]*>/i",
            'key_2' => "/<span[\s]?id[\s]*=[\s]*[\"|']?result_box[\"|']?[^>]*>/i",
        );

        $html = pregHtml($html);
        $html = preg_replace("/&#39;/", "'", $html);
        $data = getTags($html);
        $content = "";
        foreach ($data as $key => $value) {
            if (preg_match($pregArr['key_1'], $key) || preg_match($pregArr['key_2'], $key)) {
                $row = reset($value);
                $content = isset($row['content']) ? $row['content'] : "";
            }
        }
        
        return $content;
    }
}

if (! function_exists('baike')) {
    /**
     * Get Baidu Encyclopedia
     *
     * @param string $name = ""
     * @return string
     */
    function baike($name = "")
    {
        $pregArr = array(
            'url' => "/<a[\w\s=\"]*href[\s]*=[\s]*[\"|']{1}http:\/\/www.baidu.com\/link\?url=([\S]*)[\"|']{1}[^>]*><em>{$name}<\/em>/i",
            'baike' => "/<div[\w\s=\"]*class[\s]*=[\s]*[\"|']{1}para[\"|']{1}[^>]*>(.*?)<\/div>/i",
        );

        $urlInfo = array(
            'url' => 'http://www.baidu.com/s',
            'params' => array(
                'wd' => urlencode($name),
            ),
        );
        $html = curl($urlInfo);
        $html = pregHtml($html, $pregArr['url']);
        if (!isset($html[0])) {
            return false;
        }

        $urlInfo = array(
            'url' => 'http://baike.baidu.com/link',
            'params' => array(
                'url' => $html[0],
            ),
        );
        $html = curl($urlInfo);

        $html = pregHtml($html, $pregArr['baike']);
        if (is_array($html)) {
            $str = "";
            foreach ($html as $value) {
                $str .= strip_tags($value);
            }

            $html = $str;
        }
        $html = str_replace("&nbsp;", " ", $html);

        return $html; 
    }
}

if (! function_exists('getCountryFlag')) {
    /**
     * Get the flag (svg)
     *
     * @param string $name = "ca"
     * @return string
     */
    function getCountryFlag($name = "ca")
    {
        $flagname = strtolower(trim($name));
        $url = "http://lipis.github.io/flag-icon-css/flags/4x3/{$flagname}.svg";
        $recult = @file_get_contents($url);

        return $recult;
    }
}

if (! function_exists('dateDiff')) {
    /*
     * Get Get time difference
     *
     * @param string $start = '2017-03-21'
     * @param string $end = '2017-03-24'
     *
     * @return number
     */
    function dateDiff($start = '', $end = '')
    {
        $diff = '';
        $start = strtotime(trim($start));
        $end = strtotime(trim($end));
        if (!$start) {
            return false;
        }
        if (!$end) {
            $end = time();
        }

        return floor(($start - $end) / 86400);
    }
}
