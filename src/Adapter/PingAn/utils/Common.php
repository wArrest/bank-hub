<?php

namespace Beehplus\BankAPIHub\Adapter\PingAn\utils;

class Common {
    /**
     * 检查php扩展库是否加载
     */
    public static function extensionCheck($extension) {
        $msg = array('statusCode', 'statusInfo');
        if (!extension_loaded($extension)) {
            $msg['statusCode'] = false;
            $msg['statusInfo'] = '必须开启' . $extension . '扩展库,请在php.ini中设置';
        } else {
            $msg['statusCode'] = true;
            $msg['statusInfo'] = $extension . '已经开启';
        }
        return $msg;
    }

    /**
     * 特殊字符过滤
     */
    public static function replaceSpecialChar($str) {
        $search = array(" ", "　", "\n", "\r", "\t", "+", "=");
        $replace = array("", "", "", "", "", "%2B", "%3D");
        return $str = str_replace($search, $replace, $str);
    }

    /**
     * 获取6位随机数字
     */
    public static function get_random($len = 6) {
        $numbers = '0123456789';
        $random = "";
        for ($i = 0; $i < $len; $i++) {
            $random .= $numbers{mt_rand(0, 9)};
        }
        return $random;
    }

    /**
     * 获取文件大小（单位：字节）
     */
    public static function fileSizes($fileName) {
        if (file_exists($fileName)) {
            $data = abs(filesize($fileName));
        } else {
            $data = false;
        }
        return $data;
    }

    /**
     * 数组转xml
     */
    public static function safeArrayToXml($arr, $dom = null, $node = null, $root, $cdata = false) {
        if (!$dom) {
            $dom = new DOMDocument('1.0', 'UTF-8');
        }
        $node = $dom->createElement($root);
        $dom->appendChild($node);
        foreach ($arr as $key => $value) {
            $child_node = $dom->createElement(is_string($key) ? $key : 'node');
            $node->appendChild($child_node);
            if (!is_array($value)) {
                if (!$cdata) {
                    $data = $dom->createTextNode($value);
                } else {
                    $data = $dom->createCDATASection($value);
                }
                $child_node->appendChild($data);
            }
        }
        return $dom->saveXML();
    }

    public static function xmlToArray($xml) {
        $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $values;
    }

    /**
     * 转码
     */
    public static function iconvStr($str, $beforeEncode, $afterEncode) {
        $postXml = '';
        $encode = mb_detect_encoding($str, array("ASCII", "UTF-8", "GB2312", "GBK", "BIG5"));
        if ($encode == $beforeEncode) {
            $postXml = iconv($beforeEncode, $afterEncode, $str);
        } else {
            $postXml = iconv($encode, $afterEncode, $str);
        }
        return $postXml;
    }

    /**
     * Curl请求
     *
     * @param $url
     * @param $requestStr
     * @param bool $isPost
     * @return mixed
     * @throws HttpException
     */
    public static function curlHttp($url, $requestStr, $isPost = true) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0); //定义是否显示状态头 1：显示 ； 0：不显示
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestStr);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_POST, $isPost);
        $response = curl_exec($ch);

        $resinfo = curl_getinfo($ch);
        curl_close($ch);

        if ($resinfo["http_code"] != 200) {
            throw new HttpException("response status code is not valid. status code: " . $resinfo["http_code"]);
        }
        return $response;
    }

    /**
     * 删除指定位置的子字符串
     */
    public static function delSonStr($str, $begin, $length) {
        $substr = substr($str, $begin, $length);
        $str = str_replace($substr, '', $str);
        return $newStr = trim($str, ' ');
    }

    /**
     * 本地文件和远程文件，扩展名比较
     */
    public static function extension($file1, $file2) {
        $fileExts1 = pathinfo($file1, PATHINFO_EXTENSION);
        $fileExts2 = pathinfo($file2, PATHINFO_EXTENSION);
        if ($fileExts1 != $fileExts2) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 关联数组指定key之前添加元素
     */
    public static function arrayKeyPush($array, $data = null, $key = false) {
        $data = (array)$data;
        $offset = ($key === false) ? false : array_search($key, array_keys($array));
        $offset = ($offset) ? $offset : false;
        if ($offset) {
            return array_merge(array_slice($array, 0, $offset), $data, array_slice($array, $offset));
        } else {  // 没指定 $key 或者找不到，就直接加到末尾
            return array_merge($array, $data);
        }
    }

}