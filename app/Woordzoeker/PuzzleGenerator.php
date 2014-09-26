<?php namespace Woordzoeker;

use Woordzoeker\Contract\GeneratorInterface;

class PuzzleGenerator implements GeneratorInterface
{
    /** @var \Woordzoeker\WordGenerator */
    private $wordGenerator;
    /** @var Grid */
    private $grid;

    /**
     * @param \Woordzoeker\WordGenerator $wordGenerator
     * @param \Woordzoeker\Grid $grid
     */
    public function __construct(WordGenerator $wordGenerator, Grid $grid)
    {
        $this->wordGenerator = $wordGenerator;
        $this->grid = $grid;
    }

    /**
     * generate the puzzle and fill the grid with letters
     */
    public function generate()
    {
        $this->setFirstWord();
        $this->setFirstColumnWords();
        // TODO continue

    }

    private function setFirstWord()
    {
        // create random starting word that uses full puzzle width with a max of
        // 15 characters length, because that is the max word length in the database
        $length = $this->grid->getWidth();
        $length = $length > 15 ? 15 : $length;
        $word = $this->wordGenerator->generate(['length' => $length]);
        // then place at random place in random row
        $this->setWordInLine($this->grid->getRandomRow(), $word, 0);
    }

    /**
     * @param \Woordzoeker\Line $line
     * @param string $word
     * @param int $offset
     */
    private function setWordInLine(Line $line, $word, $offset)
    {
        for ($i = $offset, $w = 0; $i < strlen($word) + $offset; $i++, $w++) {
            $cell = $line->getCellAt($i);
            $cell->value = $word[$w];
        }
    }

    private function setFirstColumnWords()
    {
        // put a word in horizontal direction for ~60% of the columns
        $columns = [];
        for ($i = 0; $i < $this->grid->getWidth(); $i++) {
            if ($this->getRandomPercentage() < 60) {
                $columns[] = $i;
            }
        }
        foreach ($columns as $i) {
            $count = 0;
            do {
                // determine random requirements for word at col $i
                $col = $this->grid->getCol($i);
                $wordLength = $this->getRandomWordLength($col);
                $offset = $this->getRandomOffset($col, $wordLength);
                $requirements = $this->createWordRequirements($col, $wordLength, $offset);

                // create word
                $word = $this->wordGenerator->generate($requirements);
            } while ($word === false && ++$count <= 10);

            $this->setWordInLine($col, $word, $offset);
        }
    }

    /**
     * @return int
     */
    private function getRandomPercentage()
    {
        return (int) substr(gmp_strval(gmp_random()), -2);
    }

    /**
     * @param \Woordzoeker\Line $line
     * @return int
     */
    private function getRandomWordLength(Line $line)
    {
        $max = $line->getLength();
        if ($max > WordGenerator::MAX_WORD_LENGTH) {
            $max = WordGenerator::MAX_WORD_LENGTH;
        }

        return mt_rand(WordGenerator::MIN_WORD_LENGTH, $max);
    }

    /**
     * @param \Woordzoeker\Line $line
     * @param int $wordLength
     * @return int
     */
    private function getRandomOffset(Line $line, $wordLength)
    {
        $max = $line->getLength() - $wordLength;
        return mt_rand(0, $max);
    }

    /**
     * @param Line $col
     * @param int $wordLength
     * @param int $offset
     * @return array
     */
    private function createWordRequirements(Line $col, $wordLength, $offset)
    {
        $requirements = ['length' => $wordLength];
        for ($j = $offset; $j < $wordLength + $offset; $j++) {
            $cell = $col->getCellAt($j);
            if ($cell->hasLetter()) {
                $requirements[$j - $offset] = $cell->value;
            }
        }

        return $requirements;
    }
}
