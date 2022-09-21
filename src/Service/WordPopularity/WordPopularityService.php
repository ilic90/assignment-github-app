<?php

namespace App\Service\WordPopularity;

use App\Interface\WordPopularityProviderInterface;
use App\Repository\WordPopularityRepository;
use App\Entity\WordPopularity;
use App\Enum\WordPopularitySuffix;
use App\Exception\WordPopularityServiceException;
use DateTime;

class WordPopularityService
{
    private WordPopularityProviderInterface $provider;
    private WordPopularityRepository $wordPopularityRepository;
    private ?string $word = null;

    public function __construct(WordPopularityProviderInterface $provider, WordPopularityRepository $wordPopularityRepository)
    {
        $this->provider = $provider;
        $this->wordPopularityRepository = $wordPopularityRepository;
    }

    public function setWord(string $word): void
    {
        $this->word = $word;
    }

    public function getPopularityScore(): float
    {
        if(is_null($this->word)) {
            throw new WordPopularityServiceException('Missing word for popularity score service');
        }

        $wordPopularity = $this->getWordPopularityEntity();

        $positiveCount = $wordPopularity->getPositiveCount();
        $negativeCount = $wordPopularity->getNegativeCount();
        $score = $positiveCount / ($positiveCount + $negativeCount) * 100;

        return round($score, 2);
    }

    private function getPositiveCount(): int
    {
        $positiveWord = $this->word . " " . WordPopularitySuffix::Positive->value;

        $this->provider->setWord($positiveWord);

        return $this->provider->getCount();
    }

    private function getNegativeCount(): int
    {
        $negativeWord = $this->word . " " . WordPopularitySuffix::Negative->value;

        $this->provider->setWord($negativeWord);

        return $this->provider->getCount();
    }

    private function createNewWordPopularityEntity()
    {
        $wordPopularity = new WordPopularity();

        $wordPopularity->setProvider($this->provider->getName());
        $wordPopularity->setWord($this->word);
        $wordPopularity->setPositiveCount($this->getPositiveCount());
        $wordPopularity->setNegativeCount($this->getNegativeCount());
        $wordPopularity->setLastTimeFetched(new DateTime());

        $this->wordPopularityRepository->add($wordPopularity, true);

        return $wordPopularity;
    }

    private function getWordPopularityEntity(): WordPopularity
    {
        $wordPopularity = $this->wordPopularityRepository->findOneByWordAndProvider(
            $this->word, 
            $this->provider->getName()
        );

        if(is_null($wordPopularity)) {
            return $this->createNewWordPopularityEntity();
        }

        $now = new DateTime();
        $diffInDays = $now->diff($wordPopularity->getLastTimeFetched())->days;

        if($diffInDays > 0) {
            $wordPopularity->setPositiveCount($this->getPositiveCount());
            $wordPopularity->setNegativeCount($this->getNegativeCount());
            $wordPopularity->setLastTimeFetched(new DateTime());

            $this->wordPopularityRepository->add($wordPopularity, true);
        }

        return $wordPopularity;
    }
}