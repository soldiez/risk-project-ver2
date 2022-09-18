<?php

namespace Database\Seeders;

use App\Models\Risk\RiskMethod;
use App\Models\Risk\RiskProbability;
use App\Models\Risk\RiskSeverity;
use App\Models\Risk\RiskZone;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RiskMethod3x3Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $riskMethodList = [
            'name' => '3 x 3 method',
            'status' => 'Active',
            'info' => 'Standard 3 x 3 method, simple matrix without calculating',
            'is_risk_calculated' => 0,
            'is_risk_frequency' => 0
        ];
        $riskSeverityList = [
            ['name' => 'Minor injury', 'sort'=> 1, 'value'=> '', 'info' => 'Little injury'],
            ['name' => 'Major injury', 'sort'=> 2, 'value'=> '', 'info' => 'Seriously injury'],
            ['name' => 'Death', 'sort'=> 3, 'value'=> '', 'info' => 'Death and very serious injury']
        ];
        $riskProbabilityList = [
            ['name' => 'Almost certain', 'sort'=> 1, 'value'=> '', 'info' => 'Less then one per week'],
            ['name' => 'Quite likely', 'sort'=> 2, 'value'=> '', 'info' => 'Less then one per month'],
            ['name' => 'Not very likely', 'sort'=> 3, 'value'=> '', 'info' => 'Less then one per year']
        ];
        $riskZonesList = [
            ['name' => 'Manage', 'value' => '', 'colour' => 'yellow', 'info' => ''],
            ['name' => 'Monitor', 'value' => '', 'colour' => 'green', 'info' => ''],
            ['name' => 'Monitor', 'value' => '', 'colour' => 'green', 'info' => ''],
            ['name' => 'Take action', 'value' => '', 'colour' => 'red', 'info' => ''],
            ['name' => 'Manage', 'value' => '', 'colour' => 'yellow', 'info' => ''],
            ['name' => 'Monitor', 'value' => '', 'colour' => 'green', 'info' => ''],
            ['name' => 'Take action', 'value' => '', 'colour' => 'red', 'info' => ''],
            ['name' => 'Take action', 'value' => '', 'colour' => 'red', 'info' => ''],
            ['name' => 'Manage', 'value' => '', 'colour' => 'yellow', 'info' => '']
        ];

        $riskMethod = RiskMethod::factory($riskMethodList)->create();

        foreach ($riskSeverityList as $value) {
            RiskSeverity::factory($value)
                ->for($riskMethod)->create();
        }
        foreach ($riskProbabilityList as $value) {
            RiskProbability::factory($value)
                ->for($riskMethod)->create();
        }
        $count = 0;
        foreach ($riskMethod->riskSeverities as $riskSeverity) {
            foreach ($riskMethod->riskProbabilities as $riskProbability) {
                RiskZone::factory([
                    'name' => $riskZonesList[$count]['name'],
                    'colour' => $riskZonesList[$count]['colour'],
                    'risk_severity_id' => $riskSeverity->id,
                    'risk_probability_id' => $riskProbability->id
                    ])
                    ->for($riskMethod)
                    ->create();
                $count = $count + 1;
            }
        }
    }
}
