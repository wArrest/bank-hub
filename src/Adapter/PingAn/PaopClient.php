<?php

namespace Beehplus\BankAPIHub\Adapter\PingAn;


use Beehplus\BankAPIHub\Adapter\PingAn\utils\Common;
use Beehplus\BankAPIHub\Adapter\PingAn\utils\RSASignature;
use Beehplus\BankAPIHub\Base\InvalidConfigException;

class PaopClient {
    //应用ID
    public $appId;

    //用户验证url
    public $publicUrl;

    //商户证书路径
    public $keyPath;

    //商户证书密码
    public $clientPassword;

    //平台证书路径
    public $publicKeyPath;

    //加密类型
    public $type;

    // 接入客户端编码默认utf8
    // public $charset = 'UTF-8';

    /**
     * PaopClient constructor.
     * @param array $config
     */
    public function __construct($config = []) {
        $this->appId = $config['app_id'];
        $this->publicUrl = $config['public_url'];
        $this->keyPath = $config['key_path'];
        $this->clientPassword = $config['client_password'];
        $this->publicKeyPath = $config['public_key_path'];
        $this->type = $config['type'];
    }

    /**
     * @return array|mixed
     * @throws InvalidConfigException
     * @throws utils\HttpException
     * @throws \Exception
     */
    public function getToken() {
        $signArray = array();
        $signArray['ApplicationID'] = $this->appId;

        if (!file_exists($this->keyPath)) {
            throw new \Exception($this->keyPath . ' file does not exist');
        } else {
            $pfxContent = file_get_contents($this->keyPath);
        }


        //获取pk
        $pfxArray = RSASignature::openssl_pkcs12($pfxContent, $this->clientPassword);
        if (!empty($pfxArray)) {
            $signArray['PK'] = $this->PK($pfxArray['cert']);
        }

        //获得DN
        $cert = RSASignature::openssl_x509($pfxArray['cert']);
        $signArray['DN'] = $this->DN($cert);

        //随机数 6位0-9
        $signArray['RandomNumber'] = Common::get_random(6);

        $signArray['SDKType'] = 'api';
        //加签
        $keyValueStr = 'ApplicationID=' . $this->appId . '&RandomNumber=' . $signArray['RandomNumber'] . '&SDKType=' . $signArray['SDKType'] . '&';
        $signArray['RsaSign'] = RSASignature::sign($keyValueStr, $pfxArray['pkey'], true);
        $jsonStr = json_encode($signArray);

        //请求
        $data = Common::curlHttp($this->publicUrl, $jsonStr, $isPost = true);

        //验签
        $result = array();

        if (!file_exists($this->publicKeyPath)) {
            throw new InvalidConfigException($this->publicKeyPath . ' file does not exist');
        } else {
            $public_key = file_get_contents($this->publicKeyPath);
        }

        $responseArray = json_decode($data, true);
        if ($responseArray['errorCode'] == 'OPEN-E-000000') {
            $verifyContent = 'appAccessToken=' . $responseArray['appAccessToken'] . '&';
            $verifyRsult = RSASignature::verify($verifyContent, $responseArray['RsaSign'], $public_key);
            if ($verifyRsult == 1) {
                $result['error'] = 0;
                $result['appAccessToken'] = $responseArray['appAccessToken'];
            } else {
                $result['error'] = 1;
                $result['errorMsg'] = 'verify failed!';
            }
        } else {
            $result = $responseArray;
            $result['error'] = 1;
        }


        return $result;
    }

    /*
     * 获得PK
     */
    private function PK($pemContent) {
        $details = RSASignature::pfxPublicKey($pemContent);
        //去掉回车换行等特殊字符
        $publicKeyBegin = str_replace("-----BEGIN PUBLIC KEY-----", '', $details['key']);
        $publicKeyEnd = str_replace("-----END PUBLIC KEY-----", '', $publicKeyBegin);
        return $publicKey = Common::replaceSpecialChar($publicKeyEnd);
    }

    /*
     * 获得DN
     */
    private function DN($cert) {
        $dn = 'CN=' . $cert['CN'] . ',OU=' . $cert['OU'][1] . ',OU=' . $cert['OU'][0] . ',O=' . $cert['O'] . ',C=' . $cert['C'];
        return Common::replaceSpecialChar($dn);
    }
}