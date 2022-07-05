<?php

namespace ZerosDev\NobuBank;

class Constant
{
    public const URL_API_DEVELOPMENT = 'http://uatmerchant.nobubank.com:2104/';
    public const URL_API_PRODUCTION = 'https://merchant.nobubank.com/';

    public const URL_STATUS_DEVELOPMENT = 'http://uatmerchantnotif.nobubank.com/';
    public const URL_STATUS_PRODUCTION = 'https://merchantnotif.nobubank.com/';

    public const URL_CANCEL_DEVELOPMENT = 'http://uatmerchant.nobubank.com:2101/';
    public const URL_CANCEL_PRODUCTION = 'https://merchant.nobubank.com/';

    public const MERGE = "merge";

    public const TYPE_JSON = "json";
    public const TYPE_ARRAY = "array";

    public const CONTENT_JSON = "application/json";
    public const CONTENT_FORM = "application/x-www-form-urlencoded";
}
