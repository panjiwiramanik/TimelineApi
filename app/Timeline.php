<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timeline extends Model {

	protected $table = 'timeline';

    protected $fillable = [
    	'user_id','title','date','content','color' 
    ];

    public static $rules_add = [
        'user_id' => 'required',
        'title' => 'required',
        'date' => 'required',
        'content' => 'required',
        'color' => 'required'
    ];

    public static $rules_update = [
        'user_id' => 'required',
        'content' => 'required'
    ];

}
