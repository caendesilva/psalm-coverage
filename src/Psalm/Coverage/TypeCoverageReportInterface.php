<?php

namespace Psalm\Coverage;

interface TypeCoverageReportInterface
{
    public function __construct(TypeCoverage $coverage);
    public function __invoke(): void;
}
