<?php
declare(strict_types = 1);

namespace woodlsy\pay\wechat\request;

/**
 * Class MmpaymkttransfersGettransferinfo
 * 用于商户的企业付款操作进行结果查询，返回付款操作详细结果
 * 查询企业付款API只支持查询30天内的订单，30天之前的订单请登录商户平台查询。
 *
 * @author yls
 * @package woodlsy\pay\wechat\request
 */
class MmpaymkttransfersGettransferinfo
{
    public $appId = ''; // 应用ID

    public $mchId = ''; // 商户号

    public $signType = 'MD5'; // 签名类型

    public $nonceStr = ''; // 随机字符串

    public $partnerTradeNo = ''; // 商户订单号

    public function getApiMethodName() : string
    {
        return "mmpaymkttransfers/gettransferinfo";
    }

    public function getParams() : array
    {
        $this->nonceStr();

        return [
            'appid'        => $this->appId,
            'mch_id'            => $this->mchId,
            'nonce_str'        => $this->nonceStr,
            'sign_type'        => $this->signType,
            'partner_trade_no' => $this->partnerTradeNo,
        ];
    }

    private function nonceStr()
    {
        $this->nonceStr = uniqid('', true);
    }
}