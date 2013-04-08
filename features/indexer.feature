Feature: Indexer
  In order to interact with Magento Indexer
  As a Developer
  I want a set of index commands

  Scenario: list
    When I run command "./bin/mt list"
    Then I should see
    """
    indexer
      indexer:mode      Set Magento indexer mode
      indexer:run       Run Magento indexer(s)
      indexer:status    Display the status of Magento indexe(s)
    """
