<?php
declare(strict_types = 1);

namespace woodlsy\pay\wechat;

use woodlsy\pay\wechat\request\Profitsharingaddreceiver;

class WechatProfitSharingAddReceiver extends Config
{
    public function __construct(array $config = null)
    {
        parent::__construct($config);

        $this->obj = new Profitsharingaddreceiver();

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
    public function setTransactionId(string $transactionId):WechatProfitSharingAddReceiver
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
    public function setOutOrderNo(string $outOrderNo) : WechatProfitSharingAddReceiver
    {
        $this->obj->outOrderNo = $outOrderNo;
        return $this;
    }

    /**
     * 设置分账接收方列表
     * [
     *  [
     *      "type" => "MERCHANT_ID",
     *      "account" => "190001001",
     *      "amount" => 100,
     *      "name" => "蚂蚁探路"
     *      "relation_type" => "SERVICE_PROVIDER",
     *  ],
     *  [
     *      "type" => "PERSONAL_OPENID",
     *      "account" => "86693952",
     *      "amount" => 100,
     *      "relation_type" => "USER",
     *  ]
     * ]
     *
     *
     * @author yls
     * @param array $receivers
     * @return $this
     */
    public function setReceivers(array $receivers) : WechatProfitSharingAddReceiver
    {
        $this->obj->receivers[] = $receivers;
        return $this;
    }
}