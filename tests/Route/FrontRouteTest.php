<?php
namespace App\Test\Route;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FrontRouteTest extends WebTestCase
{
    public function testStartPage()
    {
        $client = static::createClient();
        $client->request('GET', '');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testIndexPage()
    {
        $client = static::createClient();
        $client->request('GET', 'index');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testContactPage()
    {
        $client = static::createClient();
        $client->request('GET', 'contact');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testLoginPage()
    {
        $client = static::createClient();
        $client->request('GET', 'login');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testRegisterPage()
    {
        $client = static::createClient();
        $client->request('GET', 'register');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testRealizationPage()
    {
        $client = static::createClient();
        $client->request('GET', 'realization');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAboutUsPage()
    {
        $client = static::createClient();
        $client->request('GET', 'about_us');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testNewsPage()
    {
        $client = static::createClient();
        $client->request('GET', 'news');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testInvestorZonePage()
    {
        $client = static::createClient();
        $client->request('GET', 'investor_zone');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
