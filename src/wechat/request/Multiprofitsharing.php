<?php
declare(strict_types = 1);

namespace woodlsy\pay\wechat\request;

/**
 * 单次分账
 *
 * @author yls
 * @package woodlsy\pay\wechat\request
 */
class Multiprofitsharing
{
    public $appId = ''; // 应用ID

    public $mchId = ''; // 商户号

    public $signType = 'HMAC-SHA256'; // 签名类型

    public $nonceStr = ''; // 随机字符串

    public $outOrderNo = ''; // 商户分账单号

    public $subMchId = ''; // 子商户号

    public $subAppId = ''; // 子商户AppId

    public $transactionId = ''; // 微信订单号

    public $receivers = []; // 分账接收方列表  {"type": "PERSONAL_OPENID","account":"86693952","amount":888,"description": "分到个人"}

    public function getApiMethodName() : string
    {
        return "multiprofitsharing";
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
            'receivers'      => json_encode($this->receivers),
        ];
        if (!empty($this->subMchId)) {
            $data['sub_mch_id'] = $this->subMchId;
        }
        if (!empty($this->subAppId)) {
            $data['sub_appid'] = $this->subAppId;
        }
        return $data;
    }

    private function nonceStr()
    {
        $this->nonceStr = uniqid('', true);
    }
}