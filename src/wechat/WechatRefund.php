<?php
namespace woodlsy\pay\wechat;

use woodlsy\httpClient\HttpCurl;
use woodlsy\pay\wechat\request\Refund;

class WechatRefund extends Config
{
    protected $gatewayUrl = 'https://api.mch.weixin.qq.com/secapi/pay/'; // 网关地址

    public function goRefund()
    {
        $this->obj = new Refund();

        if (null !== $this->config) {
            if (isset($this->config['app_id'])) $this->setAppId($this->config['app_id']);
            if (isset($this->config['mch_id'])) $this->setMchId($this->config['mch_id']);
        }
    }

    /**
     * 设置退款单号
     *
     * @author woodlsy
     * @param string $outRefundNo
     * @return $this
     */
    public function setOutRefundNo(string $outRefundNo)
    {
        $this->obj->outRefundNo = $outRefundNo;
        return $this;
    }

    /**
     * 设置商户单号
     *
     * @author woodlsy
     * @param string $outTradeNo
     * @return $this
     */
    public function setOutTradeNo(string $outTradeNo)
    {
        $this->obj->outTradeNo = $outTradeNo;
        return $this;
    }

    /**
     * 设置微信订单号
     *
     * @author woodlsy
     * @param string $transactionId
     * @return $this
     */
    public function setTransactionId(string $transactionId)
    {
        $this->obj->transactionId = $transactionId;
        return $this;
    }

    /**
     * 设置订单总金额
     *
     * @author woodlsy
     * @param int $totalFee
     * @return $this
     */
    public function setTotalFee(int $totalFee)
    {
        $this->obj->totalFee = $totalFee;
        return $this;
    }

    /**
     * 设置退款金额
     *
     * @author woodlsy
     * @param int $refundFee
     * @return $this
     */
    public function setRefundFee(int $refundFee)
    {
        $this->obj->refundFee = $refundFee;
        return $this;
    }

    public function execute()
    {
        $params = $this->obj->getParams();
        $params['sign'] = $this->sign($this->getSignContent($params), $params['sign_type']);
        $url = $this->gatewayUrl.$this->obj->getApiMethodName();
        $res = (new HttpCurl())->setUrl($url)->setData($this->toXml($params))->setSSLCert($this->sslCert, $this->sslKey)->post();
        $result = $this->fromXml($res);
        return $result;
    }
}