<?php

namespace OS\Code\Anagram;

class WordsUtilities
{
    /**
     * @var array
     */
    private $words;

    /**
     * @var array $words
     */
    public function __construct($words)
    {
        $this->words = $words;
    }

    /**
     * @param string $query
     *
     * @return array
     */
    public function getAnagrams($query)
    {
        $anagrams = [];
        $occuCountQuery = $this->occurrenceCountAsArray($query);

        $queryLen = strlen($query);
        foreach ($this->words as $word) {
            if ($queryLen !== strlen($word)) {
                continue;
            }

            $occuCountWord = $this->occurrenceCountAsArray($word);

            $errors = 0;
            foreach ($occuCountWord as $occuWord => $occuCount) {
                if (!isset($occuCountQuery[$occuWord]) || $occuCountQuery[$occuWord] !== $occuCount) {
                    $errors = 1;
                    break 1;
                }
            }

            if($errors) {
                continue;
            }

            $anagrams[] = $word;
        }

        return $anagrams;
    }

    /**
     * Count the occurance of each letter and return it as array
     * Exemple for "trees" will return ['t' => 1, 'r' => 1, 'e' => 2, 's' => 1]
     *
     * @param string $word
     *
     * @return array
     */
    public function occurrenceCountAsArray($word)
    {
        $wordAsUnicode = [];

        $queryAsArray = str_split(strtolower($word));
        foreach ($queryAsArray as $letter) {
            $wordAsUnicode[$letter] = isset($wordAsUnicode[$letter]) ? $wordAsUnicode[$letter] + 1 : 1;
        }

        return $wordAsUnicode;
    }
}
