<?php

namespace App\Request;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class GetScoreQueryParams
{
    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 2,
        max: 100
    )]
    private $term;

    public function __construct(Request $request)
    {
        $this->setTerm((string) $request->query->get('term'));
    }

    public function getTerm()
    {
        return $this->term;
    }

    public function setTerm(string $term)
    {
        $this->term = $term;
    }
}