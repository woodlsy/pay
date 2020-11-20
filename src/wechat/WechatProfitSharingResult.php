<?php
declare(strict_types = 1);

namespace woodlsy\pay\wechat;

use woodlsy\pay\wechat\request\Multiprofitsharing;
use woodlsy\pay\wechat\request\Profitsharing;
use woodlsy\pay\wechat\request\Profitsharingquery;

class WechatProfitSharingResult extends Config
{

    public function __construct(array $config = null)
    {
        parent::__construct($config);

        $this->obj = new Profitsharingquery();

        if (null !== $this->config) {
            if (isset($this->config['mch_id'])) $this->setMchId($this->config['mch_id']);
        }
    }

    /**
     * 设置微信订单号
     *
     * @author woodlsy
     * @param string $transactionId
     * @return $this
     */
    public function setTransactionId(string $transactionId):WechatProfitSharingResult
    {
        $this->obj->transactionId = $transactionId;
        return $this;
    }

    /**
     * 设置分账单号
     *
     * @author woodlsy
     * @param string $outOrderNo
     * @return $this
     */
    public function setOutOrderNo(string $outOrderNo) : WechatProfitSharingResult
    {
        $this->obj->outOrderNo = $outOrderNo;
        return $this;
    }

    /**
     * 设置子商户号 （服务商模式）
     *
     * @author yls
     * @param string $subMchId
     * @return $this
     */
    public function setSubMchId(string $subMchId) : WechatProfitSharingResult
    {
        $this->obj->subMchId = $subMchId;
        return $this;
    }
}