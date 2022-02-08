<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\User;
use App\Repository\UserRepository;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class UserApiTest extends ApiTestCase
{
    // This trait provided by AliceBundle will take care of refreshing the database content to a known state before each test
    use RefreshDatabaseTrait;

    // Through the container, you can access all your services from the tests, including the ORM, the mailer, remote API clients...
    private UserRepository $userRepository;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        self::bootKernel();
        $this->userRepository = static::$kernel->getContainer()->get(UserRepository::class);
    }

    public function testGetCollection(): void
    {
        // The client implements Symfony HttpClient's `HttpClientInterface`, and the response `ResponseInterface`
        $response = static::createClient()->request('GET', '/users');

        $this->assertResponseIsSuccessful();
        // Asserts that the returned content type is JSON-LD (the default)
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        // Asserts that the returned JSON is a superset of this one
        $this->assertJsonContains([
            '@context' => '/contexts/User',
            '@id' => '/users',
            '@type' => 'hydra:Collection',
            'hydra:view' => [
                '@id' => '/users?page=1',
                '@type' => 'hydra:PartialCollectionView',
                'hydra:first' => '/users?page=1',
                'hydra:last' => '/users?page=4',
                'hydra:next' => '/users?page=2',
            ],
        ]);

        // Because test fixtures are automatically loaded between each test, you can assert on them
        $this->assertCount(30, $response->toArray()['hydra:member']);

        // Asserts that the returned JSON is validated by the JSON Schema generated for this resource by API Platform
        // This generated JSON Schema is also used in the OpenAPI spec!
        $this->assertMatchesResourceCollectionJsonSchema(User::class);
    }

    public function testCreateUser(): void
    {
        $response = static::createClient()->request('POST', '/users', [
            'json' => [
              'email' => 'email@email.email',
              'username' => 'string',
              'roles' => [
                  'string',
              ],
              'password' => 'string',
              'createdAt' => '2022-01-15T13:21:09.904Z',
              'updatedAt' => '2022-01-15T13:21:09.904Z',
            ]
        ]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains([
            '@context' => '/contexts/User',
            '@type' => 'User',
            'email' => 'email@email.email',
            'username' => 'string',
            'roles' => [
                'string',
            ],
            'password' => 'string',
            'createdAt' => '2022-01-15T13:21:09.904Z',
            'updatedAt' => '2022-01-15T13:21:09.904Z',
        ]);
        $this->assertMatchesRegularExpression('~^/users/\d+$~', $response->toArray()['@id']);
        $this->assertMatchesResourceItemJsonSchema(User::class);
    }

    public function testCreateInvalidUser(): void
    {
        static::createClient()->request('POST', '/users', ['json' => [
            'isbn' => 'invalid',
        ]]);

        $this->assertResponseStatusCodeSame(422);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        $this->assertJsonContains([
            '@context' => '/contexts/ConstraintViolationList',
            '@type' => 'ConstraintViolationList',
            'hydra:title' => 'An error occurred',
            'hydra:description' => 'email: This value should not be blank.
username: This value should not be blank.
password: This value should not be blank.',
        ]);
    }

    public function testUpdateUser(): void
    {
        $client = static::createClient();
        // findIriBy allows to retrieve the IRI of an item by searching for some of its properties.
        // ISBN 9786644879585 has been generated by Alice when loading test fixtures.
        // Because Alice use a seeded pseudo-random number generator, we're sure that this ISBN will always be generated.
        $iri = $this->findIriBy(User::class, ['username' => 'username']);

        $client->request('PUT', $iri, ['json' => [
            'username' => 'string',
        ]]);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            '@id' => $iri,
            'username' => 'string',
        ]);
    }

    public function testDeleteUser(): void
    {
        $client = static::createClient();
        $iri = $this->findIriBy(User::class, ['username' => 'username']);

        $client->request('DELETE', $iri);

        $this->assertResponseStatusCodeSame(204);
        $this->assertNull(
            $this->userRepository->findOneBy(['username' => 'username'])
        );
    }
}