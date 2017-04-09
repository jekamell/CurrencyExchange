<?php

declare(strict_types=1);

namespace AppBundle\Security;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\SimplePreAuthenticatorInterface;

/**
 * Class ApiKeyAuthenticator
 */
class ApiKeyAuthenticator implements SimplePreAuthenticatorInterface, AuthenticationFailureHandlerInterface
{
    /**
     * @inheritdoc
     */
    public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey): PreAuthenticatedToken
    {
        if (!$userProvider instanceof ApiKeyUserProvider) {
            throw new \InvalidArgumentException(
                sprintf(
                    'The user provider must be an instance of ApiKeyUserProvider (%s was given).',
                    get_class($userProvider)
                )
            );
        }

        $apiKey = $token->getCredentials();
        if (!($username = $userProvider->getUsernameForApiKey($apiKey))) {
            throw new CustomUserMessageAuthenticationException(
                sprintf('User was not found: %s', $apiKey)
            );
        }

        $user = $userProvider->loadUserByUsername($username);

        return new PreAuthenticatedToken(
            $user,
            $apiKey,
            $providerKey,
            $user->getRoles()
        );
    }

    /**
     * @inheritdoc
     */
    public function supportsToken(TokenInterface $token, $providerKey): bool
    {
        return $token instanceof PreAuthenticatedToken && $token->getProviderKey() === $providerKey;
    }

    /**
     * @inheritdoc
     */
    public function createToken(Request $request, $providerKey): ?PreAuthenticatedToken
    {
        $apiKey = $request->headers->get('authorization');
        if (!$apiKey) {
            return null;
        }

        return new PreAuthenticatedToken(
            'anon.',
            $apiKey,
            $providerKey
        );
    }

    /**
     * @inheritdoc
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        return new JsonResponse(['_error' => 'Bad credentials'], Response::HTTP_UNAUTHORIZED);
    }
}
