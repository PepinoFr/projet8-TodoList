<?php

namespace App\Tests;


use App\Entity\Task;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class TaskTest extends WebTestCase
{

    private $id =1 ;
    private $idUser= 1;


    public function testIfCreateTaskSuccessfull(): void
    {
        $client = static::createClient();
        $urlGenerator = $client->getContainer()->get('router');

        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        $user = $entityManager->find(User::class,$this->idUser);

        $client->loginUser($user);

        $crawler = $client->request(Request::METHOD_GET,$urlGenerator->generate('task_create'));

        $form = $crawler->filter('form[name=task]')->form([
            'task[title]' => "un titre",
            'task[content]' => "une description",
        ]);

      $client->submit($form);


        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

       $client->followRedirect();

        $this->assertSelectorTextContains('.alert-success','La tâche a été bien été ajoutée');

        $this->assertRouteSame('task_list');
    }

    public function testIfListTaskIsSuccessful(): void
    {
        $client = static::createClient();
        $urlGenerator = $client->getContainer()->get('router');

        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        $user = $entityManager->find(User::class,$this->idUser);
        $client->loginUser($user);

        $client->request(Request::METHOD_GET,$urlGenerator->generate('task_list'));

       $this->assertResponseIsSuccessful();

       $this->assertRouteSame('task_list');

    }

    public function testIfUpdateAnTaskIsSuccessFull(): void {

        $client = static::createClient();
        $urlGenerator = $client->getContainer()->get('router');

        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        $user = $entityManager->find(User::class,$this->idUser);
        $task = $entityManager->find(Task::class,$this->id);

        $client->loginUser($user);

      /*  $task = $entityManager->getRepository(Task::class)->findOneBy([
            'user' => $user
        ]);*/

        $crawler =  $client->request(
             Request::METHOD_GET,
             $urlGenerator->generate('task_edit',['id'=>$task->getId()  ])
         );

         $this->assertResponseIsSuccessful();

        $form = $crawler->filter('form[name=task]')->form([
            'task[title]' => "un titre2",
            'task[content]' => "une description plus long",
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        $this->assertSelectorTextContains('.alert-success','La tâche a bien été modifiée');

        $this->assertRouteSame('task_list');


    }
    public function testIfToggleTaskIsSuccessFull(): void {

        $client = static::createClient();
        $urlGenerator = $client->getContainer()->get('router');

        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        $user = $entityManager->find(User::class,$this->idUser);
        $task = $entityManager->find(Task::class,$this->id);

        $client->loginUser($user);

        $crawler =  $client->request(
            Request::METHOD_GET,
            $urlGenerator->generate('task_toggle',['id'=>$task->getId()  ])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        $this->assertSelectorTextContains('.alert-success',"La tâche ". $task->getTitle()." a bien été marquée comme faite.");

        $this->assertRouteSame('task_list');


    }

    public function testIfDeleteAnTaskIsSuccessFull(): void
    {
        $client = static::createClient();
        $urlGenerator = $client->getContainer()->get('router');

        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        $user = $entityManager->find(User::class,$this->idUser);

        $client->loginUser($user);
        $task = $entityManager->find(Task::class,$this->id);
        $crawler = $client->request(Request::METHOD_GET,
            $urlGenerator->generate('task_delete',['id'=>$task->getId()  ]));

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        $this->assertSelectorTextContains('.alert-success'," La tâche a bien été supprimée.");

        $this->assertRouteSame('task_list');

    }


}
