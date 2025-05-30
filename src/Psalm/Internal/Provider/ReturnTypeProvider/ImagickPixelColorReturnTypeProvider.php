<?php

declare(strict_types=1);

namespace Psalm\Internal\Provider\ReturnTypeProvider;

use Override;
use Psalm\Internal\Analyzer\StatementsAnalyzer;
use Psalm\Plugin\EventHandler\Event\MethodReturnTypeProviderEvent;
use Psalm\Plugin\EventHandler\MethodReturnTypeProviderInterface;
use Psalm\Type;
use Psalm\Type\Atomic\TKeyedArray;
use Psalm\Type\Atomic\TLiteralInt;
use Psalm\Type\Union;

use function assert;
use function in_array;

/**
 * @internal
 */
final class ImagickPixelColorReturnTypeProvider implements MethodReturnTypeProviderInterface
{
    #[Override]
    public static function getClassLikeNames(): array
    {
        return ['imagickpixel'];
    }

    #[Override]
    public static function getMethodReturnType(MethodReturnTypeProviderEvent $event): ?Union
    {
        $source = $event->getSource();
        $call_args = $event->getCallArgs();
        $method_name_lowercase = $event->getMethodNameLowercase();

        if ($method_name_lowercase !== 'getcolor') {
            return null;
        }

        if (!$source instanceof StatementsAnalyzer) {
            return null;
        }

        if (!$call_args) {
            $formats = [0 => true];
        } else {
            $normalized = $source->node_data->getType($call_args[0]->value) ?? Type::getMixed();
            $formats = [];
            foreach ($normalized->getAtomicTypes() as $t) {
                if ($t instanceof TLiteralInt && in_array($t->value, [0, 1, 2], true)) {
                    $formats[$t->value] = true;
                } else {
                    $formats[0] = true;
                    $formats[1] = true;
                    $formats[2] = true;
                }
            }
        }
        $types = [];
        if (isset($formats[0])) {
            $types []= new Union([
                TKeyedArray::make([
                    'r' => Type::getIntRange(0, 255),
                    'g' => Type::getIntRange(0, 255),
                    'b' => Type::getIntRange(0, 255),
                    'a' => Type::getIntRange(0, 1),
                ]),
            ]);
        }
        if (isset($formats[1])) {
            $types []= new Union([
                TKeyedArray::make([
                    'r' => Type::getFloat(),
                    'g' => Type::getFloat(),
                    'b' => Type::getFloat(),
                    'a' => Type::getFloat(),
                ]),
            ]);
        }
        if (isset($formats[2])) {
            $types []= new Union([
                TKeyedArray::make([
                    'r' => Type::getIntRange(0, 255),
                    'g' => Type::getIntRange(0, 255),
                    'b' => Type::getIntRange(0, 255),
                    'a' => Type::getIntRange(0, 255),
                ]),
            ]);
        }

        assert($types !== []);
        return Type::combineUnionTypeArray($types, $event->getSource()->getCodebase());
    }
}
