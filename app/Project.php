<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    public function path(){
    	return url('projects')."/".$this->id;
    }

    public function owner(){
    	return $this->belongsTo(User::class);
    }
}
