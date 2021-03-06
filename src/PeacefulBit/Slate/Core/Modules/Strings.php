<?php

namespace PeacefulBit\Slate\Core\Modules\Strings;

use PeacefulBit\Slate\Parser\Nodes\NativeExpression;

function export()
{
    return [
        '@' => [
            'concat' => new NativeExpression(function ($eval, array $arguments) {
                return array_reduce($arguments, function ($acc, $arg) use ($eval) {
                    return $acc . $eval($arg);
                }, '');
            })
        ]
    ];
}
