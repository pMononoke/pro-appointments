Feature:  User account management
  A user should be able to manage own data,
  the account data,
  the personal data,
  the contact information data.


  @pending
  #@not-yet-implemented
  Scenario: A user can see own account data.
    Given I am loggedin as test-user
    And I am on account page
    #Then the response status code should be 200
    Then I should see "Account"

  @not-yet-implemented
  Scenario: A user can change the password.
    Given I am loggedin as test-user
    And I am on account page
    Then I should see "Change password" button

  @not-yet-implemented
  Scenario: A user can change the personal name.
    Given I am loggedin as test-user
    And I am on account page

  @not-yet-implemented
  Scenario: A user can change the contact data - email.
    Given I am loggedin as test-user
    And I am on account page

  @not-yet-implemented
  Scenario: A user can change the contact data - mobile number.
    Given I am loggedin as test-user
    And I am on account page
