<?php

namespace OS\Tests;

use PHPUnit\Framework\TestCase;
use OS\Code\Boggle\Entity\Grid;
use OS\Code\Boggle\Entity\GridUtilities;

class GridTest extends TestCase
{
    /**
     * @test
     * @dataProvider findDataProvider
     * @group boggle
     */
    public function find($grid, $words)
    {
        foreach ($words as $word => $expectedValue) {
            $this->assertEquals($expectedValue,  $grid->find($word));
        }
    }

    public function findDataProvider()
    {

        return [
            [
                //a r t y
                //e a o n
                //y s t d
                //e c i c
                'gridArray' => GridUtilities::strToGrid('ARTY|EAON|YSTD|ECIC', 4),
                'words' => ['arty' => true, 'tony' => true, 'notice' => true, 'year' => true, 'stand' => false, 'party' => false, 'stick' => false]
            ],
            [
                //a r t t t
                //e a o t t
                //y s t t t
                //e c i t t
                //e c i t t
                'gridArray' => GridUtilities::strToGrid('arttt|eaott|ysttt|ecitt|ecitt', 5),
                'words' => ['artttttttticeeyeaottticst' => true]
            ],
            [
                //a r
                //e a
                'gridArray' => GridUtilities::strToGrid('ar|ea', 2),
                'words' => [
                    'araea' => false,
                    'arr' => false,
                    'arae' => true
                ]
            ]
        ];
    }
}
