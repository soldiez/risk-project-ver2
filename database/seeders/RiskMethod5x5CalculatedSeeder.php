<?php

namespace Database\Seeders;

use App\Models\Risk\RiskFrequency;
use App\Models\Risk\RiskMethod;
use App\Models\Risk\RiskProbability;
use App\Models\Risk\RiskSeverity;
use App\Models\Risk\RiskZone;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RiskMethod5x5CalculatedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $riskMethodList = [
            'name' => '5 x 5 Calculated method',
            'status' => 'Active',
            'info' => 'Calculated 5 x 5 method, matrix with frequency',
            'is_risk_calculated' => 1,
            'is_risk_frequency' => 1
        ];
        $riskSeverityList = [
            ['name' => 'Insignificant', 'sort'=> 1, 'value'=> 1, 'info' => 'Won’t cause serious injuries or illnesses'],
            ['name' => 'Minor', 'sort'=> 2, 'value'=> 2, 'info' => 'Can cause injuries or illnesses, only to a mild extent'],
            ['name' => 'Significant', 'sort'=> 3, 'value'=> 3, 'info' => 'Can cause injuries or illnesses that may require medical attention but limited treatment'],
            ['name' => 'Major', 'sort'=> 4, 'value'=> 4, 'info' => 'Can cause irreversible injuries or illnesses that require constant medical attention'],
            ['name' => 'Severe', 'sort'=> 5, 'value'=> 5, 'info' => 'Can result to fatality']
        ];
        $riskProbabilityList = [
            ['name' => 'Rare', 'sort'=> 1, 'value'=> 1, 'info' => 'Unlikely to happen and/or have minor or negligible consequences'],
            ['name' => 'Unlikely', 'sort'=> 2, 'value'=> 2, 'info' => 'Possible to happen and/or to have moderate consequences'],
            ['name' => 'Moderate', 'sort'=> 3, 'value'=> 3, 'info' => 'Likely to happen and/or to have serious consequences'],
            ['name' => 'Likely', 'sort'=> 4, 'value'=> 4, 'info' => 'Almost sure to happen and/or to have major consequences'],
            ['name' => 'Almost certain', 'sort'=> 5, 'value'=> 5, 'info' => 'Sure to happen and/or have major consequences'],

        ];
        $riskFrequencyList = [
            ['name' => 'Rare  fr', 'sort'=> 1, 'value'=> 1, 'info' => 'Unlikely to happen and/or have minor or negligible consequences'],
            ['name' => 'Unlikely fr', 'sort'=> 2, 'value'=> 2, 'info' => 'Possible to happen and/or to have moderate consequences'],
            ['name' => 'Moderate fr', 'sort'=> 3, 'value'=> 3, 'info' => 'Likely to happen and/or to have serious consequences'],
            ['name' => 'Likely fr', 'sort'=> 4, 'value'=> 4, 'info' => 'Almost sure to happen and/or to have major consequences'],
            ['name' => 'Almost certain fr', 'sort'=> 5, 'value'=> 5, 'info' => 'Sure to happen and/or have major consequences'],

        ];

        $riskZonesList = [
            ['name' => 'Very low', 'value' => 5, 'colour' => 'light green', 'info' => 'Acceptable – no further action may be needed and maintaining control measures is encouraged'],
            ['name' => 'Low', 'value' => 15, 'colour' => 'green', 'info' => 'Acceptable – no further action may be needed and maintaining control measures is encouraged'],
            ['name' => 'Medium', 'value' => 40, 'colour' => 'yellow', 'info' => 'Acceptable – no further action may be needed and maintaining control measures is encouraged'],
            ['name' => 'High', 'value' => 60, 'colour' => 'orange', 'info' => 'Tolerable – must be reviewed in a timely manner to carry out improvement strategies'],
            ['name' => 'Very high', 'value' => 80, 'colour' => 'red', 'info' => 'Tolerable – must be reviewed in a timely manner to carry out improvement strategies'],
            ['name' => 'Extreme', 'value' => 100, 'colour' => 'dark red', 'info' => 'Unacceptable – must implement cease in activities and endorse for immediate action'],
        ];
            //TODO change light and dark to right color
        $riskMethod = RiskMethod::factory($riskMethodList)->create();

        foreach ($riskSeverityList as $value) {
            RiskSeverity::factory($value)
                ->for($riskMethod)->create();
        }
        foreach ($riskProbabilityList as $value) {
            RiskProbability::factory($value)
                ->for($riskMethod)->create();
        }
        foreach ($riskFrequencyList as $value) {
            RiskFrequency::factory($value)
                ->for($riskMethod)->create();
        }
        foreach ($riskZonesList as $value) {
            RiskZone::factory($value)
                ->for($riskMethod)->create();
        }


//        $count = 0;
//        foreach ($riskMethod->riskSeverities as $riskSeverity) {
//            foreach ($riskMethod->riskProbabilities as $riskProbability) {
//                foreach ($riskMethod->riskFrequencies as $riskFrequency) {
//
//                    RiskZone::factory([
//                        'name' => $riskZonesList[$count]['name'],
//                        'value' => $riskZonesList[$count]['value'],
//                        'colour' => $riskZonesList[$count]['colour'],
//                        'info' => $riskZonesList[$count]['info'],
//                        'risk_severity_id' => $riskSeverity->id,
//                        'risk_probability_id' => $riskProbability->id,
//                        'risk_frequency_id' => $riskFrequency->id
//                    ])
//                        ->for($riskMethod)
//                        ->create();
//                    $count = $count + 1;
//                }
//            }
//        }
    }
}
