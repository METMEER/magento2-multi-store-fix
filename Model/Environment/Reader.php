<?php
/**
 * This file is part of the Multi-Store Fix Module for Magento 2.
 * Copyright (c) 2017 METMEER. All rights reserved.
 * See LICENSE for copyright and license details.
 */

namespace METMEER\MultiStoreFix\Model\Environment;

use Magento\Framework\App\RequestInterface;

/**
 * Environment Reader Class.
 */
class Reader
{
    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * Constructor.
     *
     * @param RequestInterface $request
     */
    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * Reads store code from environment. Returns false if no store code is defined.
     *
     * @return string|false
     */
    public function getStoreCode()
    {
        $result = false;

        // Make sure the request object has a getServer method.
        if (is_callable([$this->request, 'getServer'])) {

            // Read environment variables from the request object.
            $runType = $this->request->getServer('MAGE_RUN_TYPE');
            $runCode = $this->request->getServer('MAGE_RUN_CODE');

            // If a store code is defined, use it as result.
            if ('store' === $runType && is_string($runCode) && '' !== $runCode) {
                $result = $runCode;
            }
        }

        return $result;
    }
}
