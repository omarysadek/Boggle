<?php

namespace OS\Code\Boggle\Interfaces;

interface GridSearchInterface
{
    public function index();

    /**
     * @var string $word
     */
    public function find($word);
}
