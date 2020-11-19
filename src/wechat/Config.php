<?php
namespace woodlsy\pay\wechat;

use woodlsy\httpClient\HttpCurl;

class Config
{

    protected $config;

    public $obj = null;

    protected $signType = 'HMAC-SHA256';

    protected $appKey = null; // 商户平台密钥key

    protected $sslCert = ''; // 证书路径

    protected $sslKey = ''; // 秘钥路径

    protected $gatewayUrl = 'https://api.mch.weixin.qq.com/secapi/pay/'; // 网关地址

    public function __construct(array $config = null)
    {
        $this->config = $config;
        if (null !== $this->config) {
            if (isset($this->config['key'])) $this->setAppKey($this->config['key']);
            if (isset($this->config['sign_type'])) $this->setSignType($this->config['sign_type']);

            if (isset($this->config['SSLCert']) && !empty($this->config['SSLCert'])) {
                $this->sslCert = $this->config['SSLCert'];
            }

            if (isset($this->config['SSLKey']) && !empty($this->config['SSLKey'])) {
                $this->sslKey = $this->config['SSLKey'];
            }
        }
    }

    /**
     * 设置key
     *
     * @author woodlsy
     * @param string $key
     * @return $this
     */
    public function setAppKey(string $key)
    {
        $this->appKey = $key;
        return $this;
    }

    /**
     * 设置签名类型
     *
     * @author woodlsy
     * @param string $signType
     * @return $this
     */
    public function setSignType(string $signType)
    {
        $this->obj->signType = $signType;
        $this->signType = $signType;
        return $this;
    }

    /**
     * 设置应用ID
     *
     * @author woodlsy
     * @param string $appId
     * @return $this
     */
    public function setAppId(string $appId)
    {
        $this->obj->appId = $appId;
        return $this;
    }

    /**
     * 设置商户号
     *
     * @author woodlsy
     * @param string $mchId
     * @return $this
     */
    public function setMchId(string $mchId)
    {
        $this->obj->mchId = $mchId;
        return $this;
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

    /**
     * xml转换为数组
     *
     * @author yls
     * @param string $xml
     * @return mixed
     */
    public function fromXml(string $xml)
    {
        //将XML转为array
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $values;
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

    public function execute()
    {
        $params         = $this->obj->getParams();
        $params['sign'] = $this->sign($this->getSignContent($params), $params['sign_type']);
        $url            = $this->gatewayUrl . $this->obj->getApiMethodName();
        $res            = (new HttpCurl())->setUrl($url)->setData($this->toXml($params))->setSSLCert($this->sslCert, $this->sslKey)->post();
        return          $this->fromXml($res);
    }

}