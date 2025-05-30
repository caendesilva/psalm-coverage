<?php

declare(strict_types=1);

namespace Psalm\Type\Atomic;

use Override;

/**
 * Denotes an integer value where the exact numeric value is known.
 *
 * @psalm-immutable
 */
final class TLiteralInt extends TInt
{
    public function __construct(public int $value, bool $from_docblock = false)
    {
        parent::__construct($from_docblock);
    }

    #[Override]
    public function getKey(bool $include_extra = true): string
    {
        return 'int(' . $this->value . ')';
    }

    #[Override]
    public function getId(bool $exact = true, bool $nested = false): string
    {
        if (!$exact) {
            return 'int';
        }

        return (string) $this->value;
    }

    #[Override]
    public function getAssertionString(): string
    {
        return 'int(' . $this->value . ')';
    }

    /**
     * @param  array<lowercase-string, string> $aliased_classes
     */
    #[Override]
    public function toNamespacedString(
        ?string $namespace,
        array $aliased_classes,
        ?string $this_class,
        bool $use_phpdoc_format,
    ): string {
        return $use_phpdoc_format ? 'int' : (string) $this->value;
    }
}
