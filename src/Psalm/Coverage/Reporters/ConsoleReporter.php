<?php

declare(strict_types=1);

namespace Psalm\Coverage\Reporters;

use Desilva\Console\Console;
use Psalm\Coverage\TypeCoverage;

class ConsoleReporter implements TypeCoverageReportInterface
{
    protected TypeCoverage $coverage;
    protected Console $console;

    public function __construct(TypeCoverage $coverage)
    {
        $this->coverage = $coverage;
        $this->console = new Console();
    }

    public function __invoke(): void
    {
        // TODO: Implement __invoke() method.
    }
}
