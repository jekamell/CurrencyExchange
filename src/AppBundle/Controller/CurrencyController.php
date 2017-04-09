<?php

declare(strict_types=1);

namespace AppBundle\Controller;

use AppBundle\Entity\Currency;
use Mell\Bundle\SimpleDtoBundle\Controller\AbstractController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
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
     * @param Request $request
     * @return Response
     * @Route("/")
     * @Method({"POST"})
     * @ApiDoc(
     *     statusCodes={
     *         200="Return when operation success",
     *         400="Return when bad request format",
     *         403="Return when issuer had no permission for operation",
     *         422="Return when validation errors"
     *     },
     *     resource=true,
     *     section="Currency",
     *     description="Create resource",
     *     input={ "class"="AppBundle\Entity\Currency", "groups"="create"},
     *     output={ "class"="AppBundle\Entity\Currency", "groups"="read"}
     * ),
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
     * @param Currency $currency
     * @return Response
     * @Route("/{id}", requirements={"id" = "\d+"})
     * @Method({"GET"})
     * @ApiDoc(
     *     statusCodes={
     *         200="Return when operation success",
     *         403="Return when issuer had no permission for operation"
     *     },
     *     resource=true,
     *     section="Currency",
     *     description="Read resource",
     *     output={ "class"="AppBundle\Entity\Currency", "groups"="read"}
     * ),
     * @Security("has_role('ROLE_USER')")
     */
    public function readAction(Currency $currency): Response
    {
        return $this->serializeResponse($this->readResource($currency));
    }

    /**
     * @param Currency $currency
     * @return Response
     * @Route("/{id}", requirements={"id" = "\d+"})
     * @Method({"DELETE"})
     * @ApiDoc(
     *     statusCodes={
     *         200="Return when operation success",
     *         403="Return when issuer had no permission for operation"
     *     },
     *     resource=true,
     *     section="Currency",
     *     description="Delete resource"
     * ),
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Currency $currency): Response
    {
        $this->deleteResource($currency);

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }


    /**
     * @return Response
     * @Route("/")
     * @Method({"GET"})
     * @ApiDoc(
     *     statusCodes={
     *         200="Return when operation success",
     *         403="Return when issuer had no permission for operation"
     *     },
     *     resource=true,
     *     section="Currency",
     *     description="List resources",
     *     output={ "class"="AppBundle\Entity\Currency", "groups"="read"}
     * ),
     * @Security("has_role('ROLE_USER')")
     */
    public function listAction(): Response
    {
        return $this->serializeResponse($this->listResources($this->getQueryBuilder()));
    }
}
