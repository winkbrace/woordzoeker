<?php namespace Woordzoeker;

use Illuminate\Support\Contracts\RenderableInterface;

class PuzzleRenderer implements RenderableInterface
{
    /** @var Grid */
    private $grid;

    /**
     * @param \Woordzoeker\Grid $grid
     */
    public function __construct(Grid $grid)
    {
        $this->grid = $grid;
    }

    /**
     * Get the evaluated contents of the object.
     * @return string
     */
    public function render()
    {
        $output = '<table id="woordzoeker-table">'."\n";

        for ($r = 1; $r <= $this->height; $r++) {
            $output .= "    <tr>\n";
            for ($c = 1; $c <= $this->width; $c++) {
                $output .= "        <td></td>\n";
            }
            $output .= "    </tr>\n";
        }

        $output .= "</table>\n";

        return $output;
    }
}
