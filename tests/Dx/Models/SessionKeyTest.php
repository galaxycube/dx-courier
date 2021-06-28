<?php

namespace Dx\Models;

use Dx\Models\SessionKey;
use Dx\Exceptions\InvalidSessionKey;

use PHPUnit\Framework\TestCase;

/**
 * Class SessionKeyTest
 * @package Dx\Models
 * @covers \Dx\Models\SessionKey
 */
class SessionKeyTest extends TestCase
{

    /**
     * @testCase Set an invalid account or service center or password
     */
    public function testSetInvalidParameters(): void {

        $this->expectException(InvalidSessionKey::class);
        new SessionKey(1, 22, 333);
    }
}