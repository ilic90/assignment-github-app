<?php

namespace App\Entity;

use App\Repository\WordPopularityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WordPopularityRepository::class)]
class WordPopularity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $word = null;

    #[ORM\Column]
    private ?int $positive_count = null;

    #[ORM\Column]
    private ?int $negative_count = null;

    #[ORM\Column(length: 255)]
    private ?string $provider = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $last_time_fetched = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWord(): ?string
    {
        return $this->word;
    }

    public function setWord(string $word): self
    {
        $this->word = $word;

        return $this;
    }

    public function getPositiveCount(): ?int
    {
        return $this->positive_count;
    }

    public function setPositiveCount(int $positive_count): self
    {
        $this->positive_count = $positive_count;

        return $this;
    }

    public function getNegativeCount(): ?int
    {
        return $this->negative_count;
    }

    public function setNegativeCount(int $negative_count): self
    {
        $this->negative_count = $negative_count;

        return $this;
    }

    public function getProvider(): ?string
    {
        return $this->provider;
    }

    public function setProvider(string $provider): self
    {
        $this->provider = $provider;

        return $this;
    }

    public function getLastTimeFetched(): ?\DateTimeInterface
    {
        return $this->last_time_fetched;
    }

    public function setLastTimeFetched(\DateTimeInterface $last_time_fetched): self
    {
        $this->last_time_fetched = $last_time_fetched;

        return $this;
    }
}
