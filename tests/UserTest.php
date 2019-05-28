<?php

/**
 * Test user credentials.
 */

declare(strict_types=1);

namespace Test;

use App\Password\PasswordManager;
use App\User\User;
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
     * @var \PHPUnit\Framework\MockObject\MockObject | UserRepository
     */
    private $userRepository;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject | User
     */
    private $user;

    protected function setUp()
    {
        $this->passwordManager = $this->getMockBuilder(PasswordManager::class)
            ->setMethods(['generatePassword', 'validate'])
            ->getMock();

        $this->userRepository = $this->getMockBuilder(UserRepository::class)
            ->setMethods(['getByUsername'])
            ->getMock();

        $this->user = $this->getMockBuilder(User::class)
            ->setMethods(['getPassword'])
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

    protected function tearDown()
    {
        unset($this->passwordManager);
    }
}
