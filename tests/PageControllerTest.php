<?php

namespace App\Tests;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class PageControllerTest extends WebTestCase
{

    public function testIfCreateTaskIsSuccessfull(): void
    {
        $karnel =  self::bootKernel();

        $client = static::createClient();

        // recup urlgenerator

        $urlGenerator = $client->getContainer()->get('router');
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        $user = $entityManager->find(User::class,1);

        //$client->loginUser($user);
        $this->logIn('mathieu', 'test');

        $crawler = $client->request(Request::METHOD_GET,$urlGenerator->generate('task_create'));

        $form = $crawler->filter('form[name=TaskType]')->form(
            [
                'TaskType[title]' =>"test test" ,
                'TaskType[content]' =>"contenet test pour test " ,
            ]
        );
        $client->submit($form);

        $client->followRedirect();

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("La tâche a été bien été ajoutée")')->count()
        );
        $routeName = $client->getRequest()->attributes->get('_route');
        $expectedRouteName = 'task_list';  // Remplacez 'nom_de_la_route_attendue' par le nom de la route que vous attendez

        $this->assertEquals($expectedRouteName, $routeName);
    }

    protected function logIn($username, $password)
    {
        $userRepository = $this->client->getContainer()->get('doctrine')->getRepository(User::class);
        $user = $userRepository->findOneBy(['username' => $username]);

        $firewallName = 'main'; // Le nom de votre pare-feu de sécurité

        $token = new UsernamePasswordToken($user, $password, $firewallName, $user->getRoles());
        $session = $this->client->getContainer()->get('session');
        $tokenStorage = $this->client->getContainer()->get('security.token_storage');
        $tokenStorage->setToken($token);
        $session->set('_security_'.$firewallName, serialize($token));
        $session->save();

        $this->client->getCookieJar()->set(new Cookie($session->getName(), $session->getId()));
    }
}
