<?php

declare(strict_types=1);

namespace PositiveDigits\Service\ProductFlow\Offer;

use PositiveDigits\DTO\Offer\OfferRequestDTO;
use Shopware\Core\Framework\Context;

final readonly class SyncOfferTransformer extends AbstractOfferTransformer
{
    public function transform(OfferRequestDTO $offerRequest, Context $context): array
    {
        $product = $this->getProductBySKU($offerRequest->identifier->sku, $context);

        return array_merge(
            [
                'active' => true,
                'stock' => $offerRequest->offer->sellableQuantity,
                'price' => [
                    [
                        'currencyId' => $context->getCurrencyId(),
                        'gross' => $grossPrice = $offerRequest->offer->price / 100,
                        'net' => round($grossPrice / (1 + ($product->getTax()->getTaxRate() / 100)), 4),
                        'linked' => true,
                        'listPrice' => [
                            'currencyId' => $context->getCurrencyId(),
                            'gross' => $grossPrice = $offerRequest->offer->basePrice / 100,
                            'net' => round($grossPrice / (1 + ($product->getTax()->getTaxRate() / 100)), 4),
                            'linked' => true,
                        ],
                    ],
                ],
            ],
            parent::transform($offerRequest, $context)
        );
    }
}
