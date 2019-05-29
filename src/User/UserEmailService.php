<?php

declare(strict_types=1);

namespace App\User;

use App\Email\EmailService;
use App\Token\TokenGenerator;

/**
 * Class UserEmailService
 *
 * @package App\User
 */
class UserEmailService
{
    /**
     * @var \App\Token\TokenGenerator
     */
    private $tokenGenerator;

    /**
     * @var \App\Email\EmailService
     */
    private $emailService;

    /**
     * UserEmailService constructor.
     *
     * @param \App\Token\TokenGenerator $tokenGenerator
     * @param \App\Email\EmailService   $emailService
     */
    public function __construct(TokenGenerator $tokenGenerator, EmailService $emailService)
    {
        $this->tokenGenerator = $tokenGenerator;
        $this->emailService = $emailService;
    }

    /**
     * @param string $email
     */
    public function sendResetEmail(string $email)
    {
        $token = $this->tokenGenerator->randomToken();

        $this->emailService->send($email, 'Reset password link.', $token);
    }
}
