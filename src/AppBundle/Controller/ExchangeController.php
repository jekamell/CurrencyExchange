<?php

declare(strict_types=1);

namespace AppBundle\Controller;

use AppBundle\Entity\Currency;
use AppBundle\Entity\ExchangeRequest;
use AppBundle\Entity\ExchangeResult;
use Mell\Bundle\SimpleDtoBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use UnexpectedValueException;

/**
 * Class ExchangeController
 * @Route("/exchange")
 */
class ExchangeController extends AbstractController
{
    /**
     * @Route("/")
     * @Method({"POST"})
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request): Response
    {
        try {
            /** @var ExchangeRequest $params */
            $params = $this->get('simple_dto.dto_manager')->deserializeEntity(
                new ExchangeRequest(),
                $request->getContent(),
                'json'
            );
        } catch (UnexpectedValueException $e) {
            throw new BadRequestHttpException('Malformed request data.');
        }

        $errors = $this->get('validator')->validate($params);
        if ($errors->count()) {
            return $this->serializeResponse($errors);
        }


        $currencyRepo = $this->getEntityManager()->getRepository('AppBundle:Currency');
        if (!($currencyFrom = $currencyRepo->find($params->getCurrencyFromId()))
            || !($currencyTo = $currencyRepo->find($params->getCurrencyToId()))
        ) {
            throw new NotFoundHttpException(sprintf('%s was not found', Currency::class));
        }

        return new JsonResponse(
            new ExchangeResult(
                $this->get('app.exchange_calculator')->calculate($currencyFrom, $currencyTo, $params->getAmount())
            )
        );
    }

    /**
     * @return string
     */
    public function getEntityAlias(): string
    {
        return '';
    }
}
