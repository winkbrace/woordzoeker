<?php

use Woordzoeker\Grid;
use Woordzoeker\PuzzleGenerator;
use Woordzoeker\WordGenerator;

class HomeController extends BaseController
{

    /**
     * default opening view
     * @return \Illuminate\View\View
     */
	public function index()
	{
        $grid = new Grid(10, 10);

        return $this->createView($grid);
	}

    /**
     * view
     */
    public function setSize()
    {
        $rows = Input::get('rows');
        $cols = Input::get('cols');

        $grid = new Grid($rows, $cols);

        return $this->createView($grid);
    }

    /**
     * @param Grid $grid
     * @return \Illuminate\View\View
     */
    private function createView($grid)
    {
        $puzzle = new PuzzleGenerator(new WordGenerator(), $grid);
        $puzzle->generate();

        $data = [
            'table' => new \Woordzoeker\PuzzleRenderer($grid),
            'sliderRowValue' => $grid->getWidth(),
            'sliderColValue' => $grid->getHeight(),
        ];

        return View::make('home', $data);
    }

}
