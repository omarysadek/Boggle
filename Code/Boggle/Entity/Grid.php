<?php

namespace OS\Code\Boggle\Entity;

use OS\Code\Boggle\Interfaces\GridSearchInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Grid implements GridSearchInterface
{
    /**
     * @var array
     */
    private $grid;

    /**
     * @var array
     */
    private $indexedGrid;

    /**
     * @var array
     */
    private $usedGrid;

    /**
     * @var bool
     */
    private $findResult;

    /**
     * @param array $grid
     */
    public function __construct($grid)
    {
        $this->grid = $grid;
        $this->index();
    }

    public function index()
    {
        $gridSize = sizeof($this->grid);

        for ($i=0; $i < $gridSize; $i++) {
            for ($j=0; $j < $gridSize; $j++) {
                $letter = $this->grid[$i][$j];
                $this->indexedGrid[$letter][] = ['x' => $i, 'y' => $j];
            }
        }
    }

    /**
     * @param string $letters
     * @param int $x
     * @param int $y
     * @param array $usedGrid
     */
    private function findNextLetter($letters, $x, $y, $usedGrid)
    {
        $firstLetter = $this->takeOffFirstElm($letters);

        if ($this->isThereAndNotALreadyUsed($x+1, $y, $firstLetter, $usedGrid)) {
            if (empty($letters)) {
                $this->findResult = true;
            }
            $usedGrid[$x][$y] = true;
            $this->findNextLetter($letters, $x+1, $y, $usedGrid);
        }
        if ($this->isThereAndNotALreadyUsed($x, $y+1, $firstLetter, $usedGrid)) {
            if (empty($letters)) {
                $this->findResult = true;
            }
            $usedGrid[$x][$y] = true;
            $this->findNextLetter($letters, $x, $y+1, $usedGrid);
        }
        if ($this->isThereAndNotALreadyUsed($x-1, $y, $firstLetter, $usedGrid)) {
            if (empty($letters)) {
                $this->findResult = true;
            }
            $usedGrid[$x][$y] = true;
            $this->findNextLetter($letters, $x-1, $y, $usedGrid);
        }
        if ($this->isThereAndNotALreadyUsed($x, $y-1, $firstLetter, $usedGrid)) {
            if (empty($letters)) {
                $this->findResult = true;
            }
            $usedGrid[$x][$y] = true;
            $this->findNextLetter($letters, $x, $y-1, $usedGrid);
        }
    }

    /**
     * @param int $x
     * @param int $y
     * @param string $letter
     * @param array $usedGrid
     *
     * @return bool
     */
    private function isThereAndNotALreadyUsed($x, $y, $letter, $usedGrid)
    {
        return (isset($this->grid[($x)][($y)]) && ($this->grid[($x)][($y)] === $letter) && (!isset($usedGrid[$x][$y])));
    }

    /**
     * @var string $word
     *
     * @return bool
     */
    public function find($word)
    {
        $letters = str_split($word);
        $this->findResult = false;

        $firstLetter = $this->takeOffFirstElm($letters);

        if (!isset($this->indexedGrid[$firstLetter])) {
            return false;
        }

        foreach ($this->indexedGrid[$firstLetter] as $indexedGridFirstLetter) {
            $x = $indexedGridFirstLetter['x'];
            $y = $indexedGridFirstLetter['y'];
            $usedGrid = [];
            $usedGrid[$x][$y] = true;
            $this->findNextLetter($letters, $x, $y, $usedGrid);
        }

        return $this->findResult;
    }

    /**
     * @param array &$array
     *
     * @return array
     */
    private function takeOffFirstElm(&$array)
    {
        if (empty($array)) {
            return;
        }
        $firstElem = $array[0];
        unset($array[0]);
        $array = array_values($array);

        return $firstElem;
    }

    /**
     * @return string
     */
    public function display()
    {
        $gridAsString = '';
        $gridSize = sizeof($this->grid);

        for ($i=0; $i < $gridSize; $i++) {
            $gridAsString .= implode(' ', $this->grid[$i]) . PHP_EOL;
        }

        return $gridAsString;
    }
}
