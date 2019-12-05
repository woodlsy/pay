<?php

namespace woodlsy\pay\alipay;

use woodlsy\pay\alipay\request\AlipayTradeAppPayRequest;
use woodlsy\pay\alipay\aop\AopClient;

class Alipay extends Config
{

    private $bizContent = [];


    /**
     * 生成app支付参数字符串
     *
     * @author woodlsy
     * @return string
     */
    public function appPay()
    {
        $request = new AlipayTradeAppPayRequest();
        if (null !== $this->config) {
            if (isset($this->config['notify_url']))$request->setNotifyUrl($this->config['notify_url']);
        }
        $request->setBizContent(json_encode($this->bizContent, JSON_UNESCAPED_UNICODE));
        $result = $this->aop->sdkExecute($request);
        return $result;
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

    /**
     * RSA加密验签
     *
     * @author woodlsy
     * @param array $params
     * @return bool
     */
    public function rsaCheckV2(array $params)
    {
        return $this->aop->rsaCheckV2($params, $this->publicKeyFile, $this->aop->signType);
    }

    /**
     * RSA2加密验签
     *
     * @author woodlsy
     * @param array $params
     * @return bool
     */
    public function rsaCheckV1(array $params)
    {
        return $this->aop->rsaCheckV1($params, $this->publicKeyFile, $this->aop->signType);
    }
}
