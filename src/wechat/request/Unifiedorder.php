<?php
namespace woodlsy\pay\wechat\request;

/**
 * 统一下单
 *
 * @author woodlsy
 * @package woodlsy\pay\wechat\request
 */
class Unifiedorder
{
    public $appId = ''; // 应用ID

    public $mchId = ''; // 商户号

    public $signType = 'HMAC-SHA256'; // 签名类型

    public $body = '商品描述';

    public $attach = null; // 附加数据

    public $outTradeNo = null; // 商户订单号

    public $spbillCreateIp = null; // 调用微信支付API的机器IP

    public $notifyUrl = null; // 通知地址

    public $tradeType = 'APP'; // 支付类型

    public $totalFee = 1; // 订单总金额,单位为分

    public $nonceStr = ''; // 随机字符串

    public $openId = null;

    public function getApiMethodName() : string
    {
        return "unifiedorder";
    }

    public function getParams() : array
    {
        $this->nonceStr();

        return [
            'appid' => $this->appId,
            'mch_id' => $this->mchId,
            'nonce_str' => $this->nonceStr,
            'sign_type' => $this->signType,
            'body' => $this->body,
            'attach' => $this->attach,
            'out_trade_no' => $this->outTradeNo,
            'total_fee' => $this->totalFee,
            'spbill_create_ip' => $_SERVER['SERVER_ADDR'],
            'notify_url' => $this->notifyUrl,
            'trade_type' => $this->tradeType,
            'openid' => $this->openId,
        ];
    }

    private function nonceStr()
    {
        $this->nonceStr = uniqid('', true);
    }

}