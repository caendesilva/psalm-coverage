<?php

declare(strict_types=1);

namespace Psalm\Coverage;

use Psalm\Coverage\Reporters\ConsoleReporter;

class TypeCoverage
{
    /** @var array<class-string<\Psalm\Coverage\Reporters\TypeCoverageReportInterface>> */
    public static array $reporters = [
        ConsoleReporter::class,
    ];

    protected static self $instance;

    /** @var array<string, FileCoverageData> */
    protected array $fileCoverageData = [];

    protected function __construct()
    {
        //
    }

    public static function getInstance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function addFile(FileCoverageData $file): void
    {
        self::getInstance()->fileCoverageData[$file->getPath()] = $file;
    }
}
