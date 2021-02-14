<?php

namespace Tests\Factory;

use AppBundle\Entity\Dinosaur;
use AppBundle\Factory\DinosaurFactory;
use AppBundle\Service\DinosaurLengthDeterminator;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DinosaurFactoryTest extends KernelTestCase
{
    /** @var DinosaurFactory */
    private $factory;

    /** @var MockObject */
    private $lengthDeterminator;

    public function setUp(): void
    {
        $this->lengthDeterminator = $this->createMock(DinosaurLengthDeterminator::class);
        $this->factory = new DinosaurFactory($this->lengthDeterminator);
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
     *
     * @param string $spec
     * @param bool   $expectedCarnivorous
     */
    public function testItGrowsADinosaurFromASpecification(string $spec, bool $expectedCarnivorous)
    {
        $this->lengthDeterminator->method('getLengthFromSpecification')
            ->willReturn(20);
        $dino = $this->factory->growFromSpecification($spec);
        $this->assertSame($expectedCarnivorous, $dino->isCarnivorous());
        $this->assertSame(20, $dino->getLength());

    }

    public function getSpecificationTests()
    {
        return [
            ['large carnivorous dinosaur', true],
            ['give me all the cookies!!!', false],
            ['large herbivore', false],
        ];
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