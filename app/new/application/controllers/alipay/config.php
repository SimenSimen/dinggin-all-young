<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2017122901337522",

		//商户私钥，您的原始格式RSA私钥
		'merchant_private_key' => "MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQDHIctNTEpBs0C5YlnuPCdMSXNv1ISUk3dp8S3fPFktxOvu/sI//By+l4nTRzGV2LQehUkj5aCkYIgBJXKoPsRFao5zd1somKdjUjDQUoZ5tiQHQO5Am9C8LZPOZQiodYjUMQLgdWmE8rS1lIyR7hsA5BOnaXRn3TdwQkWpoAFteeqT063Da2qDvZX8E2iYnsYYzewbC5BQZ26ykvjZ3oU3ATB3ycJ42pllKovGb3Mizdfzgy54YPLTEFcytsxAf9Rl7dyDPXZEJc0EQvPsO2c2PJM/5NlSUEwvjjtAumhYEyrQuKsJokcTiy2B521LMxdfgQ69XhPMQLCjXi3t+ggHAgMBAAECggEAcFs/DMRI+b0cff1iZKuIOOEQwz6T+AkkzaAJk/XHE64SuW0BSX0E8v0qBQ4cikIVj0sBM8Hy3AyjcJIimY+gytIOwlPMGaHYgI/1fvWxbqc4uOcIB2hjZGoLBd+3/OUkaSWmS+OzwBH5qKLClexVTDFkbYdw6NHG4A5kpArmA1BSB7hEkWWmIpGYfWU5B6gBvbrlTjJcUxONT3zMBC+EzxPIcvxxgclfawG03pkHmuOW5hcDXc8hXVQHOfi62yir7uVUOyZOtzx84jyznz2GmbxEyj/RoalOmjZGdJiLmXZzSnprSGKyNKjrsP9KgoxEdxfSlnq0NMOOjlelrxueEQKBgQDoYll/69OxYkH/mRQLo9fZOaTmTDgSRPUmDRYOng+PcgMojXc3Nrcj3boIgb9qR99UfPQZL66/RTJHEGEBJH88vN7zVZL8XWHauGXt9bTu9qFddz8iVvx3Q2n6L+B0aGEyAm9AWyTjfSvRcwOq+M3RjritGcPmplSOYZvbYmJfFQKBgQDbXl05lgCYtzPCs3yZDk1RxRVsXz4zTrmvbrZPdJgqDFK7CV98lHYOcUOf6enauHz9tlkvJIpixB7b2fK7ncx0VAVSUncNhH3UQlqfOb1wkap6ii74wRIPohKqP5a6lfjp+GF/J4S5LKZjNAu1WWV1pPGvupPpxt7qX/S40iuxqwKBgB9xz3KD0q1aAlw3toKstPRr3GhdP+kY86MmeimYMbrTTqIaIluSR83OnvGvvNsAxrOEBPOzhA3Vqyv6h2XELoNlezWqCq2jZS5XbVN5v/Xl4YfoLt7Srm7k7F4yREj8JsrBkZQ/wQoXUeqRiZmE+TS1/z9NETkQoLhzdMeG1JDRAoGBAJc6ipI0ctzVD33eNrtdPLhuYcKANmUwlJn4fP5xpqT2MeJ3J7i+sFRsiO4pV+pM3P4bQ4hYbH6CLbPqoIfu1RAtDC4gY6qR+BzoUYkLSSndgeVQdelPUKAuXye3BrZCxYKmlLAQElOGEH67VocCxgtAVs2KloXHb82rsQ3o9e5ZAoGAIPRF5o+iy03n2tXZ1E+l7p50clUgH89UOW9+fMHFJeSdue7x4VOvTSv5eFqxc2EusTtQH5FXqVg6YaySRHgNh+ZkJbWNIh710lgG2dNU9aZR0Fq1Zq0IFKRrSMugmQWYhr4ch1OZN9YfFsyPGHkF891+DUQXeL4j1r8OjInrN1E=",
		
		//异步通知地址
		'notify_url' => "http://jcymall.test888.org/alipay_trade/alipay/notify_url.php",//"http://工程公网访问地址/alipay.trade.wap.pay-PHP-UTF-8/notify_url.php",
		
		//同步跳转
		'return_url' => "http://jcymall.test888.org/alipay_trade/alipay/returddn_url.php",//"http://mitsein.com/alipay.trade.wap.pay-PHP-UTF-8/returddn_url.php",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAs5LcqeUlgPTf1fvIsEI7kppqPsbCsbKGoP0bmenfhVGCvFhs7XuLix1IbfuoUM4j2VJKEoEgjj907zFPAraGN0GcsovULmFP051GfHCr8hnVvUslUkpTxKDOWyz5XArN8L9ZWDLD7GUsZtu8AuwILuyvpBh/Gk8EaTUI6Ve0P1dfKo9dJZTDwBlXLodeqTu3YhIzcb9SDLTrO7Ktvu6ANNhcmyNx+feYgSo3iLQ4jKVkThPWPVdAiiWb2+NOK9ZvcUlOZjddWTwkgv5tMVK8KfFeeRinaP/sclqktTQwNSccZZf0Yw8QPgQTn4JPGQSY46L3hjd+pdA+5VtimMoBgQIDAQAB",
		
	
);