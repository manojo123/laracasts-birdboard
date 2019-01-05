<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    public function path(){
    	return url('projects')."/".$this->id;
    }
}
