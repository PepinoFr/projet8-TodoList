<?php

namespace App\Tests;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TastEntityTest extends KernelTestCase
{
    public function testEntityIsValid(): void
    {
        $kernel = self::bootKernel();
        $container = static::getContainer();

        $task = New Task();
        $task->setTitle("tets");
        $task->setContent("toto");

        $errors = $container->get('validator')->validate($task);

        $this->assertCount(0,$errors);
    }
    public function testEntityIsNoValid(): void
    {
        $kernel = self::bootKernel();
        $container = static::getContainer();

        $task = New Task();
        $task->setTitle("");
        $task->setContent("");

        $errors = $container->get('validator')->validate($task);

        $this->assertCount(2,$errors);
    }
}
