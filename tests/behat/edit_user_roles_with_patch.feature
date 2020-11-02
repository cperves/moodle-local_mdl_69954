@local_mdl_69954
Feature: Edit user roles
  In order to manage students' enrolments
  As a teacher
  I need to change user enrolments without loosing remote enrolments

  Background:
    Given the following "users" exist:
      | username  | firstname | lastname | email                 |
      | teacher1  | Teacher   | 1        | teacher1@example.com  |
      | student1  | Student   | 1        | student1@example.com  |
    And the following "courses" exist:
      | fullname | shortname | format |
      | Course 1 | C1        | topics |
    And the following "course enrolments" exist:
      | user      | course | role           |
      | teacher1  | C1     | editingteacher |
      | student1  | C1     | student        |

  @javascript
  Scenario: Change student to teacher
    Given I log in as "teacher1"
    And I am on "Course 1" course homepage
    And I navigate to course participants
    And I click on "Student 1's role assignments" "link"
    And I click on ".form-autocomplete-selection [aria-selected=true]" "css_element"
    And I press key "27" in the field "Student 1's role assignments"
    And I click on ".form-autocomplete-downarrow" "css_element" in the "student1" "table_row"
    And I click on "Non-editing teacher" item in the autocomplete list
    And I press key "27" in the field "Student 1's role assignments"
    And I click on "Save changes" "link"
    And I should see "Non-editing teacher" in the "Student 1" "table_row"
    And I am on "Course 1" course homepage
    And I navigate to "MDL-69954 management" node in "Course administration"
    And I should see "student1" in the "student1" "table_row"
    And I should see "1" in the "student1" "table_row"