<?php

declare(strict_types=1);

namespace PositiveDigits\EventListener;

use PositiveDigits\ProductFlowIntegrationConfig;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;

final readonly class ProductFlowTokenValidationEventListener
{
    public const string TOKEN_VALIDATION_REQUIRED = 'productflow_token_validation_required';

    public function __construct(
        private SystemConfigService $systemConfigService,
    ) {
    }

    #[AsEventListener(event: RequestEvent::class)]
    public function validate(RequestEvent $event): void
    {
        if (false === $event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();

        if (false === $request->attributes->getBoolean(ProductFlowTokenValidationEventListener::TOKEN_VALIDATION_REQUIRED)) {
            return;
        }

        $token = $request->headers->get('Authorization');

        if ($token !== $this->systemConfigService->getString(ProductFlowIntegrationConfig::TOKEN)) {
            $event->setResponse(new JsonResponse(
                ['error' => 'Unauthorized: Invalid or missing token'],
                Response::HTTP_UNAUTHORIZED
            ));
        }
    }
}
