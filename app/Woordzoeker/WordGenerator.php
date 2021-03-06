<?php namespace Woordzoeker;

use DB;
use Woordzoeker\Contract\GeneratorInterface;

class WordGenerator implements GeneratorInterface
{
    const MIN_WORD_LENGTH = 4;
    const MAX_WORD_LENGTH = 15;

    /**
     * @param array $requirements
     * @return string|false
     */
    public function generate(array $requirements = [])
    {
        $where = $this->createWhereClause($requirements);
        $sql = "select word
                from   words
                where  $where
                order by rand()
                limit 1";
        $result = DB::select($sql, array_values($requirements));

        if (empty($result)) {
            return false;
        }

        return $result[0]->word;
    }

    /**
     * @param array $requirements
     * @throws \Exception
     * @return string
     */
    private function createWhereClause(array $requirements)
    {
        if (empty($requirements)) {
            return '1';
        }

        $this->validateRequirements($requirements);

        $conditions = [];
        foreach ($requirements as $key => $val) {
            $conditions[] = "`$key` = ?";
        }

        return implode("\n and ", $conditions);
    }

    /**
     * @param array $requirements
     * @throws \Exception
     */
    private function validateRequirements(array $requirements)
    {
        if (array_key_exists('length', $requirements)) {
            $length = $requirements['length'];
            if ($length < self::MIN_WORD_LENGTH || $length > self::MAX_WORD_LENGTH) {
                throw new \Exception('Invalid word length requirement given: ' . $length);
            }
        }
    }
}
