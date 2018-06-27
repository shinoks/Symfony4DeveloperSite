<?php
namespace App\Test\Route;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class DefaultControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testAdminPage()
    {
        $this->logIn();
        $this->client->request('GET', '/admin');
        $crawler = $this->client->followRedirect();
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertSame('Start', $crawler->filter('h1')->text());
    }

    public function testAdminUserPage()
    {
        $this->logIn();
        $this->client->request('GET', '/admin/user');
        $crawler = $this->client->followRedirect();
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertSame('Użytkownicy - Lista', $crawler->filter('h1')->text());
    }

    public function testAdminAdminPage()
    {
        $this->logIn();
        $this->client->request('GET', '/admin/admin');
        $crawler = $this->client->followRedirect();
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertSame('Administratorzy - Lista', $crawler->filter('h1')->text());
    }

    public function testAdminCategoryPage()
    {
        $this->logIn();
        $this->client->request('GET', '/admin/category');
        $crawler = $this->client->followRedirect();
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertSame('Kategorie - Lista', $crawler->filter('h1')->text());
    }

    public function testAdminConfigPage()
    {
        $this->logIn();
        $this->client->request('GET', '/admin/config');
        $crawler = $this->client->followRedirect();
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertSame('Konfiguracja', $crawler->filter('h1')->text());
    }

    public function testAdminContactPage()
    {
        $this->logIn();
        $this->client->request('GET', '/admin/contact');
        $crawler = $this->client->followRedirect();
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertSame('Formularze kontaktowe', $crawler->filter('h1')->text());
    }

    public function testAdminOfferPage()
    {
        $this->logIn();
        $this->client->request('GET', '/admin/offer');
        $crawler = $this->client->followRedirect();
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertSame('Lista Ofert', $crawler->filter('h1')->text());
    }

    public function testAdminOfferStatusPage()
    {
        $this->logIn();
        $this->client->request('GET', '/admin/offer_status');
        $crawler = $this->client->followRedirect();
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertSame('Statusy ofert', $crawler->filter('h1')->text());
    }

    public function testAdminRealizationPage()
    {
        $this->logIn();
        $this->client->request('GET', '/admin/realization');
        $crawler = $this->client->followRedirect();
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertSame('Realizacje', $crawler->filter('h1')->text());
    }

    public function testAdminArticlePage()
    {
        $this->logIn();
        $this->client->request('GET', '/admin/article');
        $crawler = $this->client->followRedirect();
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertSame('Artykuły - Lista', $crawler->filter('h1')->text());
    }

    public function testAdminMenuPage()
    {
        $this->logIn();
        $this->client->request('GET', '/admin/menu');
        $crawler = $this->client->followRedirect();
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertSame('Menu', $crawler->filter('h1')->text());
    }

    public function testAdminCommentPage()
    {
        $this->logIn();
        $this->client->request('GET', '/admin/comment');
        $crawler = $this->client->followRedirect();
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertSame('Komentarze', $crawler->filter('h1')->text());
    }

    public function testAdminSubscriberPage()
    {
        $this->logIn();
        $this->client->request('GET', '/admin/subscriber');
        $crawler = $this->client->followRedirect();
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertSame('Użytkownicy newslettera', $crawler->filter('h1')->text());
    }

    public function testAdminModulePage()
    {
        $this->logIn();
        $this->client->request('GET', '/admin/module');
        $crawler = $this->client->followRedirect();
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertSame('Moduły', $crawler->filter('h1')->text());
    }

    public function testAdminModulePositionPage()
    {
        $this->logIn();
        $this->client->request('GET', '/admin/module_position');
        $crawler = $this->client->followRedirect();
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertSame('Pozycje modułu', $crawler->filter('h1')->text());
    }

    public function testAdminModuleGenusPage()
    {
        $this->logIn();
        $this->client->request('GET', '/admin/module_genus');
        $crawler = $this->client->followRedirect();
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertSame('Typy modułów', $crawler->filter('h1')->text());
    }

    public function testAdminRecruitmentPage()
    {
        $this->logIn();
        $this->client->request('GET', '/admin/recruitment');
        $crawler = $this->client->followRedirect();
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertSame('Inwestycje', $crawler->filter('h1')->text());
    }

    public function testAdminRecruitmentNewPage()
    {
        $this->logIn();
        $crawler = $this->client->request('GET', '/admin/recruitment/new');
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertSame('Inwestycja', $crawler->filter('h1')->text());
    }

    public function testAdminRecruitmentStatusPage()
    {
        $this->logIn();
        $this->client->request('GET', '/admin/recruitment_status');
        $crawler = $this->client->followRedirect();
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertSame('Statusy inwestycji', $crawler->filter('h1')->text());
    }

    public function testAdminRecruitmentStatusNewPage()
    {
        $this->logIn();
        $crawler =$this->client->request('GET', '/admin/recruitment_status/new');
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertSame('Status inwestycji', $crawler->filter('h1')->text());
    }

    public function testAdminRecruitmentUserPage()
    {
        $this->logIn();
        $this->client->request('GET', '/admin/recruitment_user');
        $crawler = $this->client->followRedirect();
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertSame('Oferty inwestycji', $crawler->filter('h1')->text());
    }

    public function testAdminRecruitmentUserStatusPage()
    {
        $this->logIn();
        $this->client->request('GET', '/admin/recruitment_user_status');
        $crawler = $this->client->followRedirect();
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertSame('Statusy dla ofert', $crawler->filter('h1')->text());
    }

    public function testAdminRecruitmentUserStatusNewPage()
    {
        $this->logIn();
        $crawler =$this->client->request('GET', '/admin/recruitment_user_status/new');
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertSame('Status ofert', $crawler->filter('h1')->text());
    }

    public function testAdminNewsletterPage()
    {
        $this->logIn();
        $this->client->request('GET', '/admin/newsletter');
        $crawler = $this->client->followRedirect();
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertSame('Lista newsletterów', $crawler->filter('h1')->text());
    }

    private function logIn()
    {
        $session = $this->client->getContainer()->get('session');

        $firewallContext = 'admin';

        $token = new UsernamePasswordToken('admin', null, $firewallContext, array('ROLE_ADMIN'));
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }

    protected function tearDown()
    {
        $this->client = NULL;
    }
}
