<?php

declare(strict_types=1);

namespace PositiveDigits\Service\ProductFlow\Offer;

use PositiveDigits\DTO\Offer\OfferRequestDTO;
use Shopware\Core\Framework\Context;

final readonly class UnlistOfferTransformer extends AbstractOfferTransformer
{
    public function transform(OfferRequestDTO $offerRequest, Context $context): array
    {
        return array_merge(
            [
                'active' => false,
            ],
            parent::transform($offerRequest, $context)
        );
    }
}
