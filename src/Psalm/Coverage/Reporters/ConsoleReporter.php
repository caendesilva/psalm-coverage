<?php

declare(strict_types=1);

namespace Psalm\Coverage\Reporters;

use Desilva\Console\Console;
use Psalm\Coverage\FileCoverageData;
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
        $this->printDivider();
        $this->printHeader();

        foreach ($this->coverage->getFileCoverageData() as $file) {
            $this->console->line($this->formatFileInfo($file));
        }
    }

    protected function printDivider(): void
    {
        $this->console->newline();
        $this->console->line('----------------------------');
    }

    protected function printHeader(): void
    {
        $this->console->newline();
        $this->console->line("===\033[33m Type Coverage Report \033[0m===");
        $this->console->newline();
    }

    protected function formatFileInfo(FileCoverageData $file): string
    {
        //
    }
}
