<?php

namespace App\User;

/**
 * Class UserRepository
 *
 * @package App\User
 */
class UserRepository
{
    /**
     * @param string $username
     *
     * @return \App\User\User
     */
    public function getByUsername(string $username): User
    {
    }

    /**
     * @param string $email
     *
     * @return \App\User\User
     */
    public function getByEmail(string $email): User
    {
    }
}
