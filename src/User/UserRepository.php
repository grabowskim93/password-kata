<?php

namespace App\User;

interface UserRepository
{
    public function getByUsername(string $username): User;
}
