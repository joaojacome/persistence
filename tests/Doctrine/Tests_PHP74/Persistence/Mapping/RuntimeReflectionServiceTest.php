<?php

declare(strict_types=1);

namespace Doctrine\Tests_PHP74\Persistence\Mapping;

use Doctrine\Common\Reflection\RuntimePublicReflectionProperty;
use Doctrine\Common\Reflection\TypedNoDefaultReflectionProperty;
use Doctrine\Persistence\Mapping\RuntimeReflectionService;
use PHPUnit\Framework\TestCase;
use ReflectionProperty;

/**
 * @group DCOM-93
 */
class RuntimeReflectionServiceTest extends TestCase
{
    /** @var RuntimeReflectionService */
    private $reflectionService;

    /** @var string */
    private string $typedNoDefaultProperty;
    /** @var string */
    private string $typedDefaultProperty = '';
    /** @var string */
    private $nonTypedNoDefaultProperty; // phpcs:ignore SlevomatCodingStandard.Classes.UnusedPrivateElements.UnusedProperty
    /** @var string */
    private $nonTypedDefaultProperty = ''; // phpcs:ignore SlevomatCodingStandard.Classes.UnusedPrivateElements.UnusedProperty

    /** @var string */
    public string $typedNoDefaultPublicProperty;
    /** @var string */
    public string $typedDefaultPublicProperty = '';
    /** @var string */
    public $nonTypedNoDefaultPublicProperty;
    /** @var string */
    public $nonTypedDefaultPublicProperty = '';

    protected function setUp() : void
    {
        $this->reflectionService = new RuntimeReflectionService();
    }

    public function testGetTypedNoDefaultReflectionProperty() : void
    {
        $reflProp = $this->reflectionService->getAccessibleProperty(self::class, 'typedNoDefaultProperty');
        self::assertInstanceOf(TypedNoDefaultReflectionProperty::class, $reflProp);
    }

    public function testGetTypedDefaultReflectionProperty() : void
    {
        $reflProp = $this->reflectionService->getAccessibleProperty(self::class, 'typedDefaultProperty');
        self::assertInstanceOf(ReflectionProperty::class, $reflProp);
        self::assertNotInstanceOf(TypedNoDefaultReflectionProperty::class, $reflProp);
    }

    public function testGetNonTypedNoDefaultReflectionProperty() : void
    {
        $reflProp = $this->reflectionService->getAccessibleProperty(self::class, 'nonTypedNoDefaultProperty');
        self::assertInstanceOf(ReflectionProperty::class, $reflProp);
    }

    public function testGetNonTypedDefaultReflectionProperty() : void
    {
        $reflProp = $this->reflectionService->getAccessibleProperty(self::class, 'nonTypedDefaultProperty');
        self::assertInstanceOf(ReflectionProperty::class, $reflProp);
        self::assertNotInstanceOf(TypedNoDefaultReflectionProperty::class, $reflProp);
    }

    public function testGetTypedPublicNoDefaultPropertyWorksWithGetValue() : void
    {
        $reflProp = $this->reflectionService->getAccessibleProperty(self::class, 'typedNoDefaultPublicProperty');
        self::assertInstanceOf(TypedNoDefaultReflectionProperty::class, $reflProp);
        self::assertNull($reflProp->getValue($this));
    }

    public function testGetTypedPublicDefaultPropertyWorksWithGetValue() : void
    {
        $reflProp = $this->reflectionService->getAccessibleProperty(self::class, 'typedDefaultPublicProperty');
        self::assertInstanceOf(ReflectionProperty::class, $reflProp);
        self::assertNotInstanceOf(TypedNoDefaultReflectionProperty::class, $reflProp);
    }

    public function testGetNonTypedPublicNoDefaultPropertyWorksWithGetValue() : void
    {
        $reflProp = $this->reflectionService->getAccessibleProperty(self::class, 'nonTypedNoDefaultPublicProperty');
        self::assertInstanceOf(RuntimePublicReflectionProperty::class, $reflProp);
        self::assertNull($reflProp->getValue($this));
    }

    public function testGetNonTypedPublicDefaultPropertyWorksWithGetValue() : void
    {
        $reflProp = $this->reflectionService->getAccessibleProperty(self::class, 'nonTypedDefaultPublicProperty');
        self::assertInstanceOf(RuntimePublicReflectionProperty::class, $reflProp);
    }
}
