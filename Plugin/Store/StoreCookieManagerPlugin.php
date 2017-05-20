<?php
/**
 * This file is part of the Multi-Store Fix Module for Magento 2.
 * Copyright (c) 2017 METMEER. All rights reserved.
 * See LICENSE for copyright and license details.
 */

namespace METMEER\MultiStoreFix\Plugin\Store;

use METMEER\MultiStoreFix\Model\Environment\Reader as EnvironmentReader;
use Magento\Store\Api\StoreCookieManagerInterface;

/**
 * StoreCookieManager Plugin Class.
 */
class StoreCookieManagerPlugin
{
    /**
     * @var EnvironmentReader
     */
    protected $environmentReader;

    /**
     * Plugin constructor.
     *
     * @param EnvironmentReader $environmentReader
     */
    public function __construct(EnvironmentReader $environmentReader)
    {
        $this->environmentReader = $environmentReader;
    }

    /**
     * Ignore store code from cookie when store is also defined with server environment
     * variable. This solves problems when both locale switcher and hostname based store
     * switch are combined.
     *
     * @param StoreCookieManagerInterface $subject
     * @param string $result
     * @return string
     */
    public function afterGetStoreCodeFromCookie(StoreCookieManagerInterface $subject, $result)
    {
        $serverStoreCode = $this->environmentReader->getStoreCode();
        if (false !== $serverStoreCode) {
            // Ignore the cookie and use the store code set by the webserver.
            $result = $serverStoreCode;
        }

        return $result;
    }
}
