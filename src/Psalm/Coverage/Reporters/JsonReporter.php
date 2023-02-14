<?php

declare(strict_types=1);

namespace Psalm\Coverage\Reporters;

use Psalm\Coverage\TypeCoverage;

class JsonReporter implements TypeCoverageReportInterface
{
    protected TypeCoverage $coverage;

    /** @todo Make configurable */
    protected string $outputPath = 'type-coverage.json';

    public function __construct(TypeCoverage $coverage)
    {
        $this->coverage = $coverage;
    }

    public function __invoke(): void
    {
        $fileCoverageData = [];

        foreach ($this->coverage->getFileCoverageData() as $file) {
            $fileCoverageData[] = [
                'path' => $file->getPath(),
                'mixed_count' => $file->getMixedCount(),
                'non_mixed_count' => $file->getNonMixedCount(),
                'percentage' => $file->getPercentage(),
            ];
        }

        $json = json_encode([
            'coverage' => $this->coverage->getCoverage(),
            'file_coverage_data' => $fileCoverageData,
        ], JSON_PRETTY_PRINT);

        if ($json === false) {
            throw new \UnexpectedValueException('Could not encode JSON');
        }
        file_put_contents($this->outputPath, $json);
    }
}
