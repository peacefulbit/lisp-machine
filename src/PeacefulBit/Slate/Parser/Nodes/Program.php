<?php

namespace PeacefulBit\Slate\Parser\Nodes;

class Program extends Node
{
    private $body;

    /**
     * @param $body
     */
    public function __construct($body)
    {
        $this->body = $body;
    }

    /**
     * @return mixed
     */
    private function getBody()
    {
        return $this->body;
    }

    public function __toString()
    {
        return implode('', array_map('strval', $this->getBody()));
    }
}