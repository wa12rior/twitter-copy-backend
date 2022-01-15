<?php

namespace App\Test\Unit\Service\Receipt;

use App\Service\Receipt\AdditionalDataExtractionHandler;
use App\Tests\Utils\ReceiptBuilder;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers App\Service\Receipt\AdditionalDataExtractionHandler
 */
class AdditionalDataExtractionHandlerTest extends TestCase
{
    private AdditionalDataExtractionHandler $handler;

    protected function setUp(): void
    {
        $this->handler = new AdditionalDataExtractionHandler($this->createMock(EntityManagerInterface::class));
    }

    public function testShouldHandleExtraction(): void
    {
        $receipt = ReceiptBuilder::create()->build();

        $this->handler->handle($receipt);
    }
}
