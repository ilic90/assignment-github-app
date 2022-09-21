<?php

namespace App\Interface;

interface WordPopularityProviderInterface
{
    public function getName(): string;

    public function setWord(string $word): void;

    public function getCount(): int;
}