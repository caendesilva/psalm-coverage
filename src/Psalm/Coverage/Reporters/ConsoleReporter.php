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
        $path_nonmixed_count = $file->getNonMixedCount();
        $path_mixed_count = $file->getMixedCount();
        $file_path = $file->getPath();
        return str_pad($path_nonmixed_count ? str_pad(number_format((($path_nonmixed_count / ($path_mixed_count + $path_nonmixed_count)) * 100), 2), 5, '0', STR_PAD_LEFT)  : 'N/A', 6, ' ', STR_PAD_LEFT)." - File $file_path has $path_mixed_count mixed and $path_nonmixed_count non-mixed";
    }
}
