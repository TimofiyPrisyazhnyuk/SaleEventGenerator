<?php


namespace common\context\application\services\SaleEventPromoCodeGenerator;

use common\context\application\entity\SaleEvent\SaleEventInterface;

/**
 * Class SaleEventPromoCodeGeneratorInterface
 * @package common\context\application\services\SaleEventPromoCodeGenerator
 */
interface SaleEventPromoCodeGeneratorInterface
{
    /**
     * Method generateForSaleEvent
     * @param SaleEventInterface $saleEvent
     * @return string
     */
    public function generateForSaleEvent(SaleEventInterface $saleEvent): string;

    /**
     * Method generateForSaleEventWithPrefix
     * @param SaleEventInterface $saleEvent
     * @param string $prefix
     * @return string
     */
    public function generateForSaleEventWithPrefix(SaleEventInterface $saleEvent, string $prefix): string;
}