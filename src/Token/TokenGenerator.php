<?php

declare(strict_types=1);

namespace App\Token;

interface TokenGenerator
{
    public function randomToken(): string;
}
