<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Project
 * @package App
 */
class Project extends Model
{
    protected $guarded = [];

    public $old = [];

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activity() {
        return $this->hasMany(Activity::class)->latest();
    }

    /**
     * @param $description
     */
    
    public function recordActivity($description){

        $this->activity()->create([
            'description' => $description,
            'changes' => $this->activityChanges($description)
        ]);
    }

    protected function activityChanges($description){
        if($description == 'updated'){
            return [
                'before' => array_except(array_diff($this->old, $this->getAttributes()), 'updated_at'),
                'after' =>  array_except($this->getChanges(), 'updated_at')
            ];
        }
    }
}