<?php

namespace tests;

use PHPUnit\Framework\TestCase;

use PeacefulBit\LispMachine\Parser;
use PeacefulBit\LispMachine\Lexer;
use PeacefulBit\LispMachine\Tree;

class TreeTest extends TestCase
{
    public function testEmptyTree()
    {
        $ast = Parser\toAst([]);
        $this->assertCount(0, $ast);
    }

    public function testEmptyCode()
    {
        $lexemes = Parser\toLexemes("");
        $ast = Parser\toAst($lexemes);
        $this->assertCount(0, $ast);
    }

    public function testMultiSymbol()
    {
        $lexemes = Parser\toLexemes("1 2");
        $ast = Parser\toAst($lexemes);
        $this->assertCount(2, $ast);

        $expected = [
            Tree\node(Tree\TYPE_SYMBOL, '1'),
            Tree\node(Tree\TYPE_SYMBOL, '2'),
        ];

        $this->assertEquals($expected, $ast);
    }

    public function testSimpleExpression()
    {
        $lexemes = Parser\toLexemes("(+ 1 2)");
        $ast = Parser\toAst($lexemes);

        $expected = [
            Tree\node(Tree\TYPE_EXPRESSION, [
                Tree\node(Tree\TYPE_SYMBOL, '+'),
                Tree\node(Tree\TYPE_SYMBOL, '1'),
                Tree\node(Tree\TYPE_SYMBOL, '2'),
            ])
        ];

        $this->assertEquals($expected, $ast);
    }

    public function testNestedExpression()
    {
        $lexemes = Parser\toLexemes("(+ 1 (- 10 2))");
        $ast = Parser\toAst($lexemes);

        $expected = [
            Tree\node(Tree\TYPE_EXPRESSION, [
                Tree\node(Tree\TYPE_SYMBOL, '+'),
                Tree\node(Tree\TYPE_SYMBOL, '1'),
                Tree\node(Tree\TYPE_EXPRESSION, [
                    Tree\node(Tree\TYPE_SYMBOL, '-'),
                    Tree\node(Tree\TYPE_SYMBOL, '10'),
                    Tree\node(Tree\TYPE_SYMBOL, '2')
                ])
            ])
        ];

        $this->assertEquals($expected, $ast);
    }

    public function testSequenceOfExpressions()
    {
        $lexemes = Parser\toLexemes("(+ 1 2) (- 10 2)");
        $ast = Parser\toAst($lexemes);

        $expected = [
            Tree\node(Tree\TYPE_EXPRESSION, [
                Tree\node(Tree\TYPE_SYMBOL, '+'),
                Tree\node(Tree\TYPE_SYMBOL, '1'),
                Tree\node(Tree\TYPE_SYMBOL, '2')
            ]),
            Tree\node(Tree\TYPE_EXPRESSION, [
                Tree\node(Tree\TYPE_SYMBOL, '-'),
                Tree\node(Tree\TYPE_SYMBOL, '10'),
                Tree\node(Tree\TYPE_SYMBOL, '2'),
            ])
        ];

        $this->assertEquals($expected, $ast);
    }
}
