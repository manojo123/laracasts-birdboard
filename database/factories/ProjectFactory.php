<?php

use Faker\Generator as Faker;

$factory->define(App\Project::class, function (Faker $faker) {
    return [
		'title' => $faker->sentence,
		'description' => $faker->words(3, true),
		'notes' => $faker->words(3, true),
    	'owner_id' => function(){
    		return factory(App\User::class)->create()->id;
    	}
    ];
});
