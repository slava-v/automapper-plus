<?php

namespace AutoMapperPlus\MappingOperation\Implementations;

use AutoMapperPlus\MappingOperation\DefaultMappingOperation;
use AutoMapperPlus\MappingOperation\MapperAwareOperation;
use AutoMapperPlus\MappingOperation\MapperAwareTrait;

/**
 * Class MapTo.
 *
 * Allows a property to be mapped itself.
 *
 * @package AutoMapperPlus\MappingOperation\Implementations
 */
class MapTo extends DefaultMappingOperation implements MapperAwareOperation
{
    use MapperAwareTrait;

    const COLLECTION_EXPECTED = true;
    const COLLECTION_NOT_EXPECTED = false;
    const COLLECTION_AUTO = null;

    /**
     * @var string
     */
    private $destinationClass;
    /**
     * @var bool
     */
    private $isCollectionExpected;

    /**
     * MapTo constructor.
     *
     * @param string $destinationClass
     * @param mixed   $isCollectionExpected - Has 3 possible values: NULL, FALSE, TRUE
     */
    public function __construct(string $destinationClass, $isCollectionExpected = null)
    {
        $this->destinationClass = $destinationClass;
        $this->isCollectionExpected = $isCollectionExpected;
    }

    /**
     * @return string
     */
    public function getDestinationClass(): string
    {
        return $this->destinationClass;
    }

    /**
     * @inheritdoc
     */
    protected function getSourceValue($source, string $propertyName)
    {
        $value = $this->getPropertyAccessor()->getProperty(
            $source,
            $this->getSourcePropertyName($propertyName)
        );

        if ($this->isCollectionExpected === null)
            return $this->isCollection($value)
                ? $this->mapper->mapMultiple($value, $this->destinationClass)
                : $this->mapper->map($value, $this->destinationClass);
        else {
            return $this->isCollectionExpected === true
                ? $this->mapper->mapMultiple($value, $this->destinationClass)
                : $this->mapper->map($value, $this->destinationClass);
        }
    }

    /**
     * Checks if the provided input is a collection.
     * @todo: might want to move this outside of this class.
     *
     * @param $variable
     * @return bool
     */
    private function isCollection($variable): bool
    {
        return is_array($variable) || $variable instanceof \Traversable;
    }
}
