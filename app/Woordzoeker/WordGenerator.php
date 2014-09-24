<?php namespace Woordzoeker;

use DB;

class WordGenerator implements GeneratorInterface
{
    /**
     * @param array $requirements
     * @return string|false
     */
    public function generate(array $requirements = [])
    {
        $where = $this->createWhereClause($requirements);
        $result = DB::select("select word from words where $where", array_values($requirements));

        if (empty($result)) {
            return false;
        }

        $random = $result[array_rand($result)];

        return $random->word;
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
