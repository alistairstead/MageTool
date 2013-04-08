<?php

use Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;
use Symfony\Component\Process\Process;

require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';

/**
 * Console context.
 */
class ConsoleContext extends BehatContext
{
    /**
     * The output from the command
     *
     * @var string
     **/
    var $process;

    /**
     * @When /^I run command "([^"]*)"$/
     */
    public function iRunCommand($commandString)
    {
        $this->process = new Process($commandString);
        if ($this->process->run() != 0) {
            throw new \RuntimeException("Can't run $commandString" . $this->process->getErrorOutput());
        }
    }

    /**
     * @Then /^I should see$/
     */
    public function iShouldSee(PyStringNode $string)
    {
        if (strstr($this->process->getOutput(), (string) $string) === false) {
            throw new \RuntimeException($string . "\n\n not found in \n\n" . $this->process->getOutput());
        }
    }
}
