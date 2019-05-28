<?php

/**
 * Generate and validate password.
 */

declare(strict_types=1);

namespace App\Password;

/**
 * Class PasswordGenerator
 *
 * @package App\Password
 */
interface PasswordManager
{
    /**
     * Generate hashed password with salt.
     *
     * @param string $password Plain password
     *
     * @return bool|string
     */
    public function generatePassword(string $password);

    /**
     * Validate password.
     *
     * @param string $password Plain password.
     * @param string $hashedPass
     *
     * @return bool
     */
    public function validate(string $password, string $hashedPass): bool;
}
