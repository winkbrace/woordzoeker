<?php namespace Woordzoeker;

use Woordzoeker\Contract\GeneratorInterface;

set_time_limit(120);

class PuzzleGenerator implements GeneratorInterface
{
    const DIRECTION_NORMAL = 'normal';
    const DIRECTION_REVERSE = 'reverse';

    /** @var \Woordzoeker\WordGenerator */
    private $wordGenerator;
    /** @var Grid */
    private $grid;
    /** @var string[] */
    private $placedWords = [];

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
        // fill initially
        $this->setFirstWord();
        $this->generateWordsInColumns();
        $this->generateWordsInDiagonals();
        $this->generateWordsInRows();

        // fill empty areas
        foreach ($this->grid->getAllLines() as $line) {
            if ($line->freeCellCount() > 3) {
                $this->placeRandomWord($line);
            }
        }

        // fill remaining empty cells with random letters
        foreach ($this->grid->getRows() as $row) {
            foreach ($row->getEmptyCells() as $cell) {
                $cell->value = $this->getRandomLetter();
            }
        }
    }

    private function setFirstWord()
    {
        // create random starting word that uses full puzzle width with a max of
        // 15 characters length, because that is the max word length in the database
        $length = $this->grid->getWidth();
        $length = $length > 15 ? 15 : $length;
        $word = $this->wordGenerator->generate(['length' => $length]);
        // then place at random place in random row
        $this->placeWord($this->grid->getRandomRow(), $word, 0);
    }

    private function generateWordsInColumns()
    {
        foreach ($this->grid->getColumns() as $col) {
            if ($this->getRandomPercentage() < 60) {
                $this->placeRandomWord($col);
            }
        }
    }

    private function generateWordsInDiagonals()
    {
        foreach ($this->grid->getDiagonals() as $diagonal) {
            if ($this->getRandomPercentage() < 50) {
                $this->placeRandomWord($diagonal);
            }
        }
    }

    private function generateWordsInRows()
    {
        foreach ($this->grid->getRows() as $row) {
            if ($this->getRandomPercentage() < 60) {
                $this->placeRandomWord($row);
            }
        }
    }

    /**
     * @param Line $line
     */
    private function placeRandomWord(Line $line)
    {
        if ($line->freeCellCount() < 3) {
            return;
        }

        $count = 0;
        do {
            // determine random requirements for word at this line
            $wordLength = $this->getRandomWordLength($line);
            $offset = $this->getRandomOffset($line, $wordLength);
            $direction = $this->getRandomDirection();
            $requirements = $this->createWordRequirements($line, $wordLength, $offset, $direction);

            // create word
            $word = $this->wordGenerator->generate($requirements);
        } while ($word === false && ++$count <= 10);

        $this->placeWord($line, $word, $offset);
    }

    /**
     * @param \Woordzoeker\Line $line
     * @param string $word
     * @param int $offset
     */
    private function placeWord(Line $line, $word, $offset)
    {
        for ($i = $offset, $w = 0; $i < strlen($word) + $offset; $i++, $w++) {
            $cell = $line->getCellAt($i);
            $cell->value = $word[$w];
        }

        $this->placedWords[] = $word;
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
     * @return string
     */
    private function getRandomLetter()
    {
        $alphabet = range('a', 'z');
        return $alphabet[array_rand($alphabet)];
    }

    /**
     * @param Line $col
     * @param int $wordLength
     * @param int $offset
     * @param string $direction
     * @return array
     */
    private function createWordRequirements(Line $col, $wordLength, $offset, $direction)
    {
        if ($direction == self::DIRECTION_REVERSE) {
            $col->reverse();
        }
        $requirements = ['length' => $wordLength];
        for ($j = $offset; $j < $wordLength + $offset; $j++) {
            $cell = $col->getCellAt($j);
            if ($cell->hasLetter()) {
                $requirements[$j - $offset] = $cell->value;
            }
        }

        return $requirements;
    }

    /**
     * @return string
     */
    private function getRandomDirection()
    {
        $pool = [self::DIRECTION_NORMAL, self::DIRECTION_REVERSE];
        return $pool[array_rand($pool)];
    }

    /**
     * @return string[]
     */
    public function getPlacedWords()
    {
        $this->placedWords = array_filter($this->placedWords);
        sort($this->placedWords);

        return $this->placedWords;
    }
}
