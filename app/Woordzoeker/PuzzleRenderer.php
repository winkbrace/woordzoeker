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

        foreach ($this->grid->getGrid() as $row) {
            $output .= "    <tr>\n";
            foreach ($row as $cell) {
                /** @var Cell $cell */
                $output .= "        <td>" . $cell->value . "</td>\n";
            }
            $output .= "    </tr>\n";
        }

        $output .= "</table>\n";

        return $output;
    }
}
