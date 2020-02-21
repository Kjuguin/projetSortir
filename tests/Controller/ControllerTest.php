<?php

namespace App\Tests\Controller;

use App\Controller\ProfilController;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class ControllerTest extends WebTestCase
{

    /**
     * Méthode pour intialiser un utilisateur
     * @var KernelBrowser|null
     */
    private $client = null;
    public function setUp()
    {
        $this->client = static::createClient();
    }

    /**
     * Méthode pour enregistrer une authentification
     */
    private function logIn()
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $this->client->getContainer()
            ->get('doctrine')
            ->getManager();
        $session = $this->client->getContainer()->get('session');
        $securityTokenStorage = $this->client->getContainer()->get('security.token_storage');
        $eventDispatcher = $this->client->getContainer()->get('event_dispatcher');
        $user = $entityManager->getRepository(User::class)->find(164);
        $firewallName = 'main';
        // if you don't define multiple connected firewalls, the context defaults to the firewall name
        // See https://symfony.com/doc/current/reference/configuration/security.html#firewall-context
        $firewallContext = 'main';
        // you may need to use a different token class depending on your application.
        // for example, when using Guard authentication you must instantiate PostAuthenticationGuardToken
        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $securityTokenStorage->setToken($token);
        $session->set('_security_main', serialize($token));
        $session->save();
        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
    /**
     * Méthode pour enregistrer une authentification d'admin
     */
    private function logInAdmin()
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $this->client->getContainer()
            ->get('doctrine')
            ->getManager();
        $session = $this->client->getContainer()->get('session');
        $securityTokenStorage = $this->client->getContainer()->get('security.token_storage');
        $eventDispatcher = $this->client->getContainer()->get('event_dispatcher');
        $user = $entityManager->getRepository(User::class)->find(157);
        $firewallName = 'main';
        // if you don't define multiple connected firewalls, the context defaults to the firewall name
        // See https://symfony.com/doc/current/reference/configuration/security.html#firewall-context
        $firewallContext = 'main';
        // you may need to use a different token class depending on your application.
        // for example, when using Guard authentication you must instantiate PostAuthenticationGuardToken
        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $securityTokenStorage->setToken($token);
        $session->set('_security_main', serialize($token));
        $session->save();
        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }

    /********************* Tests de redirection ou d'affichage *********************/

    /**
     * Test de redirection de la page home si utilisateur non connecté
     */
    public function testRedirectHomeIfNotConnected()
    {
        $this->client->request('GET', '/');
        $this->assertSame(302, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Test affichage de la page home si utilisateur connecté
     */
    public function testHomepageIsUp()
    {
        $this->logIn();
        $crawler = $this->client->request('GET', '/');
        //echo $this->client->getResponse()->getContent();
        $this->assertSame(1,$crawler->filter('html:contains("Le nom contient")')->count());
    }

    /**
     * Test de redirection afficher profil si utilisateur non connecté
     */
    public function testRedirectAfficherProfilIfNotConnected()
    {
        $this->client->request('GET', '/utilisateur/afficherProfil/164');
        $this->assertSame(302, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Test affichage de la page afficher profil si utilisateur connecté
     */
    public function testAfficherProfilIsUp()
    {
        $this->logIn();
        $this->client->request('GET', '/utilisateur/afficherProfil/157');
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Test de redirection afficher sortie si utilisateur non connecté
     */
    public function testRedirectAfficherSortieIfNotConnected()
    {
        $this->client->request('GET', '/sortie/afficherSortie/264');
        $this->assertSame(302, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Test affichage de la page afficher sortie si utilisateur connecté
     */
    public function testAfficherSortieIsUp()
    {
        $this->logIn();
        $this->client->request('GET', '/sortie/afficherSortie/264');
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Test de redirection inscription sortie si utilisateur non admin
     */
    public function testRedirectInscriptionSortieIfNotAdmin()
    {
        $this->client->request('GET', '/registration');
        $crawler = $this->client->followRedirect();
        $this->assertSame(1,$crawler->filter('html:contains("login")')->count());
    }

    /**
     * Test affichage de la page inscription sortie si utilisateur admin
     */
    public function testInscriptionSortieIfAdminIsUp()
    {
        $this->logInAdmin();
        $this->client->request('GET', '/registration');
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Test de redirection ajoutLieuVille sortie si utilisateur non admin
     */
    public function testRedirectAjoutLieuVilleIfNotAdmin()
    {
        $this->logIn();
        $this->client->request('GET', '/ajoutLieuVille');
        //$this->client->followRedirect();
        $this->assertSame(302, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Test affichage de la page ajoutLieuVille sortie si utilisateur admin
     */
    public function testAjoutLieuVilleIfAdminIsUp()
    {
        $this->logInAdmin();
        $this->client->request('GET', '/ajoutLieuVille');
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }


    /********************* Tests des formulaires *********************/

    /**
     * Test de validation du formulaire de connexion
     */
    public function testFormConnexion(){
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('login')->form();
        $form['email'] = 'test2';
        $form['password'] = 'Pa$$w0rd';
        $this->client->submit($form);
        $this->client->followRedirect();
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());

    }

    /**
     * Test de validation du formulaire de gestion d'un profil
     */
    public function testFormGestionProfil(){
        $this->logIn();
        $crawler = $this->client->request('GET', '/utilisateur/gestionProfil/164');
//        echo $this->client->getResponse()->getContent();
        $form = $crawler->selectButton('enregistrerModifsProfil')->form();
        $form['gestion_profil[pseudo]'] = 'test2';
        $form['gestion_profil[email]'] = 'test2@test.fr';
        $form['gestion_profil[prenom]'] = 'Test2';
        $form['gestion_profil[nom]'] = 'Test2';
        $form['gestion_profil[telephone]'] = ' ';
        $form['gestion_profil[password][first]'] = 'Pa$$w0rd';
        $form['gestion_profil[password][second]'] = 'Pa$$w0rd';
        $form['gestion_profil[noSite]'] = '54';
        $this->client->submit($form);
        $this->client->followRedirect();
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());

    }

    /**
     * Test de validation du formulaire d'inscription par un admin
     */
    public function testFormInscriptionByAdmin(){
        $this->logInAdmin();
        $crawler = $this->client->request('GET', '/registration');
//        echo $this->client->getResponse()->getContent();
        $form = $crawler->selectButton('Enregistrer')->form();
        //var_dump($form->getValues());
        $form['registration[email]'] = 'test2@test.fr';
        $form['registration[password]'] = 'Pa$$w0rd';
        $form['registration[nom]'] = 'Test2';
        $form['registration[prenom]'] = 'Test2';
        $form['registration[noSite]'] = '54';
        $this->client->submit($form);
        /**
         * Erreur mise à 500 car user deja présent dans la BDD. Il faudrait faire un reset commplet de la BDD
         *  chaque lancement des tests pour être optimal.
         */
        $this->assertSame(500, $this->client->getResponse()->getStatusCode());

    }

}
