<?php

declare(strict_types=1);

namespace Psalm\Coverage;

class CoverageReport
{
    protected static self $instance;

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
}
