<?php

use Woordzoeker\Grid;
use Woordzoeker\PuzzleGenerator;
use Woordzoeker\WordGenerator;

class HomeController extends BaseController
{

	public function index()
	{
        $data = [
            'table' => new \Woordzoeker\PuzzleRenderer(10, 10),
        ];

		return View::make('home', $data);
	}

    public function setSize()
    {
        $rows = Input::get('rows');
        $cols = Input::get('cols');

        $puzzle = new PuzzleGenerator(new WordGenerator(), new Grid($rows, $cols));
    }

}
