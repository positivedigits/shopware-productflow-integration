<?php

declare(strict_types=1);

namespace PositiveDigits\Service\ProductFlow\Offer;

use PositiveDigits\DTO\Offer\OfferRequestDTO;
use Shopware\Core\Framework\Context;

final readonly class SyncOfferTransformer extends AbstractOfferTransformer
{
    /**
     * @return array<string, mixed>
     */
    public function transform(OfferRequestDTO $offerRequest, Context $context): array
    {
        $product = $this->getProductBySKU($offerRequest->identifier->sku, $context);

        if (null === $product->getTax()) {
            throw new \RuntimeException("Product with number '{$product->getProductNumber()}' has no tax rate assigned.");
        }

        return array_merge(
            [
                'active' => true,
                'stock' => $offerRequest->offer?->sellableQuantity,
                'isCloseout' => true,
                'price' => [
                    [
                        'currencyId' => $context->getCurrencyId(),
                        'gross' => $grossPrice = $offerRequest->offer?->price / 100,
                        'net' => round($grossPrice / (1 + ($product->getTax()->getTaxRate() / 100)), 4),
                        'linked' => true,
                        'listPrice' => [
                            'currencyId' => $context->getCurrencyId(),
                            'gross' => $grossPrice = $offerRequest->offer?->basePrice / 100,
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
