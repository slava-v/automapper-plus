<?php

namespace spec\Matchers;

use PhpSpec\Exception\Example\FailureException;
use PhpSpec\Matcher\BasicMatcher;

/**
 * Class BeTrueMatcher
 *
 * @package spec\AutoMapperPlus\Matchers
 */
class BeTrueMatcher extends BasicMatcher
{
    /**
     * @inheritdoc
     */
    public function supports(string $name, $subject, array $arguments): bool
    {
        return $name === 'beTrue';
    }

    /**
     * @inheritdoc
     */
    protected function matches($subject, array $arguments): bool
    {
        return $subject === true;
    }

    /**
     * @inheritdoc
     */
    protected function getFailureException
    (
        string $name,
        $subject,
        array $arguments
    ): FailureException
    {
        return new FailureException(sprintf(
            'The return value should be true, %s returned.',
            $subject
        ));
    }

    /**
     * @inheritdoc
     */
    protected function getNegativeFailureException
    (
        string $name,
        $subject,
        array $arguments
    ): FailureException
    {
        return new FailureException(sprintf(
            'The return value should be false, %s returned.',
            $subject
        ));
    }
}
