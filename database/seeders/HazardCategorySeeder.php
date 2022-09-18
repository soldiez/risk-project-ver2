<?php

namespace Database\Seeders;

use App\Models\Risk\HazardCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class HazardCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $json = File::get("database/data/hazardCategories.json");
        $list = json_decode($json);

        foreach ($list as $key => $value) {
            HazardCategory::create([
                'type' => $value->type,
                'name' => $value->name
            ]);
        }


    }
}
