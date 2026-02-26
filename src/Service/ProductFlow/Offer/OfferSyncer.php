<?php

declare(strict_types=1);

namespace PositiveDigits\Service\ProductFlow\Offer;

use PositiveDigits\DTO\Offer\OfferRequestDTO;
use Shopware\Core\Content\Product\ProductCollection;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

readonly class OfferSyncer
{
    /**
     * @param EntityRepository<ProductCollection> $productRepository
     */
    public function __construct(
        #[Autowire(service: SyncOfferTransformer::class)]
        private AbstractOfferTransformer $syncOfferTransformer,
        #[Autowire(service: UnlistOfferTransformer::class)]
        private AbstractOfferTransformer $unlistOfferTransformer,
        #[Autowire(service: 'product.repository')]
        private EntityRepository $productRepository,
    ) {
    }

    public function sync(OfferRequestDTO $offerRequest, Context $context): void
    {
        $product = $this->syncOfferTransformer->transform($offerRequest, $context);

        $this->productRepository->update([$product], $context);
    }

    public function unlist(OfferRequestDTO $offerRequest, Context $context): void
    {
        $product = $this->unlistOfferTransformer->transform($offerRequest, $context);

        $this->productRepository->update([$product], $context);
    }
}
