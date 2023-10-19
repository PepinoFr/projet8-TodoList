<?php

namespace App\Tests;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskTest extends KernelTestCase
{
    public function CreateTask($title,$content) : Task
    {
        $task = new Task();
        $task->setTitle($title);
        $task->setContent($content);
        return $task;
    }
    public function testTitle(): void
    {

        $task = $this->CreateTask("toto","test titi");

       $karnel=  self::bootKernel();
        $errors = $karnel->getContainer()->get('validator')->validate($task);
        $this->assertCount(0,$errors);

      //  $this->assertSame('test', $kernel->getEnvironment());
        //$routerService = self::$container->get('router');
        //$myCustomService = self::$container->get(CustomService::class);
    }

    public function testNotitle() : void
    {
        $task = $this->CreateTask("","test titi");

        $karnel=  self::bootKernel();
        $errors = $karnel->getContainer()->get('validator')->validate($task);
        $this->assertCount(1,$errors);
    }
}
