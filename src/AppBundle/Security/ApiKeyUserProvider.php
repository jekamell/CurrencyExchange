<?php

declare(strict_types=1);

namespace AppBundle\Security;

use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Class ApiKeyUserProvider
 */
class ApiKeyUserProvider implements UserProviderInterface
{
    /** @var array */
    private $apiKeyUserMap = [
        'YECRSbpLDCXrJXCrVKOU' => ['username' => 'John', 'roles' => ['ROLE_USER']],
        'tR6TI49mh4fbKAuSjm9L' => ['username' => 'Jane', 'roles' => ['ROLE_USER', 'ROLE_ADMIN']]
    ];

    public function getUsernameForApiKey($apiKey)
    {
        if (array_key_exists($apiKey, $this->apiKeyUserMap)) {
            return $this->apiKeyUserMap[$apiKey]['username'];
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function loadUserByUsername($username)
    {
        $roles = [];
        foreach ($this->apiKeyUserMap as $token => $params) {
            if ($params['username'] === $username) {
                $roles = $params['roles'];
                break;
            }
        }

        return new User(
            $username,
            null,
            $roles
        );
    }

    /**
     * @inheritdoc
     */
    public function refreshUser(UserInterface $user)
    {
        throw new UnsupportedUserException();
    }

    /**
     * @inheritdoc
     */
    public function supportsClass($class): bool
    {
        return $class === User::class;
    }
}
