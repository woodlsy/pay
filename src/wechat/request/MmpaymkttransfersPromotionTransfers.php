<?php
declare(strict_types = 1);

namespace woodlsy\pay\wechat\request;

/**
 * 用于企业向微信用户个人付款
 * 目前支持向指定微信用户的openid付款
 *
 * @author yls
 * @package woodlsy\pay\wechat\request
 */
class MmpaymkttransfersPromotionTransfers
{
    public $appId = ''; // 应用ID

    public $mchId = ''; // 商户号

    public $signType = 'MD5'; // 签名类型

    public $nonceStr = ''; // 随机字符串

    public $partnerTradeNo = ''; // 商户订单号

    public $openId = ''; // 用户openid

    public $amount = 0; // 金额

    public $desc = ''; // 企业付款备注

    public $rUserName = ''; // 收款用户姓名

    public function getApiMethodName() : string
    {
        return "mmpaymkttransfers/promotion/transfers";
    }

    public function getParams() : array
    {
        $this->nonceStr();

        $data = [
            'mch_appid'        => $this->appId,
            'mchid'            => $this->mchId,
            'nonce_str'        => $this->nonceStr,
            'sign_type'        => $this->signType,
            'partner_trade_no' => $this->partnerTradeNo,
            'openid'           => $this->openId,
            'amount'           => $this->amount,
            'desc'             => $this->desc,
        ];
        if (!empty($this->rUserName)) {
            $data['re_user_name'] = $this->rUserName;
            $data['check_name']   = 'FORCE_CHECK';
        } else {
            $data['check_name'] = 'NO_CHECK';
        }
        return $data;
    }

    private function nonceStr()
    {
        $this->nonceStr = uniqid('', true);
    }
}