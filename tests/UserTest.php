<?php

/**
 * Test user credentials.
 */

declare(strict_types=1);

namespace Test;

use App\Password\Authenticate;
use App\Password\PasswordManager;
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

    protected function setUp()
    {
        $this->passwordManager = $this->getMockBuilder(PasswordManager::class)
            ->setMethods(['generatePassword', 'validate'])
            ->getMock();
    }

    /**
     *
     */
    public function testUserCredentials()
    {
        $userService = new UserService($this->passwordManager);

        $this->passwordManager->method('generatePassword')
            ->willReturn('hashed_salt_pass01');


        $this->passwordManager->method('validate')
            ->willReturn(true);

        $this->assertTrue($userService->areValidUserCredentials('test@test.com', 'pass01'));
    }

    protected function tearDown()
    {
        unset($this->passwordManager);
    }
}
