<?php
namespace woodlsy\pay\wechat;

use woodlsy\httpClient\HttpCurl;
use woodlsy\pay\wechat\request\PullPay;
use woodlsy\pay\wechat\request\Unifiedorder;

class Wechatpay extends Config
{
    protected $gatewayUrl = 'https://api.mch.weixin.qq.com/pay/'; // 网关地址

    /**
     * 统一下单
     *
     * @author woodlsy
     */
    public function goUnifiedorder()
    {
        $this->obj = new Unifiedorder();

        if (null !== $this->config) {
            if (isset($this->config['app_id'])) $this->setAppId($this->config['app_id']);
            if (isset($this->config['mch_id'])) $this->setMchId($this->config['mch_id']);
            if (isset($this->config['notify_url'])) $this->setNotifyUrl($this->config['notify_url']);
        }
    }

    /**
     * 拉起支付
     *
     * @author woodlsy
     * @param string $prepayid
     * @return array
     */
    public function goPullPay(string $prepayid)
    {
        $obj = new PullPay();
        if (isset($this->obj->appId)) {
            $obj->appId = $this->obj->appId;
        }
        if (isset($this->obj->mchId)) {
            $obj->mchId = $this->obj->mchId;
        }

        $params = $obj->getParams($prepayid, $this->obj->tradeType);
        $params['sign'] = $this->sign($this->getSignContent($params), $this->obj->signType);
        return $params;
    }

    public function appPay()
    {
        $params = $this->obj->getParams();
        $params['sign'] = $this->sign($this->getSignContent($params), $params['sign_type']);
        $url = $this->gatewayUrl.$this->obj->getApiMethodName();
        $res = (new HttpCurl())->setUrl($url)->setData($this->toXml($params))->post();
        $result = $this->fromXml($res);
        return $result;
    }

    /**
     * 设置商品描述
     *
     * @author woodlsy
     * @param string $subject
     * @return Wechatpay
     */
    public function setSubject(string $subject) : Wechatpay
    {
        $this->obj->body = $subject;
        return $this;
    }

    /**
     * 支付金额，单位为分
     *
     * @author woodlsy
     * @param int $amount
     * @return Wechatpay
     */
    public function setAmount(int $amount) : Wechatpay
    {
        $this->obj->totalFee = $amount;
        return $this;
    }

    /**
     * 附加数据，在查询API和支付通知中原样返回，
     * 该字段主要用于商户携带订单的自定义数据
     *
     * @author woodlsy
     * @param string $attach
     * @return Wechatpay
     */
    public function setAttach(string $attach) : Wechatpay
    {
        $this->obj->attach = $attach;
        return $this;
    }

    /**
     * 商户系统内部订单号
     *
     * @author woodlsy
     * @param string $orderSn
     * @return Wechatpay
     */
    public function setOutTradeNo(string $orderSn) : Wechatpay
    {
        $this->obj->outTradeNo = $orderSn;
        return $this;
    }

    /**
     * 异步通知回调地址
     *
     * @author woodlsy
     * @param string $notifyUrl
     * @return Wechatpay
     */
    public function setNotifyUrl(string $notifyUrl) : Wechatpay
    {
        $this->obj->notifyUrl = $notifyUrl;
        return $this;
    }

    /**
     * 设置openId
     *
     * @author woodlsy
     * @param string $openId
     * @return Wechatpay
     */
    public function setOpenId(string $openId) : Wechatpay
    {
        $this->obj->openId = $openId;
        return $this;
    }


    /**
     * 设置支付类型
     *
     * @author woodlsy
     * @param string $tradeType
     * @return Wechatpay
     */
    public function setTradeType(string $tradeType) : Wechatpay
    {
        $this->obj->tradeType = $tradeType;
        return $this;
    }

    /**
     * 验签
     *
     * @author yls
     * @param array $params
     * @return bool
     */
    public function verfiySign(array $params) : bool
    {
        $sign = $params['sign'];
        unset($params['sign']);
        $nsign = $this->sign($this->getSignContent($params), $this->signType);
        return strtolower($sign) === strtolower($nsign) ? true : false;
    }
}