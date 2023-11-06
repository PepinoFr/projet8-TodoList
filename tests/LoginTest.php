<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class LoginTest extends WebTestCase
{
    public function testIfLoginSucessful(): void
    {
        $client = static::createClient();

        $urlGenrator = $client->getContainer()->get("router");

        $crawler = $client->request('GET',$urlGenrator->generate('login'));

        $sumbitButton = $crawler->selectButton('Se connecter');
        $form = $sumbitButton->form();
        $form['_username'] = "pepino";
        $form['_password'] = "test";

        $client->submit($form);
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $client->followRedirect();
        $this->assertRouteSame('homepage');
    }
}
