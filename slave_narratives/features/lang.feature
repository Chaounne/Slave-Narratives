Feature: Change language

  Scenario Outline: The site strings are changed to english ones
    Given I am on the about page
    When I press the language button
    Then Each links should have the correct text: "<text>"
    Examples:
      | text |
      | Home |
      | List of narratives |
      | Administration |
      | About |
      | Contact |

  Scenario Outline: The site strings are changed to french ones
    Given I am on the about page
    When I press the language button
    And I press the language button again
    Then Each links should have the correct text: "<text>"
    Examples:
      | text |
      | Accueil |
      | Liste des récits |
      | Administration |
      | À propos |
      | Contact |
