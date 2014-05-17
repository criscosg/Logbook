<?php

namespace EasyScrumBO\BackendBundle\Test\Controller;

use EasyScrumBO\TestBundle\Classes\CustomTestCase;

class UserControllerTest extends CustomTestCase
{
    protected function setUp() {
        parent::setUp();
    }
    
    public function testAll()
    {
        $crawler = $this->client->request('GET', '/users/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(0, $crawler->filter('html:contains("Test")')->count());
    }

    public function testPost()
    {
        $crawler = $this->client->request('GET', '/users/new');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $form = $crawler->selectButton('Guardar')
        ->form(array('admin_user[name]' => 'Test',
                'admin_user[email]' => self::USERNAME,
                'admin_user[password]'=>123456,
                'admin_user[last_name]'=>'testeando',
                'admin_user[idiom]' => 'ES'));
        $crawler = $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $this->assertGreaterThan(0, $crawler->filter('html:contains("Test")')->count());
    }

    public function testView()
    {
        $crawler = $this->client->request('GET', '/users/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $link = $crawler->filter('a .fa-eye')->first()->parents()->first()->link();
        $crawler = $this->client->click($link);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("usuario")')->count());
    }

    public function testPut()
    {
        $crawler = $this->client->request('GET', '/users/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $link = $crawler->filter('a .fa-pencil')->first()->parents()->first()->link();
        $crawler = $this->client->click($link);
        $form = $crawler->selectButton('Guardar')
        ->form(array('admin_user[name]' => 'TestActualizado',
                'admin_user[email]' => self::USERNAME,
                'admin_user[password]'=>123456,
                'admin_user[last_name]'=>'testeando',
                'admin_user[idiom]' => 'ES'));
        $crawler = $this->client->submit($form);
        $crawler = $this->client->followRedirect();
    
        $this->assertGreaterThan(0, $crawler->filter('html:contains("TestActualizado")')->count());
    }

    public function testDelete()
    {
        $crawler = $this->client->request('GET', '/users/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $link = $crawler->filter('a .fa-trash-o')->first()->parents()->first()->link();
        $crawler = $this->client->click($link);
        $crawler = $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(0, $crawler->filter('html:contains("Test")')->count());
    }
}