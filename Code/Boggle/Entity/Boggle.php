<?php

namespace OS\Code\Boggle\Entity;

use Symfony\Component\Console\Output\OutputInterface;
use OS\Code\Boggle\Interfaces\GridSearchInterface;

class Boggle
{
    /**
     * @var GridSearchInterface
     */
    private $grid;

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @var GridSearchInterface $grid
     * @var OutputInterface $output
     */
    public function __construct(GridSearchInterface $grid, OutputInterface $output)
    {
        $this->grid = $grid;
        $this->output = $output;
    }

    /**
     * @var string $word
     */
    public function search($word)
    {
        if ($this->grid->find($word)) {
            $this->output->writeln($word . ' => true');
            return true;
        }

        $this->output->writeln($word . ' => false');
        return false;
    }

    public function display()
    {
        $this->output->writeln($this->grid->display());
    }
}
