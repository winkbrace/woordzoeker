<?php namespace Woordzoeker;

class PuzzleGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Woordzoeker\WordGenerator */
    private $wordGenerator;
    /** @var Grid */
    private $grid;

    public function setUp()
    {
        /** @var \Woordzoeker\WordGenerator|\Mockery\MockInterface $wordGenerator */
        //$this->wordGenerator = \Mockery::mock('\\Woordzoeker\\Contract\\GeneratorInterface');
        //$this->wordGenerator->shouldReceive('generate')->once()->with([])->andReturn('dummy');
        // mocking the word generator would require a lot of manual work. I knowingly sacrifice
        // speed and predictability for laziness. :) In this case, if it works, it works.
        $this->wordGenerator = new WordGenerator();

        $this->grid = new Grid(5, 5);
    }

    public function testCreation()
    {
        $generator = new PuzzleGenerator($this->wordGenerator, $this->grid);
        $this->assertInstanceOf('\\Woordzoeker\\PuzzleGenerator', $generator);
    }

    public function testGenerate()
    {
        $generator = new PuzzleGenerator($this->wordGenerator, $this->grid);
        $generator->generate();

        foreach ($this->grid->getGrid() as $row) {
            foreach ($row as $cell) {
                $this->assertNotEmpty($cell->value);
            }
        }
    }
}
 