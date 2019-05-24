<?php

/**
 * Test password generator.
 */

declare(strict_types=1);

namespace Test;

use App\Password\PasswordGenerator;
use Generator;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Class PasswordTest
 *
 * @package Test
 */
class PasswordTest extends TestCase
{
    /**
     * @dataProvider validPasswordProvider
     *
     * @param $input
     */
    public function testValidPassword($input)
    {
        $generator = new PasswordGenerator();

        $password = $generator->generatePassword($input);
        $this->assertIsString($password);
    }


    /**
     * @dataProvider invalidPasswordProvider
     *
     * @param $input
     * @param $output
     */
    public function testInvalidPassword($input, $output)
    {
        $generator = new PasswordGenerator();

        $this->expectException($output);
        $generator->generatePassword($input);
    }

    /**
     * @return Generator
     */
    public function validPasswordProvider()
    {
        yield ['input' => 'Test123123!'];
        yield ['input' => 'Test./!@34%^&3!'];
    }

    /**
     * @return Generator
     */
    public function invalidPasswordProvider()
    {
        yield ['input' => 'testtesttest!', 'expected' => InvalidArgumentException::class];
        yield ['input' => '3333sadas3!', 'expected' => InvalidArgumentException::class];
        yield ['input' => 'Test!', 'expected' => InvalidArgumentException::class];
        yield ['input' => '23123!', 'expected' => InvalidArgumentException::class];
    }
}
