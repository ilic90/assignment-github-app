<?php

namespace App\Service\WordPopularity\Providers;

use App\Interface\WordPopularityProviderInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Exception\GithubProviderException;

class GithubProvider implements WordPopularityProviderInterface
{
    private ?string $word = null;
    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient->withOptions([
            'base_uri' => 'https://api.github.com',
        ]);
    }

    public function getName(): string
    {
        return 'github';
    }

    public function setWord(string $word): void
    {
        $this->word = $word;
    }

    public function getCount(): int
    {
        $response = $this->httpClient->request(
            'GET',
            '/search/issues',
            [
                'query' => [
                    'q' => $this->word
                ]
            ]
        );
        
        $statusCode = $response->getStatusCode();

        if($statusCode == 200) {
            return $response->toArray()['total_count'];
        }

        throw new GithubProviderException("Github provider failed with status code: {$statusCode}");
    }
}