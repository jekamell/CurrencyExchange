<?php

declare(strict_types=1);

namespace AppBundle\Controller;

use AppBundle\Entity\Currency;
use Mell\Bundle\SimpleDtoBundle\Controller\AbstractController;
use Nelmio\ApiDocBundle\Annotation\Operation;
use Nelmio\ApiDocBundle\Annotation\Model;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Swagger\Annotations as SWG;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class CurrencyController
 * @Route("/currencies")
 */
class CurrencyController extends AbstractController
{
    /**
     * @return string
     */
    public function getEntityAlias(): string
    {
        return 'AppBundle:Currency';
    }

    /**
     * @Route("/")
     * @Method({"POST"})
     * @param Request $request
     * @return Response
     * @Operation(
     *     tags={"Currency"},
     *     summary="Create new currency",
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         @Model(type=Currency::class)
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Return when operation success",
     *         @Model(type=AppBundle\Entity\Currency::class, groups={"create"})
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Return when bad request format"
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Return when issuer had no permission for operation"
     *     ),
     *     @SWG\Response(
     *         response="422",
     *         description="Return when validation errors"
     *     )
     * )
     *,
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function createAction(Request $request): Response
    {
        $entity = $this->createResource($request, new Currency());
        if ($entity instanceof ConstraintViolationListInterface) {
            return $this->serializeResponse($entity);
        }

        return $this->serializeResponse($this->readResource($entity));
    }

    /**
     * @Route("/{id}")
     * @Method({"GET"})
     * @param Currency $currency
     * @return Response
     * @Operation(
     *     tags={"Currency"},
     *     summary="Read currency data",
     *     @SWG\Parameter(
     *         name="_fields",
     *         in="query",
     *         description="Required fields",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="_expands",
     *         in="query",
     *         description="Required expands",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Return when operation success",
     *         @Model(type=AppBundle\Entity\Currency::class)
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Return when issuer had no permission for operation"
     *     )
     * )
     *,
     * @Security("has_role('ROLE_USER')")
     */
    public function readAction(Currency $currency): Response
    {
        return $this->serializeResponse($this->readResource($currency));
    }

    /**
     * @Route("/{id}")
     * @Method({"DELETE"})
     * @param Currency $currency
     * @return Response
     * @Operation(
     *     tags={"Currency"},
     *     summary="Delete currency",
     *     @SWG\Response(
     *         response="204",
     *         description="Return when operation success"
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Return when issuer had no permission for operation"
     *     )
     * )
     *,
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Currency $currency): Response
    {
        $this->deleteResource($currency);

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }


    /**
     * @Route("/")
     * @Method({"GET"})
     * @return Response
     * @Operation(
     *     tags={"Currency"},
     *     summary="List currencies collection",
     *     @SWG\Response(
     *         response="200",
     *         description="Return when operation success",
     *         @Model(type=AppBundle\Entity\Currency::class)
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Return when issuer had no permission for operation"
     *     )
     * ),
     * @Security("has_role('ROLE_USER')")
     */
    public function listAction(): Response
    {
        return $this->serializeResponse($this->listResources($this->getQueryBuilder()));
    }
}
