<?php

declare(strict_types=1);

namespace PositiveDigits\Service\ProductFlow\Offer;

use PositiveDigits\DTO\Offer\OfferRequestDTO;
use Shopware\Core\Framework\Context;

final readonly class BeforeOfferSyncEvent
{
    public function __construct(
        private OfferRequestDTO $offerRequestDTO,
        private Context $context,
    ) {
    }

    public function getOfferRequestDTO(): OfferRequestDTO
    {
        return $this->offerRequestDTO;
    }

    public function getContext(): Context
    {
        return $this->context;
    }
}
