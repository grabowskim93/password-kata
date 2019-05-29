<?php

/**
 * Test user credentials.
 */

declare(strict_types=1);

namespace Test;

use App\Email\EmailService;
use App\Password\PasswordManager;
use App\Token\TokenGenerator;
use App\User\User;
use App\User\UserEmailService;
use App\User\UserRepository;
use App\User\UserService;
use PHPUnit\Framework\TestCase;

/**
 * Class UserTest
 *
 * @package Test
 */
class UserTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject | PasswordManager
     */
    private $passwordManager;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject | \App\User\UserRepository
     */
    private $userRepository;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject | User
     */
    private $user;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject | TokenGenerator
     */
    private $tokenGenerator;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject | EmailService
     */
    private $userEmailService;

    protected function setUp()
    {
        $this->passwordManager = $this->getMockBuilder(PasswordManager::class)
            ->setMethods(['generatePassword', 'validate'])
            ->getMock();

        $this->userRepository = $this->getMockBuilder(UserRepository::class)
            ->setMethods(['getByUsername', 'getByEmail'])
            ->getMock();

        $this->user = $this->getMockBuilder(User::class)
            ->setMethods(['getPassword'])
            ->getMock();

        $this->tokenGenerator = $this->getMockBuilder(TokenGenerator::class)
            ->setMethods(['randomToken'])
            ->getMock();

        $this->userEmailService = $this->getMockBuilder(EmailService::class)
            ->setMethods(['send'])
            ->getMock();
    }

    /**
     *
     */
    public function testUserCredentials()
    {
        $userService = new UserService($this->passwordManager, $this->userRepository);

        $this->userRepository
            ->method('getByUsername')
            ->with('example_username')
            ->willReturn($this->user);

        $this->user->method('getPassword')
            ->willReturn('hashed_salt_pass01');

        $this->passwordManager->method('validate')
            ->with(
                $this->equalTo('pass01'),
                $this->equalTo('hashed_salt_pass01')
            )
            ->willReturn(true);

        $this->assertTrue($userService->areValidUserCredentials('example_username', 'pass01'));
    }

    public function testResetEmail()
    {
        $userEmailService = new UserEmailService($this->tokenGenerator, $this->userEmailService);

        $this->userRepository
            ->method('getByEmail')
            ->with('examplea_email@test.com')
            ->willReturn($this->user);


        $this->tokenGenerator
            ->expects($this->once())
            ->method('randomToken')
            ->willReturn('token');

        $userEmailService->sendResetEmail('example_email@test.com');
    }

    protected function tearDown()
    {
        unset($this->passwordManager);
    }
}
