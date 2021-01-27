Feature:  User registration
  A visitor should be able to create a new
  account in the system.

  #@todo
  #@createSchema
  Scenario: A visitor can register.
    Given I am on "/registration"
    Then the response status code should be 200
    And I fill in "register_user_form_email" with "test_user@localdomain.local"
    And I fill in "register_user_form_password_first" with "test_user"
    And I fill in "register_user_form_password_second" with "test_user"
    And I press "register_user_form.register_user_submit.label"
    Then I should see "Sign in"