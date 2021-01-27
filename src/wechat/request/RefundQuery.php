<?php

namespace woodlsy\pay\wechat\request;

/**
 * 查询退款
 *
 * @author yls
 * @package woodlsy\pay\wechat\request
 */
class RefundQuery
{
    public $appId = ''; // 应用ID

    public $mchId = ''; // 商户号

    public $signType = 'HMAC-SHA256'; // 签名类型

    public $nonceStr = ''; // 随机字符串

    public $outRefundNo = ''; // 商户退款单号

    public $outTradeNo = ''; // 商户订单号

    public $refundId = ''; // 微信退款单号

    public $offset = 0; // 偏移量

    public $subMchId = ''; // 子商户号

    public $transactionId = ''; // 微信订单号

    public function getApiMethodName() : string
    {
        return "/pay/refundquery";
    }

    public function getParams() : array
    {
        $this->nonceStr();

        $data = [
            'appid'          => $this->appId,
            'mch_id'         => $this->mchId,
            'nonce_str'      => $this->nonceStr,
            'sign_type'      => $this->signType,
        ];
        if (!empty($this->outTradeNo)) {
            $data['out_trade_no'] = $this->outTradeNo;
        }
        if (!empty($this->outRefundNo)) {
            $data['out_refund_no'] = $this->outRefundNo;
        }
        if (!empty($this->transactionId)) {
            $data['transaction_id'] = $this->transactionId;
        }
        if (!empty($this->refundId)) {
            $data['refund_id'] = $this->refundId;
        }
        if (!empty($this->offset)) {
            $data['offset'] = $this->offset;
        }
        if (!empty($this->subMchId)) {
            $data['sub_mch_id'] = $this->subMchId;
        }
        return $data;
    }

    private function nonceStr()
    {
        $this->nonceStr = uniqid('', true);
    }
}