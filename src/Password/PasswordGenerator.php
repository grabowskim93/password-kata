<?php

/**
 * Generate and validate password.
 */

declare(strict_types=1);

namespace App\Password;

use InvalidArgumentException;

/**
 * Class PasswordGenerator
 *
 * @package App\Password
 */
class PasswordGenerator
{
    /**
     * Generate hashed password with salt.
     *
     * @param string $password Plain password
     *
     * @return bool|string
     */
    public function generatePassword(string $password)
    {
        $this->validate($password);
        return password_hash($password, PASSWORD_BCRYPT, ['salt' => openssl_random_pseudo_bytes(40)]);
    }

    /**
     * Validate password.
     *
     * @param string $password Plain password.
     */
    private function validate(string $password): void
    {
        if (strlen($password) < 10) {
            throw new InvalidArgumentException();
        }

        $this->containsRequiredPasswordChars($password);
    }

    /**
     * Check if password contains all required chars.
     *
     * @param string $password Plain password.
     */
    private function containsRequiredPasswordChars(string $password): void
    {
        preg_match("/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(.*)/m", $password, $match);

        if (empty($match)) {
            throw new InvalidArgumentException();
        }
    }
}
