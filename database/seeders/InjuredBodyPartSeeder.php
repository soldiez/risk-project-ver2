<?php

namespace Database\Seeders;

use App\Models\Risk\InjuredBodyPart;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class InjuredBodyPartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $json = File::get("database/data/injuredBodyPartList.json");
        $list = json_decode($json);
        foreach ($list as $key => $value) {
            InjuredBodyPart::create([
                'code' => $value->code,
                'name' => $value->name
            ]);
        }
    }
}
