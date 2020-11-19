<?php

namespace woodlsy\pay\wechat;

use woodlsy\pay\wechat\request\Refund;

class WechatRefund extends Config
{

    public function __construct(array $config = null)
    {
        parent::__construct($config);
        $this->obj = new Refund();

        if (null !== $this->config) {
            if (isset($this->config['app_id']))
                $this->setAppId($this->config['app_id']);
            if (isset($this->config['mch_id']))
                $this->setMchId($this->config['mch_id']);
        }
    }

    /**
     * 设置退款单号
     *
     * @author woodlsy
     * @param string $outRefundNo
     * @return $this
     */
    public function setOutRefundNo(string $outRefundNo) : WechatRefund
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
    public function setOutTradeNo(string $outTradeNo) : WechatRefund
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
    public function setTransactionId(string $transactionId) : WechatRefund
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
    public function setTotalFee(int $totalFee) : WechatRefund
    {
        $this->obj->totalFee = $totalFee;
        return $this;
    }

    /**
     * 设置子商户号 （服务商模式）
     *
     * @author yls
     * @param string $subMchId
     * @return $this
     */
    public function setSubMchId(string $subMchId) : WechatRefund
    {
        $this->obj->subMchId = $subMchId;
        return $this;
    }

    /**
     * 设置子商户app id （服务商模式）
     *
     * @author yls
     * @param string $subAppId
     * @return $this
     */
    public function setSubAppId(string $subAppId) : WechatRefund
    {
        $this->obj->subAppId = $subAppId;
        return $this;
    }

    /**
     * 设置退款金额
     *
     * @author woodlsy
     * @param int $refundFee
     * @return $this
     */
    public function setRefundFee(int $refundFee) : WechatRefund
    {
        $this->obj->refundFee = $refundFee;
        return $this;
    }


}