<?php
namespace woodlsy\pay\wechat;

use woodlsy\httpClient\HttpCurl;
use woodlsy\pay\wechat\request\PullPay;
use woodlsy\pay\wechat\request\Unifiedorder;

class Wechatpay
{
    private $gatewayUrl = 'https://api.mch.weixin.qq.com/pay/'; // 网关地址

    private $appKey = null; // 商户平台密钥key

    private $obj = null;

    private $config;

    public function __construct(array $config = null)
    {
        $this->config = $config;
    }

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
            if (isset($this->config['key'])) $this->setAppKey($this->config['key']);
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

        $params = $obj->getParams($prepayid);
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
     * 获取加密前字符串
     *
     * @author woodlsy
     * @param array $params
     * @return string
     */
    public function getSignContent(array $params) : string
    {
        ksort($params);
        $arr = [];
        foreach ($params as $key => $value) {
            if (empty($value)) continue;
            $arr[] = $key.'='.$value;
        }
        $arr[] = 'key='.$this->appKey;
        return implode('&', $arr);
    }

    /**
     * 加密
     *
     * @author woodlsy
     * @param string $data
     * @param string $signType
     * @return string
     */
    public function sign(string $data, string $signType)
    {
        switch ($signType) {
            case 'HMAC-SHA256':
                return hash_hmac('sha256', $data, $this->appKey);
                break;
            case 'MD5':
                return md5($data);
                break;
            default:
                return '';
                break;
        }
    }

    /**
     * 设置应用ID
     *
     * @author woodlsy
     * @param string $appId
     * @return Wechatpay
     */
    public function setAppId(string $appId) : Wechatpay
    {
        $this->obj->appId = $appId;
        return $this;
    }

    /**
     * 设置商户号
     *
     * @author woodlsy
     * @param string $mchId
     * @return Wechatpay
     */
    public function setMchId(string $mchId) : Wechatpay
    {
        $this->obj->mchId = $mchId;
        return $this;
    }

    /**
     * 设置签名类型
     *
     * @author woodlsy
     * @param string $signType
     * @return Wechatpay
     */
    public function setSignType(string $signType) : Wechatpay
    {
        $this->obj->signType = $signType;
        return $this;
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
        $this->obj->body = $amount;
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
     * 设置key
     *
     * @author woodlsy
     * @param string $key
     * @return Wechatpay
     */
    public function setAppKey(string $key) : Wechatpay
    {
        $this->appKey = $key;
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
     * 参数转为xml
     *
     * @author woodlsy
     * @param array $params
     * @return string
     */
    public function toXml(array $params) : string
    {
        $xml = "<xml>";
        foreach ($params as $key=>$val)
        {
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }

    public function fromXml(string $xml)
    {
        //将XML转为array
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $values;
    }
}