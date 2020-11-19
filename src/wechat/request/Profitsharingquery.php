<?php
declare(strict_types = 1);

namespace woodlsy\pay\wechat\request;

/**
 * 查询分账结果
 *
 * @author yls
 * @package woodlsy\pay\wechat\request
 */
class Profitsharingquery
{
    public $mchId = ''; // 商户号

    public $signType = 'HMAC-SHA256'; // 签名类型

    public $nonceStr = ''; // 随机字符串

    public $outOrderNo = ''; // 商户分账单号

    public $subMchId = ''; // 子商户号

    public $transactionId = ''; // 微信订单号

    public function getApiMethodName() : string
    {
        return "profitsharingquery";
    }

    public function getParams() : array
    {
        $this->nonceStr();

        $data = [
            'mch_id'         => $this->mchId,
            'nonce_str'      => $this->nonceStr,
            'sign_type'      => $this->signType,
            'transaction_id' => $this->transactionId,
            'out_order_no'   => $this->outOrderNo,
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