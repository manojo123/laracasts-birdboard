<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Project
 * @package App
 */
class Project extends Model
{
    use RecordsActivity;

    protected $guarded = [];

    /**
     * @param string $route
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function path($route = "") {
    	return url('projects/'.$this->id.$route);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    
    public function owner() {
    	return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activity() {
        return $this->hasMany(Activity::class)->latest();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks() {
    	return $this->hasMany(Task::class);
    }

    /**
     * @param $body
     * @return Model
     */
    public function addTask($body) {
        return $this->tasks()->create(compact('body'));
    }

    public function invite(User $user){
        return $this->members()->attach($user);
    }

    public function members(){
        return $this->belongsToMany(User::class, 'project_members');
    }
}
