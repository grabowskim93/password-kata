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
 * @package App\UserRepository
 */
class UserService
{
    /**
     * @var \App\Password\PasswordManager
     */
    private $passwordManager;

    public function __construct(PasswordManager $passwordManager)
    {
        $this->passwordManager = $passwordManager;
    }

    /**
     * @param string $userName
     * @param string $password
     *
     * @return bool
     */
    public function areValidUserCredentials(string $userName, string $password): bool
    {
        $hashedPass = $this->passwordManager->generatePassword($password);

        return $this->passwordManager->validate($password, $hashedPass);
    }
}
