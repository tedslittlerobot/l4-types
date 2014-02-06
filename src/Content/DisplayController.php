<?php namespace Velox\Content;

use Illuminate\Routing\Controller;
use Velox\Core\Velox;
use Velox\Content\Type\Definition;

use Velox\Content\Content;
use View;
use Redirect;

class DisplayController extends Controller {

	public function archive()
	{
		return View::make('velox::display.archive');
	}

	public function type( Definition $type )
	{
		return View::make('velox::display.type.archive');
	}

	public function content( Definition $type, $content )
	{
		return View::make('velox::display.type.main')
			->with( 'content', $content );
	}

}
