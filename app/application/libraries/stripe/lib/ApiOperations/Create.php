<?php

namespace Stripe\ApiOperations;

/**
 * Trait for creatable resources. Adds a `create()` static method to the class.
 *
 * This trait should only be applied to classes that derive from StripeObject.
 */
trait Create
{
    /**
     * @param array|null $params
     * @param array|string|null $options
     *
     * @return \Stripe\ApiResource The created resource.
     */
    public static function create($params = null, $options = null)
    {
        self::_validateParams($params);
        $url = static::classUrl();
        list($response, $opts) = static::_staticRequest('post', $url, $params, $options);

        $response_json =json_encode($response);
        $opts_json     =json_encode($opts);

        $obj = \Stripe\Util\Util::convertToStripeObject($response->json, $opts);
       
        //return $obj;
        $obj->setLastResponse($response_json->json);
        
        return $obj;
    }
}
