<?php
use Illuminate\Database\Seeder;
class DrugSeeder extends Seeder {

    public function run()
    {
    	$drugs = array(
           'Acetaminophen(Tylenol)',
           'Donepezil (Aricept)',
           'Rivastigmine - Oral (Exelon)',
           'Rivastigmine - Patch (Exelon)',
           'Galantamine (Razadyne)'



		);


        foreach($drugs as $drug) {
        	$c = new App\DrugName(array('brand_name' => $drug));
        	$c->save();
        }
    }

}