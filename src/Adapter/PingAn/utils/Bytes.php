<?php

namespace Beehplus\BankAPIHub\Adapter\PingAn\utils;

class Bytes {

    public static function getBytes($str) {
        $bytes = array();
        for ($i = 0; $i < strlen($str); $i++) {
            $bytes[] = ord($str[$i]);
        }
        return $bytes;
    }

    public static function toByte3($int) {
        $array = array();
        $num = decbin($int);
        $num = sprintf("%032d", $num);
        for ($i = 0; $i < 4; $i++) {
            $num2 = substr($num, $i * 8, 8);
            $sign = substr($num2, 0, 1);
            if ($sign == 1) {
                $array[$i] = bindec($num2) - 256;
            } else {
                $array[$i] = bindec($num2);
            }
        }

        return $array;
    }


    public static function getBytes2($str) {

        $len = strlen($str);
        $bytes = array();
        for ($i = 0; $i < $len; $i++) {
            if (ord($str[$i]) >= 128) {
                $byte = ord($str[$i]) - 256;
            } else {
                $byte = ord($str[$i]);
            }
            $bytes[] = $byte;
        }
        return $bytes;
    }

    /**
     * 将字节数组转化为String类型的数据
     * @param $bytes array 字节数组
     * @return string 一个String类型的数据
     */
    public static function toStr($bytes) {
        $str = '';
        foreach ($bytes as $ch) {
            $str .= chr($ch);
        }

        return $str;
    }

    /**
     * 转换一个int为byte数组
     * @param $val string 需要转换的字符串
     * @return array
     */
    public static function integerToBytesPhp($val) {
        $byt = array();
        $byt[0] = ($val & 0xff);
        $byt[1] = ($val >> 8 & 0xff);
        $byt[2] = ($val >> 16 & 0xff);
        $byt[3] = ($val >> 24 & 0xff);
        return $byt;
    }

    //服务器端为java，java字节转int似乎和php字节转int有区别
    public static function integerToBytesJava($int) {
        $b = array();
        $b[0] = ($int >> 24 & 0xff);
        $b[1] = ($int >> 16 & 0xff);
        $b[2] = ($int >> 8 & 0xff);
        $b[3] = ($int & 0xff);
        return $b;
    }

    /**
     * 从字节数组中指定的位置读取一个Integer类型的数据
     * @param $bytes array 字节数组
     * @param $position number 指定的开始位置
     * @return integer
     */
    public static function bytesToInteger($bytes, $position) {
        $val = 0;
        $val = $bytes[$position + 3] & 0xff;
        $val <<= 8;
        $val |= $bytes[$position + 2] & 0xff;
        $val <<= 8;
        $val |= $bytes[$position + 1] & 0xff;
        $val <<= 8;
        $val |= $bytes[$position] & 0xff;
        return $val;
    }

    /**
     * 转换一个shor字符串为byte数组
     * @param $val string 需要转换的字符串
     * @return array
     */
    public static function shortToBytes($val) {
        $byt = array();
        $byt[0] = ($val & 0xff);
        $byt[1] = ($val >> 8 & 0xff);
        return $byt;
    }

    /**
     * 从字节数组中指定的位置读取一个Short类型的数据。
     * @param $bytes array 字节数组
     * @param $position integer 指定的开始位置
     * @return integer
     */
    public static function bytesToShort($bytes, $position) {
        $val = 0;
        $val = $bytes[$position + 1] & 0xFF;
        $val = $val << 8;
        $val |= $bytes[$position] & 0xFF;
        return $val;
    }

}
