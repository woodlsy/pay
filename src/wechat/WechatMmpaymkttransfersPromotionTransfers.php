<?php
declare(strict_types = 1);

namespace woodlsy\pay\wechat;

use woodlsy\pay\wechat\request\MmpaymkttransfersPromotionTransfers;

class WechatMmpaymkttransfersPromotionTransfers extends Config
{
    protected $gatewayUrl = 'https://api.mch.weixin.qq.com/'; // 网关地址

    public function __construct(array $config = null)
    {
        parent::__construct($config);

        $this->obj = new MmpaymkttransfersPromotionTransfers();

        if (null !== $this->config) {
            if (isset($this->config['app_id']))
                $this->setAppId($this->config['app_id']);
            if (isset($this->config['mch_id']))
                $this->setMchId($this->config['mch_id']);
        }
    }

    /**
     * 商户订单号
     *
     * @author woodlsy
     * @param string $partnerTradeNo
     * @return $this
     */
    public function setPartnerTradeNo(string $partnerTradeNo) : WechatMmpaymkttransfersPromotionTransfers
    {
        $this->obj->partnerTradeNo = $partnerTradeNo;
        return $this;
    }

    /**
     * 设置openId
     *
     * @author yls
     * @param string $openId
     * @return $this
     */
    public function setOpenId(string $openId) : WechatMmpaymkttransfersPromotionTransfers
    {
        $this->obj->openId = $openId;
        return $this;
    }

    /**
     * 设置金额
     *
     * @author yls
     * @param int $amount
     * @return $this
     */
    public function setAmount(int $amount) : WechatMmpaymkttransfersPromotionTransfers
    {
        $this->obj->amount = $amount;
        return $this;
    }

    /**
     * 设置企业付款备注
     *
     * @author yls
     * @param string $desc
     * @return $this
     */
    public function setDesc(string $desc) : WechatMmpaymkttransfersPromotionTransfers
    {
        $this->obj->desc = $desc;
        return $this;
    }

    /**
     * 设置收款用户姓名
     *
     * @author yls
     * @param string $rUserName
     * @return $this
     */
    public function setRUserName(string $rUserName) : WechatMmpaymkttransfersPromotionTransfers
    {
        $this->obj->rUserName = $rUserName;
        return $this;
    }
}