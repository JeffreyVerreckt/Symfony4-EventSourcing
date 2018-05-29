<?php


namespace App\Infrastructure\EventStoreHttpApi;


use Prooph\EventStore\Http\Middleware\Transformer;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Class JsonTransformer
 * @package App\Infrastructure\EventStoreHttpApi
 */
final class JsonTransformer implements Transformer
{
    public function createResponse(array $result): ResponseInterface
    {
        return new JsonResponse($result);
    }
}
