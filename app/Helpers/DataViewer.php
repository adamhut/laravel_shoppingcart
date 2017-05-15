<?php 
namespace App\Helpers;


trait DataViewer{

	public static $operators =[
    	'equal' => '=',
    	'not_equal' => '<>',
    	'less_than' => '<', 
    	'greater_than' => '>',
    	'less_than_or_equal_to' => '<=', 
    	'greater_than_or_equal_to' => '>=',
    	'in' => 'in',
    	'like' => 'like',
    ];

	public function scopeSearchPaginateAndOrder($query)
	{
		$request = request();
		return $query
			->orderBy(request()->get('column'),request()->get('direction'))
			->where(function($q) use ($request) {
				if($request->has('search_input'))
				{
					if($request->search_operator=='in')
					{
						$q->whereIn($request->search_column,explode(',',$request->search_input) );
					}elseif($request->search_operator=='like')
					{
						$q->where($request->search_column,'LIKE','%'.$request->search_input.'%' );
					}else
					{
						$q->where($request->search_column, self::$operators[$request->search_operator] ,$request->search_input);
					}
				}
			})
			->paginate(request()->get('per_page'));
	}

}