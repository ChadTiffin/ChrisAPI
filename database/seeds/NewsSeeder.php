<?php
use Illuminate\Database\Seeder;
class NewsSeeder extends Seeder {

    public function run()
    {
    	$news_list = array(
    		array('Some News here','Big News','success')
		);

        foreach($news_list as $news) {
        	$c = new App\News(array('news' => $news[0],'header'=>$news[1], 'class'=>$news[2]));
        	$c->save();
        }
    }

}