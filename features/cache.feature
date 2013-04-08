Feature: Cache
  In order to interact with Magento Cache
  As a Developer
  I want a set of cache commands

  Scenario: list
    When I run command "bin/mt list"
    Then I should see
    """
    cache
      cache:clear       Clear Magento cache
      cache:disable     Disable Magento cache
      cache:enable      Enable Magento cache
      cache:flush       Flush Magento cache
      cache:status      View Magento cache status
    """

  Scenario: cache:clear
    Given I run command "bin/mt cache:clear"
    Then I should see
    """
    Success! Cache cleared.
    """

