<?php

declare(strict_types=1);

namespace PositiveDigits\Service\ProductFlow\Offer;

use PositiveDigits\DTO\Offer\OfferRequestDTO;
use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

abstract readonly class AbstractOfferTransformer
{
    public function __construct(
        #[Autowire(service: 'product.repository')]
        private EntityRepository $productRepository,
    ) {
    }

    public function transform(OfferRequestDTO $offerRequest, Context $context): array
    {
        $product = $this->getProductBySKU($offerRequest->identifier->sku, $context);

        return [
            'id' => $product->getId(),
        ];
    }

    protected function getProductBySKU(string $sku, Context $context): ProductEntity
    {
        $criteria = new Criteria()
            ->addFilter(new EqualsFilter('productNumber', $sku))
            ->addAssociation('tax');

        /** @var ?ProductEntity $product */
        $product = $this->productRepository->search($criteria, $context)->first();

        if (null === $product) {
            throw new BadRequestException("No such product with SKU '{$sku}'.");
        }

        return $product;
    }
}
