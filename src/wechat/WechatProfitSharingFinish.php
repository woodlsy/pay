<?php
declare(strict_types = 1);

namespace woodlsy\pay\wechat;

use woodlsy\pay\wechat\request\Profitsharingfinish;

class WechatProfitSharingFinish extends Config
{
    public function __construct(array $config = null)
    {
        parent::__construct($config);

        $this->obj = new Profitsharingfinish();

        if (null !== $this->config) {
            if (isset($this->config['app_id'])) $this->setAppId($this->config['app_id']);
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
    public function setTransactionId(string $transactionId):WechatProfitSharingFinish
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
    public function setOutOrderNo(string $outOrderNo) : WechatProfitSharingFinish
    {
        $this->obj->outOrderNo = $outOrderNo;
        return $this;
    }

    /**
     * 分账完结的原因描述
     *
     * @author yls
     * @param array $description
     * @return $this
     */
    public function setDescription(array $description) : WechatProfitSharingFinish
    {
        $this->obj->description = $description;
        return $this;
    }

    /**
     * 设置子商户号 （服务商模式）
     *
     * @author yls
     * @param string $subMchId
     * @return $this
     */
    public function setSubMchId(string $subMchId) : WechatProfitSharingFinish
    {
        $this->obj->subMchId = $subMchId;
        return $this;
    }
}