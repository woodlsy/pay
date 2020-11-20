<?php
declare(strict_types = 1);

namespace woodlsy\pay\wechat\request;

/**
 * 添加分账接收方
 *
 * @author yls
 * @package woodlsy\pay\wechat\request
 */
class Profitsharingaddreceiver
{
    public $appId = ''; // 应用ID

    public $mchId = ''; // 商户号

    public $signType = 'HMAC-SHA256'; // 签名类型

    public $nonceStr = ''; // 随机字符串

    public $subMchId = ''; // 子商户号

    public $subAppId = ''; // 子商户AppId

    /**
     * type 必填  MERCHANT_ID：商户号（mch_id或者sub_mch_id）
     *        PERSONAL_OPENID：个人openid（由父商户APPID转换得到）PERSONAL_SUB_OPENID: 个人sub_openid（由子商户APPID转换得到）
     * account 必填  类型是MERCHANT_ID时，是商户号（mch_id或者sub_mch_id）
     *          类型是PERSONAL_OPENID时，是个人openid
     *          类型是PERSONAL_SUB_OPENID时，是个人sub_openid
     * name 不必填   分账接收方类型是MERCHANT_ID时，是商户全称（必传）
     *        分账接收方类型是PERSONAL_OPENID时，是个人姓名（选传，传则校验）
     *        分账接收方类型是PERSONAL_SUB_OPENID时，是个人姓名（选传，传则校验）
     * relation_type 必填 子商户与接收方的关系。
     *               本字段值为枚举：
     *                SERVICE_PROVIDER：服务商
     *                STORE：门店
     *                STAFF：员工
     *                STORE_OWNER：店主
     *                PARTNER：合作伙伴
     *                HEADQUARTER：总部
     *                BRAND：品牌方
     *                DISTRIBUTOR：分销商
     *                USER：用户
     *                SUPPLIER：供应商
     *                CUSTOM：自定义
     *
     * custom_relation 不必填   子商户与接收方具体的关系，本字段最多10个字。
     *                   当字段relation_type的值为CUSTOM时，本字段必填
     *                  当字段relation_type的值不为CUSTOM时，本字段无需填写
     *
     * @var array
     */
    public $receiver = []; // 分账接收方

    public function getApiMethodName() : string
    {
        return "profitsharingaddreceiver";
    }

    public function getParams() : array
    {
        $this->nonceStr();

        $data = [
            'appid'          => $this->appId,
            'mch_id'         => $this->mchId,
            'nonce_str'      => $this->nonceStr,
            'sign_type'      => $this->signType,
            'receiver'      => json_encode($this->receiver),
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