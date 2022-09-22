<?php

namespace App\Response;

class ScoreResponse
{
    public string $term;
    public float $score;

    public function __construct(string $term, float $score)
    {
        $this->term = $term;
        $this->score = $score;
    }
}