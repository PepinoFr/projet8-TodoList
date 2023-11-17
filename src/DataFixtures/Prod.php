<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Prod extends Fixture
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

        $manager->flush();
    }
}
