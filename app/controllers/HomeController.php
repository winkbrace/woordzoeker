<?php

class HomeController extends BaseController
{

	public function index()
	{
        $generator = new \Woordzoeker\WordGenerator();
        $generator->giveWord([]);

        $data = [
            'table' => new \Woordzoeker\TableRenderer(10, 10),
        ];

		return View::make('home', $data);
	}

}
