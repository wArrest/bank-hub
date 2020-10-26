<?php

namespace Beehplus\BankAPIHub\Adapter\PingAn\utils;


class RSASignature {

    /**
     * 签名方法
     *
     * @param $keyValueStr
     * @param $pkey
     * @param bool $repSpecCahr
     * @return mixed|string
     */
    public static function sign($keyValueStr, $pkey, $repSpecCahr = false) {
        $pkeyid = openssl_pkey_get_private($pkey);  //返回资源
        openssl_sign($keyValueStr, $signature, $pkeyid, OPENSSL_ALGO_MD5);
        openssl_free_key($pkeyid);
        $signMsg = base64_encode($signature);
        if ($repSpecCahr == true) {
            $signMsg = Common::replaceSpecialChar($signMsg);
        }
        return $signMsg;
    }

    /**
     * 获取平台公钥，进行验签
     *
     * @param $data
     * @param $sign
     * @param $publickey
     * @return int
     */
    public static function verify($data, $sign, $publickey) {
        $pkeyid = openssl_pkey_get_public($publickey);
        $sign = base64_decode($sign);
        $verify = openssl_verify($data, $sign, $pkeyid, OPENSSL_ALGO_MD5);
        openssl_free_key($pkeyid);
        return $verify;
    }


    /**
     * 商户证书公钥
     *
     * @param $pemContent
     * @return array
     */
    public static function pfxPublicKey($pemContent) {
        $publicKey = openssl_get_publickey($pemContent);
        $details = openssl_pkey_get_details($publicKey);
        return $details;
    }

    /**
     * @param $pfxContent
     * @param $clientPassword
     * @return array
     * @throws \Exception
     */
    public static function openssl_pkcs12($pfxContent, $clientPassword) {
        if (!empty($pfxContent)) {
            $certs = array();
            if (openssl_pkcs12_read($pfxContent, $certs, $clientPassword)) {
                return $certs;
            } else {
                throw new \Exception('pkcs file content read fail');
            }
        }
    }

    /**
     * openssl_x509
     *
     * @param $cert
     * @return mixed
     */
    public static function openssl_x509($cert) {
        $keyCry = array();
        $res = openssl_x509_read($cert);
        //解析
        $details = openssl_x509_parse($res);
        return $details['subject'];
    }
}