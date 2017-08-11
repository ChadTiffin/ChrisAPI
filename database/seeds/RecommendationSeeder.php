<?php
use Illuminate\Database\Seeder;
class RecommendationSeeder extends Seeder {

    public function run()
    {
    	$recommendations = array(
    		'Eat some more pineapple.'
		);

        foreach($recommendations as $recommendation) {
        	$c = new App\AvailableSuggestion(array('suggestion' => $recommendation));
        	$c->save();
        }
    }

}