<?php

declare(strict_types=1);

namespace PositiveDigits\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Service\Attribute\Required;

abstract class AbstractProductFlowController extends AbstractController
{
    private SerializerInterface $serializer;

    #[Required]
    public function setSerializer(SerializerInterface $serializer): void
    {
        $this->serializer = $serializer;
    }

    /**
     * @throws ExceptionInterface
     */
    protected function serializedJsonResponse(object $dto): JsonResponse
    {
        $json = $this->serializer->serialize($dto, JsonEncoder::FORMAT, [
            AbstractObjectNormalizer::SKIP_NULL_VALUES => true,
            AbstractObjectNormalizer::SKIP_UNINITIALIZED_VALUES => true,
        ]);

        return JsonResponse::fromJsonString($json);
    }
}
