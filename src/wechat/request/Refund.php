<?php

namespace woodlsy\pay\wechat\request;

class Refund
{
    public $appId = ''; // 应用ID

    public $mchId = ''; // 商户号

    public $signType = 'HMAC-SHA256'; // 签名类型

    public $nonceStr = ''; // 随机字符串

    public $outRefundNo = ''; // 商户退款单号

    public $outTradeNo = ''; // 商户订单号

    public $totalFee = 0; // 原订单总金额

    public $refundFee = 0; // 退款金额

    public $transactionId = ''; // 微信订单号

    public function getApiMethodName() : string
    {
        return "refund";
    }

    public function getParams() : array
    {
        $this->nonceStr();

        return [
            'appid'          => $this->appId,
            'mch_id'         => $this->mchId,
            'nonce_str'      => $this->nonceStr,
            'sign_type'      => $this->signType,
            'out_trade_no'   => $this->outTradeNo,
            'out_refund_no'  => $this->outRefundNo,
            'transaction_id' => $this->transactionId,
            'total_fee'      => $this->totalFee,
            'refund_fee'     => $this->refundFee,
        ];
    }

    private function nonceStr()
    {
        $this->nonceStr = uniqid('', true);
    }
}