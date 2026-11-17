<?php
/**
 * Copyright © 2026 Roman Pasichnyk
 * SPDX-License-Identifier: OSL-3.0 OR AFL-3.0
 */
declare(strict_types=1);

namespace Zero\ReviewsAiAssistant\Test\Unit\Model\Tool;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Zero\AiAssistant\Model\Tool\ToolInterface;
use Zero\ReviewsAiAssistant\Model\Tool\ListReviews;
use Zero\ReviewsAiAssistant\Model\Tool\ModerateReviews;

/**
 * The review tools keep their names, ACL resources, areas and "changes" flags when they move to this bridge:
 * the role's saved ACL rules, the stored proposals and Claude's tool list depend on them.
 */
class ToolsContractTest extends TestCase
{
    /**
     * @return array<string, array{0: class-string<ToolInterface>, 1: string, 2: string, 3: bool}>
     */
    public static function tools(): array
    {
        return [
            'list_reviews' => [ListReviews::class, 'list_reviews', 'Magento_Review::reviews_all', false],
            'moderate_reviews' => [ModerateReviews::class, 'moderate_reviews', 'Magento_Review::pending', true],
        ];
    }

    #[DataProvider('tools')]
    public function testNameResourceAreaAndChanges(string $class, string $name, string $resource, bool $changes): void
    {
        $arguments = [];
        foreach ((new \ReflectionClass($class))->getConstructor()?->getParameters() ?? [] as $parameter) {
            $arguments[] = $this->createStub((string) $parameter->getType());
        }
        /** @var ToolInterface $tool */
        $tool = new $class(...$arguments);

        $this->assertSame($name, $tool->name());
        $this->assertSame($resource, $tool->resource());
        $this->assertSame('reviews', $tool->area());
        $this->assertSame($changes, $tool->changes());
    }

    public function testTheToolsNeedNoObjectManager(): void
    {
        foreach (self::tools() as [$class]) {
            foreach ((new \ReflectionClass($class))->getConstructor()?->getParameters() ?? [] as $parameter) {
                $this->assertStringNotContainsString('ObjectManager', (string) $parameter->getType(), $class);
            }
        }
    }
}
