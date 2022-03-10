<?php


namespace common\infrastructure\services\SaleEventPromoCodeGenerator;

use common\context\application\entity\SaleEvent\SaleEventInterface;
use common\context\application\entity\SaleEvent\SaleEventTypeEnum;
use common\context\application\entity\SaleEventPromoCode\SaleEventPromoCodePrefixEnum;
use common\context\application\repository\SaleEventPromoCode\SaleEventPromoCodeRepositoryInterface;
use common\context\application\services\SaleEventPromoCodeGenerator\SaleEventPromoCodeGeneratorInterface;

/**
 * Class SaleEventPromoCodeGenerator
 * @package common\infrastructure\services\SaleEventPromoCodeGenerator
 */
class SaleEventPromoCodeGenerator implements SaleEventPromoCodeGeneratorInterface
{
    /**
     * SaleEventPromoCodeGenerator constructor.
     * @param SaleEventPromoCodeRepositoryInterface $saleEventPromoCodeRepository
     */
    public function __construct(
        private SaleEventPromoCodeRepositoryInterface $saleEventPromoCodeRepository
    )
    {
    }

    /**
     * @inheritDoc
     */
    public function generateForSaleEvent(SaleEventInterface $saleEvent): string
    {
        $promoCodePrefix = $this->getPromoCodePrefixByType($saleEvent->getType());
        return $this->generatePromoCode($saleEvent, $promoCodePrefix);
    }

    /**
     * @inheritDoc
     */
    public function generateForSaleEventWithPrefix(SaleEventInterface $saleEvent, string $prefix): string
    {
        return $this->generatePromoCode($saleEvent, $prefix);
    }

    /**
     * Method generatePromoCode
     * @param SaleEventInterface $saleEvent
     * @param string $promoCodePrefix
     * @return string
     */
    private function generatePromoCode(SaleEventInterface $saleEvent, string $promoCodePrefix): string
    {
        $promoCodeParts = [
            $promoCodePrefix,
            mb_strtoupper(substr(md5(mt_rand()), 0, 4)),
            mb_strtoupper(substr(md5(mt_rand()), 0, 4)),
            mb_strtoupper(substr(md5(mt_rand()), 0, 4)),
            mb_strtoupper(substr(md5(mt_rand()), 0, 5)),
        ];
        $promoCodeCandidate = implode('-', $promoCodeParts);
        if ($this->saleEventPromoCodeRepository->isExistPromoCode($promoCodeCandidate)) {
            return $this->generateForSaleEvent($saleEvent);
        }
        return $promoCodeCandidate;
    }

    /**
     * Method getPromoCodePrefixByType
     * @param string $saleEventType
     * @return string
     */
    private function getPromoCodePrefixByType(string $saleEventType): string
    {
        return match ($saleEventType) {
            SaleEventTypeEnum::welcome() => SaleEventPromoCodePrefixEnum::welcome(),
            SaleEventTypeEnum::birthday() => SaleEventPromoCodePrefixEnum::birthday(),
            SaleEventTypeEnum::loyaltyFirst() => SaleEventPromoCodePrefixEnum::loyaltyFirst(),
            SaleEventTypeEnum::loyaltySecond() => SaleEventPromoCodePrefixEnum::loyaltySecond(),
            SaleEventTypeEnum::loyaltyThird() => SaleEventPromoCodePrefixEnum::loyaltyThird(),
            SaleEventTypeEnum::customSaleEvent() => SaleEventPromoCodePrefixEnum::customSaleEvent(),
            SaleEventTypeEnum::paymentOnlineSaleEvent() => SaleEventPromoCodePrefixEnum::paymentOnlineSaleEvent(),
        };
    }
}