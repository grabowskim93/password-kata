<?php

namespace App\Email;

interface EmailService
{
    public function send(string $to, string $subject, string $body);
}
