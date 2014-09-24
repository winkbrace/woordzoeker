<?php namespace Woordzoeker;

class PuzzleGenerator implements GeneratorInterface
{
    /** @var \Woordzoeker\WordGenerator */
    private $wordGenerator;
    /** @var Grid */
    private $grid;

    public function __construct(WordGenerator $wordGenerator, Grid $grid)
    {
        $this->wordGenerator = $wordGenerator;
        $this->grid = $grid;
    }

    public function generate()
    {
        // TODO: Implement generate() method.
    }
}
