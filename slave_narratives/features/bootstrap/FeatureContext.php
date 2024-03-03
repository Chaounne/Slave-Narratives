<?php

use Behat\Behat\Context\Context;
use Features\Bootstrap\AuthenticationManager;
use Goutte\Client;
use PHPUnit\Framework\Assert;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Defines application features from the specific context.
 */
const localhost_url = 'http://localhost/slave_narratives';

class FeatureContext implements Context
{
    private Client $client;
    private AuthenticationManager $authenticationManager;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->authenticationManager = new AuthenticationManager();
        $this->client = new Client();
    }

    //1st scenario

    /**
     * @Given I'm on the login page
     */
    public function loginPage(): Crawler
    {
        return $this->client->request('GET', localhost_url.'/admin/login');
    }

    /**
     * @When I enter my correct username and password
     */
    public function correctLogin(): void
    {
        $result = $this->authenticationManager->login('recits-esclaves@univ-tlse2.fr', 'admin');
        Assert::assertTrue($result, 'Successful login for the correct username and password');
    }

    /**
     * @When I click on the login button
     */
    public function loginButtonClick(): void
    {
        $crawler = $this->loginPage();
        $form = $crawler->selectButton('Connexion')->form();
        $this->client->submit($form);
    }

    /**
     * @Then I should be redirected to the administration page
     */
    public function redirectedToAdminPage(): void
    {
        $crawler = $this->client->getCrawler();
        $url = $crawler->getUri();
        Assert::assertStringContainsString(localhost_url.'/admin', $url, 'Unexpected redirection URL');
    }

    //2nd scenario

    /**
     * @When I enter the correct email address
     */
    public function correctMail(): void
    {
        $this->authenticationManager->setUsername('recits-esclaves@univ-tlse2.fr');
        Assert::assertTrue($this->authenticationManager->verifyUsername(),'Unexpected username');
    }

    /**
     * @When I enter an incorrect password
     */
    public function enterWrongPassword(): void
    {
        $this->authenticationManager->setPassword('administrateur');
        Assert::assertFalse($this->authenticationManager->verifyPassword(), 'Good password');
    }

    /**
     * @Then I should see a login error message
     */
    public function loginErrorMessage(): void
    {
        $username = $this->authenticationManager->getUsername();
        $password = $this->authenticationManager->getPassword();

        $result = $this->authenticationManager->login($username, $password);
        $error = $this ->authenticationManager->getLoginError();

        Assert::assertFalse($result, $error);
    }

    // 3rd scenario

    /**
     * @Given I'm logged in as administrator
     */
    public function loggedInAdmin(): void
    {
        $this->authenticationManager->setUsername("recits-esclaves@univ-tlse2.fr");
        $this->authenticationManager->setPassword("admin");

        Assert::assertTrue($this->authenticationManager->verifyUsername(),"Unexpected username");
        Assert::assertTrue($this->authenticationManager->verifyPassword(), "Unexpected password");

        $this->authenticationManager->login("recits-esclaves@univ-tlse2.fr", "admin");

        Assert::assertTrue($this->authenticationManager->isLoggedIn(), "Failed to log in as administrator");
    }

    /**
     * @When I disconnect
     */
    public function disconnectButton(): void
    {
        $this->authenticationManager->logout();
    }

    /**
     * @Then I should be redirected to the login page
     */
    public function redirectedToLoginPage(): void
    {
        Assert::assertFalse($this->authenticationManager->isLoggedIn(), "Still logged in after logout");

        $this->client->request('GET', localhost_url."/admin");
        $crawler = $this->client->getCrawler();
        $url = $crawler->getUri();
        $expectedUrl = localhost_url."/admin/login";

        Assert::assertSame($expectedUrl, $url, "Unexpected redirection URL after logout");
    }

    // 4th scenario

    /**
     * @Given I click on the hyperlink
     */
    public function clickHyperlink(): void
    {
        $crawler = $this->loginPage();
        $link= $crawler->selectLink("Mot de passe oublié ?")->link();
        $this->client->click($link);
    }

    /**
     * @When I'm redirected to the forgotten password page
     */
    public function redirectedToForgettenPswdPage(): void
    {
        $currentUrl = $this->client->getRequest()->getUri();
        Assert::assertStringContainsString(localhost_url."/admin/forgotPassword", $currentUrl, "Unexpected redirection URL");
    }

    /**
     * @Then I should see a confirmation message
     */
    public function confirmationMessage(): void
    {
        $this->authenticationManager->passwordResetConfirmationMessage();
        $error = $this->authenticationManager->getConfirmationMessage();
        Assert::assertStringContainsString("Message de confirmation pour la réinitialisation du mot de passe", $error, 'Unexpected confirmation message');
    }

    // 5th scenario

    /**
     * @Given I am on the about page
     */
    public function aboutPage(): void
    {
        $this->client->request('GET', localhost_url);
    }

    /**
     * @When I press the language button
     */
    public function langButtonClick(): void
    {
        $crawler = $this->client->getCrawler();
        $link = $crawler->selectLink('FR/EN');
        Assert::assertNotEmpty($link, 'There should be a link');
        $this->client->click($link->link());
    }

    /**
     * @Then Each links should have the correct text: :arg1
     */
    public function linkIsCorrect(string $arg1): void
    {
        $crawler = $this->client->getCrawler();
        $link = $crawler->selectLink($arg1);
        Assert::assertNotEmpty($link, 'There should be a link');
        Assert::assertEquals($arg1, $link->text(), 'The language did not change');
    }

    // 6th scenario

    /**
     * @When I press the language button again
     */
    public function langButtonClickAgain(): void
    {
        $crawler = $this->client->getCrawler();
        $link = $crawler->selectLink('FR/EN');
        Assert::assertNotEmpty($link, 'There should be a link');
        $this->client->click($link->link());
    }
}