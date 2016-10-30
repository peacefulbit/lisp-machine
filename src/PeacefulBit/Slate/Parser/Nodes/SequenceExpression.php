<?php

namespace PeacefulBit\Slate\Parser\Nodes;

class SequenceExpression extends Node
{
    private $expressions;

    /**
     * @param Node[] $expressions
     */
    public function __construct(array $expressions)
    {
        $this->expressions = $expressions;
    }

    /**
     * @return Node[]
     */
    public function getExpressions()
    {
        return $this->expressions;
    }

    public function __toString()
    {
        return implode('', array_map('strval', $this->getExpressions()));
    }
}