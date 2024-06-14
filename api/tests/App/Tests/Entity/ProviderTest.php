<?php

namespace App\Tests\Entity;

use App\Tests\AbstractTestCase;

class ProviderTest extends AbstractTestCase
{
    public function testCreateProvider(): void
    {
        $this->createProvider();
    }

    public function testLoginForProvider(): void
    {
        $this->createProviderAndGetToken();
    }

}
