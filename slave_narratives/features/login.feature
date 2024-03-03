Feature: Secure log-in to back office as administrator

  Scenario: Successful login with correct information
    Given I'm on the login page
    When I enter my correct username and password
    And I click on the login button
    Then I should be redirected to the administration page

  Scenario: Login failure with incorrect password
    Given I'm on the login page
    When I enter the correct email address
    And I enter an incorrect password
    And I click on the login button
    Then I should be redirected to the login page
    And I should see a login error message

  Scenario: Secure logout
    Given I'm logged in as administrator
    When I disconnect
    Then I should be redirected to the login page

  Scenario: Password forgotten
    Given I'm on the login page
    And I click on the hyperlink
    When I'm redirected to the forgotten password page
    And I enter the correct email address
    Then I should see a confirmation message
