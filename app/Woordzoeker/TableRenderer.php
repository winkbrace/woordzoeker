<?php namespace Woordzoeker;

use Illuminate\Support\Contracts\RenderableInterface;

class TableRenderer implements RenderableInterface
{
    /** @var int */
    protected $width;
    /** @var int */
    protected $height;

    /**
     * @param int $width
     * @param int $height
     */
    public function __construct($width, $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * Get the evaluated contents of the object.
     * @return string
     */
    public function render()
    {
        $output = "<table>\n";

        for ($r = 1; $r <= $this->height; $r++) {
            $output .= "    <tr>\n";
            for ($c = 1; $c <= $this->width; $c++) {
                $output .= "        <td></td>\n";
            }
            $output .= "    </tr>\n";
        }

        $output .= "</table/>\n";

        return $output;
    }
}
