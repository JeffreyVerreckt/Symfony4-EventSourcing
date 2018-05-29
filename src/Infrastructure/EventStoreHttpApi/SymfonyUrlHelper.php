<?php


namespace App\Infrastructure\EventStoreHttpApi;


use Prooph\EventStore\Http\Middleware\UrlHelper;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class SymfonyUrlHelper
 * @package App\Infrastructure\EventStoreHttpApi
 */
final class SymfonyUrlHelper implements UrlHelper
{
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * SymfonyUrlHelper constructor.
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @param string $urlId
     * @param array $params
     * @return string
     */
    public function generate(string $urlId, array $params = []): string
    {
        return $this->urlGenerator->generate($urlId, $params);
    }
}
