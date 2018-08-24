<?php

namespace OS\Code\Boggle\Entity;

use OS\Code\Boggle\Entity\Grid;

class GridUtilities
{
    /**
     * @param int $gridSize
     *
     * @return Grid
     */
    public static function generate($gridSize)
    {
        $grid = [];
        for ($i=0; $i < $gridSize; $i++) {
            for ($j=0; $j < $gridSize; $j++) {
                $grid[$i][$j] = $letter = chr(rand(97, 122));
            }
        }

        return new Grid($grid);
    }

    /**
     * @param string $gridContentAsString
     * @param int $gridSize
     *
     * @return Grid
     */
    public static function strToGrid($gridContentAsString, $gridSize)
    {
        $grid = [];

        $lines = explode('|', $gridContentAsString);
        if (sizeof($lines) !== $gridSize) {
            throw new \RuntimeException('Invalid grid size, number of lines');
        }

        $i = 0;
        foreach ($lines as $line) {
            if (strlen($line) !== $gridSize) {
                throw new \RuntimeException('Invalid grid size, number of letters');
            }

            $j = 0;
            $lineAsArray = str_split($line);
            foreach ($lineAsArray as $letter) {
                if (!ctype_alpha($letter)) {
                    throw new \RuntimeException('Invalid letter, only letters from a to z are allowed');
                }
                $grid[$i][$j] = strtolower($letter);
                $j++;
            }
            $i++;
        }

        return new Grid($grid);
    }
}
