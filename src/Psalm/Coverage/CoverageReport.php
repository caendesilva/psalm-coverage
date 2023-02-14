<?php

declare(strict_types=1);

namespace Psalm\Coverage;

class CoverageReport
{
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
