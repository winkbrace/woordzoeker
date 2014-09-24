<?php namespace Woordzoeker;

use DB;
use Woordzoeker\Contract\GeneratorInterface;

class WordGenerator implements GeneratorInterface
{
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
     * @return string
     */
    private function createWhereClause(array $requirements)
    {
        if (empty($requirements)) {
            return '1';
        }

        $conditions = [];
        foreach ($requirements as $key => $val) {
            $conditions[] = "`$key` = ?";
        }

        return implode("\n and ", $conditions);
    }
}
