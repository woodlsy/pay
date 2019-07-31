<?php
namespace woodlsy\pay\wechat\request;

/**
 * 拉起支付
 *
 * @author woodlsy
 * @package woodlsy\pay\wechat\request
 */
class PullPay
{

    public $appId = ''; // 应用ID

    public $mchId = ''; // 商户号

    public $signType = 'HMAC-SHA256'; // 签名类型

    public function getParams(string $prepayid, string $type = 'app') : array
    {
        if ('JSAPI' === $type) {
            $params = [
                'appId' => $this->appId,
                'nonceStr' => (string) uniqid('', true),
                'timeStamp' => (string) time(),
                'package' => 'prepay_id='.$prepayid,
                'signType' => $this->signType,
            ];
        } else {
            $params = [
                'appid' => $this->appId,
                'partnerid' => $this->mchId,
                'prepayid' => $prepayid,
                'package' => 'Sign=WXPay',
                'noncestr' => (string) uniqid('', true),
                'timestamp' => (string) time(),
            ];
        }
        return $params;
    }

}