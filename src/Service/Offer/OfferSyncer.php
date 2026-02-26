<?php

declare(strict_types=1);

namespace PositiveDigits\Service\Offer;

use PositiveDigits\DTO\Offer\OfferRequestDTO;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

readonly class OfferSyncer
{
    public function __construct(
        private OfferTransformer $offerTransformer,
        #[Autowire(service: 'product.repository')]
        private EntityRepository $productRepository,
    ) {
    }

    public function sync(OfferRequestDTO $offerRequest, Context $context): void
    {
        $product = $this->offerTransformer->transform($offerRequest, $context);

        $this->productRepository->update([$product], $context);
    }
}
