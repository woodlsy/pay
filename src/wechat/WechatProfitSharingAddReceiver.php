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
     * 设置子商户号 （服务商模式）
     *
     * @author yls
     * @param string $subMchId
     * @return $this
     */
    public function setSubMchId(string $subMchId) : WechatProfitSharingAddReceiver
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
    public function setSubAppId(string $subAppId) : WechatProfitSharingAddReceiver
    {
        $this->obj->subAppId = $subAppId;
        return $this;
    }

    /**
     * 设置分账接收方列表
     *  [
     *      "type" => "MERCHANT_ID",
     *      "account" => "190001001",
     *      "name" => "蚂蚁探路"
     *      "relation_type" => "SERVICE_PROVIDER",
     *      "custom_relation" => "子商户与接收方具体的关系"
     *  ]
     *  [
     *      "type" => "PERSONAL_OPENID",
     *      "amount" => 100,
     *      "relation_type" => "USER",
     *  ]
     *
     *
     * @author yls
     * @param array $receiver
     * @return $this
     */
    public function setReceiver(array $receiver) : WechatProfitSharingAddReceiver
    {
        $this->obj->receiver = $receiver;
        return $this;
    }
}