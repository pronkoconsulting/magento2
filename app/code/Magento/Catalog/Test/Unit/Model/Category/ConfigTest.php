<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\Catalog\Test\Unit\Model\Category;

use Magento\Store\Model\ScopeInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Magento\Catalog\Model\Category\Config;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Catalog\Model\Config as CatalogConfig;

class ConfigTest extends TestCase
{
    /**
     * @var Config
     */
    private $object;

    /**
     * @var ScopeConfigInterface|MockObject
     */
    private $scopeConfig;

    protected function setUp(): void
    {
        $this->object = $this->getMockBuilder(Config::class)
            ->disableOriginalConstructor()
            ->setMethods(['getDefaultSortField'])
            ->getMock();

        $this->scopeConfig = $this->createMock(ScopeConfigInterface::class);
        $this->object = new Config($this->scopeConfig);
    }

    public function testGetDefaultSortField(): void
    {
        $order = 'position';
        $scopeCode = 'store';
        $this->scopeConfig->expects($this->any())
            ->method('getValue')
            ->with(
                CatalogConfig::XML_PATH_LIST_DEFAULT_SORT_BY,
                ScopeInterface::SCOPE_STORE,
                $scopeCode
            )
            ->willReturn($order);

        $this->assertEquals($order, $this->object->getDefaultSortField($scopeCode));
    }
}
