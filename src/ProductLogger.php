<?php
namespace App;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Log\Logger;

class ProductLogger implements LoggerAwareInterface
{
    public const CREATE = 'create';
    public const UPDATE = 'update';
    public const DISPLAY = 'display';
    public const DELETE = 'delete';

    /**
     * @var Logger $logger
     */
    private $logger;

    /**
     * @var RequestStack $requestStack
     */
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }
    
    /**
     * @param int $id
     * @param string $action
     */
    public function log(int $id, string $action): void
    {
        $request = $this->requestStack->getCurrentRequest();
        $this->logger->info("Product with id: $id was {$action} by " . ($request ? $request->getClientIp() : 'undefined IP'));
    }
}
