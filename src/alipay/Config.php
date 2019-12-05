<?php
namespace woodlsy\pay\alipay;

use woodlsy\pay\alipay\aop\AopClient;

class Config
{
    protected $aop = null;

    protected $config;

    protected $publicKeyFile = null;

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
     * 设置appId
     *
     * @author woodlsy
     * @param string $appId
     * @return $this
     */
    public function setAppId(string $appId)
    {
        $this->aop->appId = $appId;
        return $this;
    }

    /**
     * 设置私钥地址
     *
     * @author woodlsy
     * @param string $path
     * @return $this
     */
    public function setRsaPrivateKeyFilePath(string $path)
    {
        $this->aop->rsaPrivateKeyFilePath = $path;
        return $this;
    }

    /**
     * 设置支付宝公钥
     *
     * @author woodlsy
     * @param string $publicKey
     * @return $this
     */
    public function setAlipayPublicKey(string $publicKey)
    {
        $this->publicKeyFile = $publicKey;
        return $this;
    }
}