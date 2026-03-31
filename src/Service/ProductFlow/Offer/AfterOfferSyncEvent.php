<?php

declare(strict_types=1);

namespace PositiveDigits\Service\ProductFlow\Offer;

use PositiveDigits\DTO\Offer\OfferRequestDTO;
use Shopware\Core\Framework\Context;

final readonly class AfterOfferSyncEvent
{
    /**
     * @param array<string, mixed> $productData
     */
    public function __construct(
        private OfferRequestDTO $offerRequestDTO,
        private array $productData,
        private Context $context,
    ) {
    }

    public function getOfferRequestDTO(): OfferRequestDTO
    {
        return $this->offerRequestDTO;
    }

    /**
     * @return array<string, mixed>
     */
    public function getProductData(): array
    {
        return $this->productData;
    }

    public function getContext(): Context
    {
        return $this->context;
    }
}
