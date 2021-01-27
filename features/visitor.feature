Feature:  Visitor capabilities
  As unregister user I should be able to see
  the home page, the login page and
  the registration page

  Scenario: Home page is available for visitors
    Given I am on "/"
    Then I should see "Index page"

  Scenario: Login page is available for visitors
    Given I am on "/login"
    Then I should see "Please sign in"

  Scenario: Registration page is available for visitors
    Given I am on "/registration"
    Then I should see "Registration"
