<?php
declare(strict_types = 1);

namespace woodlsy\pay\wechat\request;

/**
 * 完结分账
 *
 * @author yls
 * @package woodlsy\pay\wechat\request
 */
class Profitsharingfinish
{
    public $appId = ''; // 应用ID

    public $mchId = ''; // 商户号

    public $signType = 'HMAC-SHA256'; // 签名类型

    public $nonceStr = ''; // 随机字符串

    public $outOrderNo = ''; // 商户分账单号

    public $subMchId = ''; // 子商户号

    public $transactionId = ''; // 微信订单号

    public $description = ''; // 分账完结的原因描述

    public function getApiMethodName() : string
    {
        return "profitsharingfinish";
    }

    public function getParams() : array
    {
        $this->nonceStr();

        $data = [
            'appid'          => $this->appId,
            'mch_id'         => $this->mchId,
            'nonce_str'      => $this->nonceStr,
            'sign_type'      => $this->signType,
            'transaction_id' => $this->transactionId,
            'out_order_no'   => $this->outOrderNo,
            'description'    => $this->description,
        ];
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