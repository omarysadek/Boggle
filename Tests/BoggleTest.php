<?php

namespace OS\Tests;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;
use OS\Code\Boggle\Entity\Boggle;

class BoggleTest extends TestCase
{
    /**
     * @var Boggle
     */
    protected $boggle;

    /**
     * @var Symfony\Component\Console\Output\OutputInterface
     */
    protected $outputProphecy;

    /**
     * @var OS\Code\Boggle\Entity\Grid
     */
    protected $gridProhpecy;

    public function setup()
    {
        $this->gridProhpecy = $this->prophesize('OS\Code\Boggle\Entity\Grid');
        $this->outputProphecy = $this->prophesize('Symfony\Component\Console\Output\OutputInterface');

        $this->boggle = new Boggle(
            $this->gridProhpecy->reveal(),
            $this->outputProphecy->reveal()
        );
    }

    /**
     * @test
     * @group boggle
     */
    public function searchTrue()
    {
        $word = 'fortnite';

        $this->gridProhpecy->find($word)->willReturn(true)->shouldBeCalled(1);
        $this->outputProphecy->writeln(Argument::any())->shouldBeCalled(1);

        $this->assertTrue(
            $this->boggle->search($word)
        );
    }
}
