<?php

namespace Beehplus\BankAPIHub\Adapter\PingAn;


use Beehplus\BankAPIHub\Adapter\PingAn\utils\Common;
use Beehplus\BankAPIHub\Adapter\PingAn\utils\RSASignature;
use Beehplus\BankAPIHub\Base\InvalidConfigException;

class Server {
    private $keyValue = array();
    public $url;
    public $keyPath;
    public $publicKeyPath;
    public $clientPassword;
    public $fixParam;

    /**
     * Server constructor.
     * @param array $config
     */
    public function __construct($config = []) {
        // 后续的 key=value& 串严格按照数组元素定义的序列排序
        // 数组“键”的字母大小写，严格按照下面定义的
        $this->url = $config['url'];
        $this->keyPath = $config['key_path'];
        $this->publicKeyPath = $config['public_key_path'];
        $this->clientPassword = $config['client_password'];

        if (is_array($config['fix_param'])) {
            $this->keyValue['ApiVersionNo'] = $config['fix_param']['api_version_no'];
            $this->keyValue['ApplicationID'] = $config['fix_param']['application_id'];
            $this->keyValue['RequestMode'] = $config['fix_param']['request_mode'];
            $this->keyValue['SDKType'] = $config['fix_param']['sdk_type'];
            $this->keyValue['SdkSeid'] = $config['fix_param']['sdk_seid'];
            $this->keyValue['SdkVersionNo'] = $config['fix_param']['sdk_version_no'];
            $this->keyValue['TranStatus'] = $config['fix_param']['tran_status'];
            $this->keyValue['TxnTime'] = $config['fix_param']['txn_time'];
            $this->keyValue['ValidTerm'] = $config['fix_param']['valid_term'];
        }
    }

    /**
     * 初始化服务的基本参数，并对keyValue数组进行排序
     *
     * @param string $serverId
     * @param array $changeParam
     * @param string $accessToken
     */
    private function initServer(string $serverId, array $changeParam, string $accessToken) {
        $this->url = $this->url . '/' . $serverId;
        $this->keyValue['AppAccessToken'] = $accessToken;
        $this->keyValue = array_merge($this->keyValue, $changeParam);
        ksort($this->keyValue);  //数组键，按照字母排序
    }

    /**
     * 执行调用远程函数对方法
     *
     * @param string $serverId
     * @param array $changeParam
     * @param string $accessToken
     * @return array|mixed
     * @throws InvalidConfigException
     * @throws utils\HttpException
     * @throws \Exception
     */
    public function execute(string $serverId, array $changeParam, string $accessToken) {
        $this->initServer($serverId, $changeParam, $accessToken);
        $returnData = array();
        $keyValueStr = '';
        foreach ($this->keyValue as $key => $value) {
            if ($value == '' || $value == null) {
                continue;
            }
            $keyValueStr .= $key . '=' . $value . '&';
        }

        //字符串加签开始------------------------------------------------
        if (!file_exists($this->keyPath)) {
            throw new InvalidConfigException('file does not exist');
        } else {
            $pfxContent = file_get_contents($this->keyPath);
        }
        $pfxArrar = RSASignature::openssl_pkcs12($pfxContent, $this->clientPassword);
        $RsaSign = RSASignature::sign($keyValueStr, $pfxArrar['pkey'], false);

        //数组SDKType之前添加RsaSign元素（服务端验签有此顺序要求）
        $element['RsaSign'] = $RsaSign;
        $this->keyValue = Common::arrayKeyPush($this->keyValue, $element, 'SDKType');
        $KeyValueJSON = json_encode($this->keyValue);
        //发起请求------------------------------------------------------------

        $httpResult = Common::curlHttp($this->url, $KeyValueJSON, $isPost = true);

        //对响应数据，进行验签开始--------------------------------------------
        $resArray = json_decode($httpResult, true);
        //如果只选成功，不返回错误码errorCode
        if (!empty($resArray['errorCode'])) {
            $returnData['error'] = 1;
            $returnData['msg'] = $httpResult;
            return $returnData;
        }


        $data = '';
        foreach ($resArray as $key => $value) {
            if ($value === '' || $value === null) {
                continue;
            }
            if ($key == 'RsaSign') {
                continue;
            }
            if (!is_array($value)) {
                $data .= $key . '=' . $value . '&';
            }
            if ($key == 'TranInfoArray') {
                if ($resArray['TranInfoArray'] != '' || $resArray['TranInfoArray'] != null) {
                    foreach ($resArray['TranInfoArray'][0] as $k => $val) {
                        if ($val == '' || $val == null) {
                            continue;
                        }
                        if (!is_array($val)) {
                            $data .= $key . $k . '=' . $val . '&';
                        }
                    }
                }
            }
        }
        $public_key = file_get_contents($this->publicKeyPath);  //读取平台证书公钥
        $verifyResult = RSASignature::verify($data, $resArray['RsaSign'], $public_key); //进行验签
        if ($verifyResult == 1) {
            $returnData = $resArray;
            $returnData['error'] = 0;
            unset($returnData['RsaSign']);
            return $returnData;
        } else {
            $returnData['error'] = 1;
            $returnData['msg'] = 'verify failed!';
            return $returnData;
        }

    }

}