<?php


namespace App\Presentation\UI\Api\Rest;


use App\Core\Component\Product\Domain\Model\Product\Command\ChangeProductPrice;
use App\Core\Component\Product\Domain\Model\Product\Command\CreateProduct;
use App\Core\Component\Product\Domain\Model\Product\Query\GetAllProducts;
use Prooph\ServiceBus\CommandBus;
use Prooph\ServiceBus\Exception\CommandDispatchException;
use Prooph\ServiceBus\QueryBus;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProductController
 * @package App\Presentation\UI\Api\Rest
 */
final class ProductController
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var QueryBus
     */
    private $queryBus;

    /**
     * ProductController constructor.
     * @param CommandBus $commandBus
     * @param QueryBus $queryBus
     * @param LoggerInterface $logger
     */
    public function __construct(CommandBus $commandBus, QueryBus $queryBus, LoggerInterface $logger)
    {
        $this->commandBus = $commandBus;
        $this->logger = $logger;
        $this->queryBus = $queryBus;
    }

    /**
     * @Route("products", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function postProduct(Request $request): JsonResponse
    {
        $payload = $this->getPayloadFromRequest($request);

        try {
            $this->commandBus->dispatch(new CreateProduct($payload));
        } catch (CommandDispatchException $e) {
            return JsonResponse::create(['message' => $e->getPrevious()->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            return JsonResponse::create(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return JsonResponse::create(null, Response::HTTP_ACCEPTED);
    }

    /**
     * @Route("products/{productId}/changePrice", methods={"PUT"})
     * @param string $productId
     * @param Request $request
     * @return JsonResponse
     */
    public function putProductPrice(string $productId, Request $request): JsonResponse
    {
        $payload = $this->getPayloadFromRequest($request);
        $payload['id'] = $productId;

        try {
            $this->commandBus->dispatch(new ChangeProductPrice($payload));
        } catch (CommandDispatchException $e) {
            return JsonResponse::create(['message' => $e->getPrevious()->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            return JsonResponse::create(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return JsonResponse::create(null, Response::HTTP_ACCEPTED);
    }

    /**
     * @Route("products", methods={"GET"})
     * @return JsonResponse
     */
    public function getProducts(): JsonResponse
    {
        $this->queryBus->dispatch(new GetAllProducts())->done(function($products) use (&$response) {
            $response = $products;
        });

        return JsonResponse::create($response, Response::HTTP_ACCEPTED);
    }

    /**
     * @param Request $request
     * @return array
     */
    private function getPayloadFromRequest(Request $request): array
    {
        $payload = json_decode($request->getContent(), true);

        return $payload ?? [];
    }
}