<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timeline extends Model {

	protected $table = 'timeline';

    protected $fillable = [
    	'user_id','title','date','content'
    ];

    public static $rules_add = [
        'user_id' => 'required'
        'title' => 'required'
        'date' => 'required'
        'content' => 'required'
    ];

    public static $rules_update = [
        'user_id' => 'required'
        'title' => 'required'
        'date' => 'required'
        'content' => 'required'
    ];

}
