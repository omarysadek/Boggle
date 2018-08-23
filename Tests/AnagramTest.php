<?php

namespace Tests;

use OS\Code\Anagram\WordsUtilities;
use PHPUnit\Framework\TestCase;

class AnagramTest extends TestCase
{
    /**
     * @test
     * @dataProvider getAnagramsProvider
     * @group anagram
     */
    public function getAnagrams($query, $words, $expected)
    {
        $wordsUtilities = new WordsUtilities($words);

        $result = $wordsUtilities->getAnagrams($query);

        sort($expected);
        sort($result);

        $this->assertEquals($expected, $result);
    }

    public function getAnagramsProvider()
    {
        return [
            [
                'query' => 'abc',
                'words' => [ 'cbd', 'dbc' ],
                'expected' => []
            ],
            [
                'query' => 'trees',
                'words' => [ 'tumblr', 'terse', 'rest', 'tears', 'steer', 'street' ],
                'expected' => ['steer', 'terse']
            ]
        ];
    }
}
