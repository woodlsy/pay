<?php

namespace woodlsy\pay\alipay;


use Exception;
use woodlsy\pay\alipay\request\AlipayTradeRefundRequest;

class AliRefund extends Config
{
    private $bizContent = [];

    /**
     * 设置退款金额
     *
     * @author woodlsy
     * @param string $amount
     * @return AliRefund
     */
    public function setAmount(string $amount) : AliRefund
    {
        $this->bizContent['refund_amount'] = $amount;
        return $this;
    }

    /**
     * 设置支付宝交易号
     *
     * @author woodlsy
     * @param string $tradeNo
     * @return AliRefund
     */
    public function setTradeNo(string $tradeNo) : AliRefund
    {
        $this->bizContent['trade_no'] = $tradeNo;
        return $this;
    }

    /**
     * 设置商家订单号
     *
     * @author woodlsy
     * @param string $outTradeNo
     * @return AliRefund
     */
    public function setOutTradeNo(string $outTradeNo) : AliRefund
    {
        $this->bizContent['out_trade_no'] = $outTradeNo;
        return $this;
    }

    /**
     * 设置退款请求流水号
     *
     * @author woodlsy
     * @param string $outRequestNo
     * @return AliRefund
     */
    public function setOutRequestNo(string $outRequestNo) : AliRefund
    {
        $this->bizContent['out_request_no'] = $outRequestNo;
        return $this;
    }

    /**
     * 退款
     *
     * @author woodlsy
     * @return bool|mixed|\SimpleXMLElement
     * @throws Exception
     */
    public function refund()
    {
        $request = new AlipayTradeRefundRequest();
        $request->setBizContent(json_encode($this->bizContent, JSON_UNESCAPED_UNICODE));
        $result = $this->aop->execute($request);
        return $result;
    }
}