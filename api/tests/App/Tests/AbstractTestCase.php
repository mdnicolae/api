<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Faker\Factory;

abstract class AbstractTestCase extends ApiTestCase
{
    public function createProvider(): array
    {
        $faker = Factory::create();
        $providerResponse = static::createClient()->request('POST', '/providers', [
            'json' => [
                'name' => $faker->name(),
                'slug' => $faker->slug(),
                'email' => $faker->email(),
                'password' => 'password',
                'phone' => $faker->phoneNumber(),
                'iban' => $faker->iban(),
                'city' => $faker->city(),
                'cif' => (string) $faker->randomNumber(8),
                'services' => [],
            ],
            'headers' => [
                'Content-Type' => 'application/ld+json',
            ],
        ]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertJsonContains([
            '@context' => '/contexts/Provider',
            '@type' => 'Provider',
        ]);

        $this->assertMatchesJsonSchema(
            '{
                "type": "object",
                "properties": {
                    "@context": { "type": "string" },
                    "@id": { "type": "string" },
                    "@type": { "type": "string" },
                    "name": { "type": "string" },
                    "slug": { "type": "string" },
                    "email": { "type": "string" },
                    "phone": { "type": "string" },
                    "iban": { "type": "string" },
                    "city": { "type": "string" },
                    "cif": { "type": "string" },
                    "services": { "type": "array" }
                },
                "required": ["@context", "@id", "@type", "name", "slug", "email", "phone", "iban", "city", "cif", "services"]
            }'
        );


        return json_decode($providerResponse->getContent(), true);
    }

    public function createProviderAndGetToken()
    {
        $provider = $this->createProvider();
        $client = static::createClient();
        $client->request('POST', '/api/login_check', [
            'json' => [
                'email' => $provider['email'],
                'password' => 'password',
            ],
            'headers' => [
                'Content-Type' => 'application/ld+json',
            ],
        ]);

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseHeaderSame('content-type', 'application/json');
        $this->assertMatchesJsonSchema('{
            "type": "object",
            "properties": {
                "token": { "type": "string" }
            },
            "required": ["token"]
        }'
        );
        return json_decode($provider->getResponse(), true)['token'];
    }
}
