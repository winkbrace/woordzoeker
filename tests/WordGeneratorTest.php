<?php namespace Woordzoeker;

class WordGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /** @var WordGenerator */
    private $generator;

    public function setUp()
    {
        $this->generator = new WordGenerator();
    }

    public function testGetWord()
    {
        $word = $this->generator->generate([3 => 'a', 4 => 'a', 'length' => 7]);
        $this->assertEquals('aa', substr($word, 3, 2));
        $this->assertEquals(7, strlen($word));
    }

    public function testUnmetRequirements()
    {
        $word = $this->generator->generate(['q', 'z']); // there are no words starting with 'qz..'
        $this->assertFalse($word);
    }
}
