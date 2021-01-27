<?php

namespace woodlsy\pay\wechat;

use woodlsy\pay\wechat\request\RefundQuery;

class WechatRefundQuery extends Config
{

    public function __construct(array $config = null)
    {
        parent::__construct($config);
        $this->obj = new RefundQuery();

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
    public function setOutRefundNo(string $outRefundNo) : WechatRefundQuery
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
    public function setOutTradeNo(string $outTradeNo) : WechatRefundQuery
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
    public function setTransactionId(string $transactionId) : WechatRefundQuery
    {
        $this->obj->transactionId = $transactionId;
        return $this;
    }

    /**
     * 设置微信退款单号
     *
     * @author yls
     * @param string $refundId
     * @return $this
     */
    public function setRefundId(string $refundId) : WechatRefundQuery
    {
        $this->obj->refundId = $refundId;
        return $this;
    }

    /**
     * 设置偏移量
     *
     * @author woodlsy
     * @param int $offset
     * @return $this
     */
    public function setOffset(int $offset) : WechatRefundQuery
    {
        $this->obj->offset = $offset;
        return $this;
    }

    /**
     * 设置子商户号 （服务商模式）
     *
     * @author yls
     * @param string $subMchId
     * @return $this
     */
    public function setSubMchId(string $subMchId) : WechatRefundQuery
    {
        $this->obj->subMchId = $subMchId;
        return $this;
    }


}