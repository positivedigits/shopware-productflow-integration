<?php

declare(strict_types=1);

namespace PositiveDigits\Service\ProductFlow\Offer;

use PositiveDigits\DTO\Offer\OfferRequestDTO;
use Psr\EventDispatcher\EventDispatcherInterface;
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
        private EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function sync(OfferRequestDTO $offerRequest, Context $context): void
    {
        $productData = $this->syncOfferTransformer->transform($offerRequest, $context);

        $this->productRepository->update([$productData], $context);

        $this->eventDispatcher->dispatch(new AfterOfferSyncEvent($offerRequest, $productData, $context));
    }

    public function unlist(OfferRequestDTO $offerRequest, Context $context): void
    {
        $productData = $this->unlistOfferTransformer->transform($offerRequest, $context);

        $this->productRepository->update([$productData], $context);

        $this->eventDispatcher->dispatch(new AfterOfferUnlistEvent($offerRequest, $productData, $context));
    }
}
