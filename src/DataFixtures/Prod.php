<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class Prod extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        $task = New Task();
        $task->setTitle("tets");
        $task->setContent("toto");
        $manager->persist($task);

        $user = New User();
        $user->setUsername('anonyme');
        $user->setEmail('anonyme@gmail.com');
        $user->setPassword('$2y$13$sEVgGnRII.iFEsLA0RZV1u3T41m5AUvTCxF4yFkRu.pZUUkBZzKEK');
        $manager->persist($user);

        $user2 = New User();
        $user2->setUsername('user');
        $user2->setEmail('user@gmail.com');
        $user2->setPassword('$2y$13$sEVgGnRII.iFEsLA0RZV1u3T41m5AUvTCxF4yFkRu.pZUUkBZzKEK');
        $manager->persist($user2);

        $user3 = New User();
        $user3->setUsername('admin');
        $user3->setEmail('admin@gmail.com');
        $user3->setPassword('$2y$13$sEVgGnRII.iFEsLA0RZV1u3T41m5AUvTCxF4yFkRu.pZUUkBZzKEK');
        $user3->setRoles(array('ROLE_ADMIN'));
        $manager->persist($user3);

        $task2 = New Task();
        $task2->setTitle("tache2");
        $task2->setContent("toto");
        $task2->setUser($user2);
        $manager->persist($task2);

        $manager->flush();
    }
public static function getGroups(): array
     {
         return ['group1'];
     }
}
