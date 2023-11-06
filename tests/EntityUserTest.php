<?php

namespace App\Tests;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EntityUserTest extends WebTestCase
{
    public function testIfCreateUserSuccessfull(): void
    {
        $client = static::createClient();
        $urlGenerator = $client->getContainer()->get('router');

        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');


        $crawler = $client->request(Request::METHOD_GET,$urlGenerator->generate('user_create'));

        $form = $crawler->filter('form[name=user]')->form([
            'user[username]' => "pepino",
            'user[password][first]' => "test",
            'user[password][second]' => "test",
            'user[email]' => "pepino-du79@live.fr",

        ]);

        $client->submit($form);


        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        $this->assertSelectorTextContains('.alert-success'," L'utilisateur a bien été ajouté.");

        $this->assertRouteSame('user_list');
    }

    public function testIfUpdateAnTaskIsSuccessFull(): void {

        $client = static::createClient();
        $urlGenerator = $client->getContainer()->get('router');

        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        $user = $entityManager->find(User::class,1);

        $client->loginUser($user);

        /*  $task = $entityManager->getRepository(Task::class)->findOneBy([
              'user' => $user
          ]);*/

        $crawler =  $client->request(
            Request::METHOD_GET,
            $urlGenerator->generate('user_edit',['id'=>$user->getId()  ])
        );

        $this->assertResponseIsSuccessful();

        $form = $crawler->filter('form[name=user]')->form([
            'user[username]' => "mathieu",
            'user[password][first]' => "test",
            'user[password][second]' => "test",
            'user[email]' => "mathieulagnel@gmail.com",

        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        $this->assertSelectorTextContains('.alert-success',"L'utilisateur a bien été modifié");

        $this->assertRouteSame('user_list');


    }
}
