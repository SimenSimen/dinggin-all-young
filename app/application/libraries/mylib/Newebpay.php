<?php

/**
 * 測試版藍新金流 API
 */
class Newebpay
{
    private $newebpayUrl;
    private $hashKey;
    private $hashIV;
    private $merchantID;

    public function __construct()
    {
        // API URL
        $this->newebpayUrl = 'https://ccore.newebpay.com/MPG/mpg_gateway';

        // 測試版HashKey
        $this->hashKey = 'h3dFqoVb8YBKhOPNWMzGRin4Etiaq0l3';

        // 測試版HashIV
        $this->hashIV = 'Ca4PdXKCjuhCKaPP';

        // 測試版商店代號
        $this->merchantID = 'MS16669321';
    }

    public function mpg(array $data, $form)
    {
        $tradeInfo = [
            'MerchantID' => $this->merchantID,
            'RespondType' => 'JSON',
            'TimeStamp' => strtotime('now'),
            'Version' => '1.4',
            'MerchantOrderNo' => $_SESSION['payment_info']['order_id'],
            'Amt' => $_SESSION['payment_info']['price_money'],
            'ItemDesc' => $_SESSION['payment_info']['prd_name']
        ];

        $tradeInfo = static::create_mpg_aes_encrypt($tradeInfo, $this->hashKey, $this->hashIV);
        $tradeSHA = 'HashKey='.$this->hashKey.'&'.$tradeInfo.'&HashIV='.$this->hashIV;
        $tradeSHA = strtoupper(hash('sha256', $tradeSHA));
        
        $rawData = [
            /** 商家代號 */
            'MerchantID' => $this->merchantID,
            /** 交易資料 AES 加密 */
            'TradeInfo' => $tradeInfo,
            /** 交易資料 SHA256 加密 */
            'TradeSha' => $tradeSHA,
            /** 串接程式版本 */
            'Version' => '1.5',
            /** 回傳格式 */
            'RespondType' => 'JSON',
            /** 時間戳記 */
            'TimeStamp' => strtotime('now'),
            /** 商店訂單編號 */
            'MerchantOrderNo' => $_SESSION['payment_info']['order_id'],
            /** 訂單金額 */
            'Amt' => $_SESSION['payment_info']['price_money'],
            /** 商品資訊 */
            'ItemDesc' => $_SESSION['payment_info']['prd_name'],
            /** 付款人電子信箱 */
            'Email' => $_SESSION['payment_info']['email'],
            /** 藍新金流會員 */
            'LoginType' => '0'
        ];
        
        $formResult = "<form id='" . $form . "' name='" . $form . "' method='post' action='" . $this->newebpayUrl . "'>";
        
        foreach ($rawData as $key => $value) {
            $formResult .= "<input type='hidden' name='" . $key . "' value='" . $value . "'><br>";
        }
        
        $formResult .= "</form>";
        $formResult .= "<script type='text/javascript'>";
        $formResult .= "document.getElementById('".$form."').submit();";
        $formResult .= "</script>";
        
        $result = [
            'data' => []
        ];

        $result['data']['formResult'] = $formResult;
        $result['data']['rawData'] = $rawData;
        return $result;
    }

    /**
     * AES 加密
     */
    public static function create_mpg_aes_encrypt(array $tradeInfo, $hashKey, $hashIV)
    {
        $queryString = !empty($tradeInfo) ? http_build_query($tradeInfo) : '';
        return trim(bin2hex(openssl_encrypt(static::addpadding($queryString), 'aes-256-cbc', $hashKey, OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING, $hashIV)));
    }

    /**
     * 協助 AES 加密
     */
    public static function addpadding($string, $blocksize = 32)
    {
        $len = strlen($string);
        $pad = $blocksize - ($len % $blocksize);
        $string .= str_repeat(chr($pad), $pad);
        return $string;
    }

    /**
     * AES 解密
     */
    public static function create_aes_decrypt(array $tradeInfo)
    {
        return static::strippadding(
            openssl_decrypt(hex2bin($tradeInfo), 'AES-256-CBC', $this->hashKey, OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING, $this->hashIV)
        );
   }

    /**
     * 協助 AES 解密
     */
    public static function strippadding($string)
    {
        $slast = ord(substr($string, -1));
        $slastc = chr($slast);
        $pcheck = substr($string, -$slast);
        if (preg_match("/$slastc{" . $slast . "}/", $string)) {
            $string = substr($string, 0, strlen($string) - $slast);
            return $string;
        } else {
            return false;
        }
    }
}
