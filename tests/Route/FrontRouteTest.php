<?php
namespace App\Test\Route;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FrontRouteTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testStartPage()
    {
        $this->client->request('GET', '');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testIndexPage()
    {
        $this->client->request('GET', 'index');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testContactPage()
    {
        $this->client->request('GET', 'contact');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testLoginPage()
    {
        $this->client->request('GET', 'login');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testRegisterPage()
    {
        $this->client->request('GET', 'register');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testRealizationPage()
    {
        $this->client->request('GET', 'realization');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testAboutUsPage()
    {
        $this->client->request('GET', 'about_us/index');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    protected function tearDown()
    {
        $this->client = NULL;
    }
}
