<?php
declare(strict_types = 1);

namespace woodlsy\pay\wechat;

use woodlsy\pay\wechat\request\Multiprofitsharing;
use woodlsy\pay\wechat\request\Profitsharing;

class WechatProfitSharing extends Config
{

    /**
     * 单次分账
     *
     * @author yls
     * @return $this
     */
    public function goProfitSharing() :WechatProfitSharing
    {
        $this->obj = new Profitsharing();

        if (null !== $this->config) {
            if (isset($this->config['app_id'])) $this->setAppId($this->config['app_id']);
            if (isset($this->config['mch_id'])) $this->setMchId($this->config['mch_id']);
        }
        return $this;
    }

    /**
     * 多次分账
     *
     * @author yls
     * @return $this
     */
    public function goMultiProfitSharing() :WechatProfitSharing
    {
        $this->obj = new Multiprofitsharing();

        if (null !== $this->config) {
            if (isset($this->config['app_id'])) $this->setAppId($this->config['app_id']);
            if (isset($this->config['mch_id'])) $this->setMchId($this->config['mch_id']);
        }
        return $this;
    }

    /**
     * 设置微信订单号
     *
     * @author woodlsy
     * @param string $transactionId
     * @return $this
     */
    public function setTransactionId(string $transactionId):WechatProfitSharing
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
    public function setOutOrderNo(string $outOrderNo) : WechatProfitSharing
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
     *      "description" => "分到商户",
     *  ],
     *  [
     *      "type" => "PERSONAL_OPENID",
     *      "account" => "86693952",
     *      "amount" => 100,
     *      "description" => "分到个人",
     *  ]
     * ]
     *
     *
     * @author yls
     * @param array $receivers
     * @return $this
     */
    public function setReceivers(array $receivers) : WechatProfitSharing
    {
        $this->obj->receivers[] = $receivers;
        return $this;
    }

    /**
     * 设置子商户号 （服务商模式）
     *
     * @author yls
     * @param string $subMchId
     * @return $this
     */
    public function setSubMchId(string $subMchId) : WechatProfitSharing
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
    public function setSubAppId(string $subAppId) : WechatProfitSharing
    {
        $this->obj->subAppId = $subAppId;
        return $this;
    }
}