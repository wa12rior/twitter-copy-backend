<?php

namespace App\DataFixtures;

use App\Tests\Utils\UserBuilder;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = UserBuilder::create()
            ->setUsername('username')
            ->build();

        $manager->persist($user);

        $manager->flush();
    }
}
