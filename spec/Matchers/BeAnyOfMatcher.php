<?php

namespace spec\Matchers;

use PhpSpec\Exception\Example\FailureException;
use PhpSpec\Matcher\BasicMatcher;

/**
 * Class BeAnyOf
 *
 * @package spec\Matchers
 */
class BeAnyOfMatcher extends BasicMatcher
{
    /**
     * @inheritdoc
     */
    public function supports(string $name, $subject, array $arguments): bool
    {
        return $name === 'beAnyOf' && !empty($arguments);
    }

    /**
     * @inheritdoc
     */
    protected function matches($subject, array $arguments): bool
    {
        return in_array($subject, $arguments);
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
        return new FailureException(
            'The return value should be one of [' . implode(',', $arguments) . '].'
        );
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
        return new FailureException(
            'The return value should not be one of [' . implode(',', $arguments) . '].'
        );
    }
}
