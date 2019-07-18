# pay
微信支付、支付宝支付、连连支付

### 一、alipay
- App 发起支付
```php
$alipayConfig = [
    'appId' => '2016615151551515',
    'privateKeyFilePath' => '/config/rsa/alipay/rsa_private_key.pem', // 私钥地址
    'alipayPublicKey' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAuo2LF+uJ7D+3Qb6PwFU2....' // 阿里公钥
];
$alipay = (new Alipay($alipayConfig));
$alipay->setAmount('0.01');
$alipay->setSubject('商品订单');
$alipay->setOrderSn('DD'.time());
$alipay->setBackParams(['orderTyoe'=>1,'orderId'=>'111111']);
// 返回的$string给app sdk发起支付
$string = $alipay->appPay();
```