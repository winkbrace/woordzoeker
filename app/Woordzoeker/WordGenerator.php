<?php namespace Woordzoeker;

class WordGenerator
{
    /** @var string[] */
    private $usedWords = [];

    public function giveWord(array $requirements = [])
    {
        $where = "";
        foreach ($requirements as $key => $val) {
            $where .= "`$key` = $val";
        }
        $result = \Db::select("select * from words where $where");
        vd($result);
    }
}
