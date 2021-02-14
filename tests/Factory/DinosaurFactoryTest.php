<?php

namespace Tests\Factory;

use AppBundle\Entity\Dinosaur;
use AppBundle\Factory\DinosaurFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DinosaurFactoryTest extends KernelTestCase
{
    /** @var DinosaurFactory */
    private $factory;

    public function setUp(): void
    {
        $this->factory = new DinosaurFactory();
    }

    protected function tearDown(): void
    {
        $this->factory = null;
    }

    public function testItGrowsAVelociraptor()
    {
        $dino = $this->factory->growVelociraptor(5);
        $this->assertInstanceOf(Dinosaur::class, $dino);
        $this->assertIsString($dino->getGenus());
        $this->assertSame('Velociraptor', $dino->getGenus());
        $this->assertSame(5, $dino->getLength());
    }

    public function testItGrowsATriceratops()
    {
        $this->markTestIncomplete();
        $dino = $this->factory->growVelociraptor(5);
        $this->assertInstanceOf(Dinosaur::class, $dino);
        $this->assertIsString($dino->getGenus());
        $this->assertSame('Velociraptor', $dino->getGenus());
        $this->assertSame(5, $dino->getLength());
    }


    public function testItGrowsABabyVelociraptor()
    {
        if (!class_exists('Nanny'))
        {
            $this->markTestSkipped('No nanny to look after!');
        }

        $dino = $this->factory->growVelociraptor(1);
        $this->assertSame(1, $dino->getLength());
    }

    /**
     * @dataProvider getSpecificationTests
     * @param string $spec
     * @param bool   $expectedLarge
     * @param bool   $expectedCarnivorous
     */
    public function testItGrowsADinosaurFromASpecification(string $spec, bool $expectedLarge, bool $expectedCarnivorous)
    {
        $dino = $this->factory->growFromSpecification($spec);

        if ($expectedLarge)
        {
            $this->assertGreaterThanOrEqual(Dinosaur::LARGE, $dino->getLength());
        }
        else
        {
            $this->assertLessThan(Dinosaur::LARGE, $dino->getLength());
        }
        $this->assertSame($expectedCarnivorous, $dino->isCarnivorous());

    }

    public function getSpecificationTests()
    {
        return [
            ['large carnivorous dinosaur', true, true],
            ['give me all the cookies!!!', false, false],
            ['large herbivore', true, false],
        ];
    }

    /**
     * @dataProvider getHugeSpecificationTests
     * @param string $spec
     */
    public function testItGrowsAHugeDino(string $spec)
    {
        $dino = $this->factory->growFromSpecification($spec);

        $this->assertGreaterThanOrEqual(Dinosaur::HUGE, $dino->getLength());
    }


    public function getHugeSpecificationTests()
    {
        return [
            ['huge dinosaur'],
            ['huge dino'],
            ['huge'],
            ['OMG'],
            ['😱'],
        ];
    }
}