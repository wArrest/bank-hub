<?php


namespace Beehplus\BankAPIHub\Adapter\CCB\utils;

class Crypt
{
    /**
     **DES 加密
     **$data 待加密明文
     **$deskey 加密秘钥
     **/
    public static function des_encrypt($data,$deskey){
        $blocksize = mcrypt_get_block_size(MCRYPT_DES,MCRYPT_MODE_ECB);
        $pad = $blocksize - (strlen($data) % $blocksize);
        $data1 = $data. str_repeat(chr($pad),$pad);
        $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_DES,MCRYPT_MODE_ECB),MCRYPT_RAND); //初始化向量
        $data_encrypt  = mcrypt_encrypt(MCRYPT_DES,$deskey,$data1,MCRYPT_MODE_ECB);//加密函数
        $datastr = bin2hex($data_encrypt);
        return $datastr;
    }
    public static function new_des_encrypt($data,$deskey){

    }
    /**
     **DES 解密
     **$data 待解密密文
     **$deskey 加密秘钥
     **/
    public static function  des_decrypt($endata,$deskey){
        $de_datastr = $endata !== false && preg_match('/^[0-9a-fA-F]+$/i',$endata) ? pack('H*',$endata):false;
        @$data_decrypt = mcrypt_decrypt(MCRYPT_DES,$deskey,$de_datastr,MCRYPT_MODE_ECB,null);//解密函数
        $ret = self::_pkcs5Unpad($data_decrypt);
        $de_data = trim($ret);
        return $de_data;
    }

    /**
     **MD5 加密
     **/
    public static function md5_encrypt($data){
        return md5($data);
    }

    public static function _pkcs5Unpad($text){
        $pad = ord($text{strlen($text)-1});
        if($pad > strlen($text)) return false;
        if(strspn($text,chr($pad),strlen($text)-$pad) != $pad) return false;
        $ret = substr($text,0,-1*$pad);
        return $ret;
    }
}