<?php
declare(strict_types = 1);

namespace woodlsy\pay\wechat;

use woodlsy\pay\wechat\request\MmpaymkttransfersGettransferinfo;

class WhectMmpaymkttransfersGettransferinfo extends Config
{
    protected $gatewayUrl = 'https://api.mch.weixin.qq.com/'; // 网关地址

    public function __construct(array $config = null)
    {
        parent::__construct($config);

        $this->obj = new MmpaymkttransfersGettransferinfo();

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
    public function setPartnerTradeNo(string $partnerTradeNo) : WhectMmpaymkttransfersGettransferinfo
    {
        $this->obj->partnerTradeNo = $partnerTradeNo;
        return $this;
    }
}