<?php 

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Service\WordPopularity\WordPopularityService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class GetScoreTest extends KernelTestCase
{
    private ?WordPopularityService $wordPopularityService = null;

    protected function setUp(): void
    {
        static::bootKernel();

        $this->wordPopularityService = static::$kernel->getContainer()->get(WordPopularityService::class);
    }

    public function testScoreIsFloat(): void
    {
        $word = "php";

        $this->wordPopularityService->setWord($word);
        $score = $this->wordPopularityService->getPopularityScore();

        $this->assertIsFloat($score);
    }
}