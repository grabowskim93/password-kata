<?php

/**
 * Service to Validate password.
 */

declare(strict_types=1);

namespace App\User;

use App\Password\PasswordManager;

/**
 * Class UserService
 *
 * @package App\UserRepositoryInterface
 */
class UserService
{
    /**
     * @var \App\Password\PasswordManager
     */
    private $passwordManager;
    /**
     * @var \App\User\UserRepository
     */
    private $userRepository;

    /**
     * UserService constructor.
     *
     * @param \App\Password\PasswordManager     $passwordManager
     * @param \App\User\UserRepository $userRepository
     */
    public function __construct(
        PasswordManager $passwordManager,
        UserRepository $userRepository
    ) {
        $this->passwordManager = $passwordManager;
        $this->userRepository = $userRepository;
    }

    /**
     * @param string $username
     * @param string $password
     *
     * @return bool
     */
    public function areValidUserCredentials(string $username, string $password): bool
    {
        /**
         * @var \App\User\User $user
         */
        $user = $this->userRepository->getByUsername($username);

        return $this->passwordManager->validate($password, $user->getPassword());
    }
}
