Feature: API de usuários

  Scenario: Get empty database
    Given I send "DELETE" to "/api/user" (200)
    When I send "GET" to "/api/user" (204)
    Then the response should be a JSON array with the following mandatory values

  Scenario: Create first entry
    Given I send "DELETE" to "/api/user" using rows (200)
    When I send "POST" to "/api/user" using rows (201)
      | id   | 1    |
      | name | User |
    When I send "GET" to "/api/user" (200)
    Then the response should be a JSON array with the following mandatory values
      | 1  | {"1":{"id":1,"name":"User"}} |

  Scenario: Delete specific entry
    Given I send "DELETE" to "/api/user" using rows (200)
    When I send "POST" to "/api/user" using rows (201)
      | id   | 1     |
      | name | User1 |
    And I send "POST" to "/api/user" using rows (201)
      | id   | 2     |
      | name | User2 |
    And I send "DELETE" to "/api/user/1" using rows (200)
    And I send "GET" to "/api/user" (200)
    Then the response should be a JSON array with the following mandatory values
      | 1  | {"2":{"id":2,"name":"User2"}} |