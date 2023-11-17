<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Test extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = New User();
        $user->setUsername('mathieu');
        $user->setEmail('mathieulagnel@gmail.com');
        $user->setPassword('$2y$13$sEVgGnRII.iFEsLA0RZV1u3T41m5AUvTCxF4yFkRu.pZUUkBZzKEK');
        $user->setRoles(array('ROLE_ADMIN'));
        $manager->persist($user);

        $manager->flush();
    }
}
