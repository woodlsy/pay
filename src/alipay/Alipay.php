<?php

namespace woodlsy\pay\alipay;

use woodlsy\pay\alipay\request\AlipayTradeAppPayRequest;
use woodlsy\pay\alipay\aop\AopClient;

class Alipay
{
    private $aop = null;

    private $bizContent = [];

    private $publicKeyFile = null;

    private $config;

    /**
     * Alipay constructor.
     *
     * @author woodlsy
     * @param array|null $config
     *  [
     *      'appId' => 'xxxxxxx', // app id
     *      'privateKeyFilePath' => '/data/alipay/rsa_private_key_pem', // 私钥地址
     *      'alipayPublicKey' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAuo2LF+uJ7...' // 公钥字符串
     * ]
     */
    public function __construct(array $config = null)
    {
        $this->aop             = new AopClient();
        $this->aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
        $this->aop->signType   = 'RSA2';

        $this->config = $config;

        if (null !== $this->config) {
            if (isset($this->config['appId'])) $this->setAppId($this->config['appId']);
            if (isset($this->config['privateKeyFilePath'])) $this->setRsaPrivateKeyFilePath($this->config['privateKeyFilePath']);
            if (isset($this->config['alipayPublicKey'])) $this->setAlipayPublicKey($this->config['alipayPublicKey']);
        }
    }

    /**
     * 生成app支付参数字符串
     *
     * @author woodlsy
     * @return string
     */
    public function appPay()
    {
        $request = new AlipayTradeAppPayRequest ();
        if (null !== $this->config) {
            if (isset($this->config['notify_url']))$request->setNotifyUrl($this->config['notify_url']);
        }
        $request->setBizContent(json_encode($this->bizContent, JSON_UNESCAPED_UNICODE));
        $result = $this->aop->sdkExecute($request);
        return $result;
    }

    /**
     * 设置appId
     *
     * @author woodlsy
     * @param string $appId
     * @return Alipay
     */
    public function setAppId(string $appId) : Alipay
    {
        $this->aop->appId = $appId;
        return $this;
    }

    /**
     * 设置私钥地址
     *
     * @author woodlsy
     * @param string $path
     * @return Alipay
     */
    public function setRsaPrivateKeyFilePath(string $path) : Alipay
    {
        $this->aop->rsaPrivateKeyFilePath = $path;
        return $this;
    }

    /**
     * 设置支付宝公钥
     *
     * @author woodlsy
     * @param string $publicKey
     * @return Alipay
     */
    public function setAlipayPublicKey(string $publicKey) : Alipay
    {
        $this->publicKeyFile = $publicKey;
        return $this;
    }

    /**
     * 设置加密方式
     *
     * @author woodlsy
     * @param string $signType
     * @return Alipay
     */
    public function setSignType(string $signType) : Alipay
    {
        $this->aop->signType = $signType;
        return $this;
    }

    /**
     * 设置支付金额
     *
     * @author woodlsy
     * @param string $amount
     * @return Alipay
     */
    public function setAmount(string $amount) : Alipay
    {
        $this->bizContent['total_amount'] = $amount;
        return $this;
    }

    /**
     * 设置交易标题
     *
     * @author woodlsy
     * @param string $subject
     * @return Alipay
     */
    public function setSubject(string $subject) : Alipay
    {
        $this->bizContent['subject'] = $subject;
        return $this;
    }

    /**
     * 设置唯一订单号
     *
     * @author woodlsy
     * @param string $orderSn
     * @return Alipay
     */
    public function setOrderSn(string $orderSn) : Alipay
    {
        $this->bizContent['out_trade_no'] = $orderSn;
        return $this;
    }

    /**
     * 设置同步和异步回调时，原样返回的数据
     *
     * @author woodlsy
     * @param array $params
     * @return Alipay
     */
    public function setBackParams(array $params) : Alipay
    {
        $this->bizContent['passback_params'] = $params;
        return $this;
    }

    public function rsaCheckV2(array $params)
    {
        return $this->aop->rsaCheckV2($params, $this->publicKeyFile, $this->aop->signType);
    }

    public function rsaCheckV1(array $params)
    {
        return $this->aop->rsaCheckV1($params, $this->publicKeyFile, $this->aop->signType);
    }
}
