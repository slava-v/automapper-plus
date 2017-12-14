<?php

namespace spec\AutoMapperPlus\Configuration;

use AutoMapperPlus\Configuration\Options;
use AutoMapperPlus\MapperInterface;
use AutoMapperPlus\MappingOperation\MappingOperationInterface;
use AutoMapperPlus\NameConverter\NamingConvention\NamingConventionInterface;
use AutoMapperPlus\NameResolver\NameResolverInterface;
use AutoMapperPlus\PropertyAccessor\PropertyAccessorInterface;
use PhpSpec\ObjectBehavior;

class OptionsSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Options::class);
    }

    function it_can_be_initialized_with_default_values()
    {
        $this->beConstructedThrough('default');
        $this->shouldHaveType(Options::class);
    }

    function it_can_have_a_source_member_naming_convention
    (
        NamingConventionInterface $namingConvention
    )
    {
        $this->setSourceMemberNamingConvention($namingConvention);
        $this->getSourceMemberNamingConvention()->shouldBe($namingConvention);
    }

    function it_can_have_a_destination_member_naming_convention
    (
        NamingConventionInterface $namingConvention
    )
    {
        $this->setDestinationMemberNamingConvention($namingConvention);
        $this->getDestinationMemberNamingConvention()->shouldBe($namingConvention);
    }

    function it_knows_when_names_have_to_be_converted
    (
        NamingConventionInterface $sourceNamingConvention,
        NamingConventionInterface $destinationNamingConvention
    )
    {
        // Without any naming conventions set, the output should be false.
        // Note: callOnWrappedObject has to be used to prevent PHPSpec from
        // using it as a matcher, which throws errors.
        $this->callOnWrappedObject('shouldConvertName')->shouldBe(false);

        // With only one naming convention set, we still shouldn't be
        // converting names.
        $this->setSourceMemberNamingConvention($sourceNamingConvention);
        $this->callOnWrappedObject('shouldConvertName')->shouldBe(false);

        // Finally, with both conventions set, we will have to convert names.
        $this->setDestinationMemberNamingConvention($destinationNamingConvention);
        $this->callOnWrappedObject('shouldConvertName')->shouldBe(true);
    }

    function it_can_set_constructor_skipping_via_an_explicit_setter()
    {
        $this->setShouldSkipConstructor(true);
        $this->callOnWrappedObject('shouldSkipConstructor')->shouldBeTrue();

        $this->setShouldSkipConstructor(false);
        $this->callOnWrappedObject('shouldSkipConstructor')->shouldBeFalse();
    }

    function it_has_a_default_value_for_skipping_the_constructor()
    {
        $this->callOnWrappedObject('shouldSkipConstructor')->shouldBeBoolean();
    }

    function it_can_set_constructor_skipping_via_semantic_methods()
    {
        $this->dontSkipConstructor();
        $this->callOnWrappedObject('shouldSkipConstructor')->shouldBeFalse();

        $this->skipConstructor();
        $this->callOnWrappedObject('shouldSkipConstructor')->shouldBeTrue();
    }

    function it_can_have_a_property_accessor(PropertyAccessorInterface $propertyAccessor)
    {
        $this->setPropertyAccessor($propertyAccessor);
        $this->getPropertyAccessor()->shouldBe($propertyAccessor);
    }

    function it_can_have_a_default_mapping_operation(MappingOperationInterface $mappingOperation)
    {
        $this->setDefaultMappingOperation($mappingOperation);
        $this->getDefaultMappingOperation()->shouldBe($mappingOperation);
    }

    function it_can_have_a_name_resolver(NameResolverInterface $nameResolver)
    {
        $this->setNameResolver($nameResolver);
        $this->getNameResolver()->shouldBe($nameResolver);
    }

    function it_can_have_a_custom_mapper(MapperInterface $mapper)
    {
        $this->setCustomMapper($mapper);
        $this->getCustomMapper()->shouldBe($mapper);
    }

    function it_provides_a_way_to_check_if_a_custom_mapper_is_set(MapperInterface $mapper)
    {
        $this->providesCustomMapper()->shouldBeFalse();
        $this->setCustomMapper($mapper);
        $this->providesCustomMapper()->shouldBeTrue();
    }
}
