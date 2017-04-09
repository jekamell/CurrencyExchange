<?php

declare(strict_types=1);

namespace AppBundle\Controller;

use Mell\Bundle\SimpleDtoBundle\Controller\AbstractController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

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
     * )
     */
    public function listAction(): Response
    {
        return $this->serializeResponse($this->listResources($this->getQueryBuilder()));
    }
}
