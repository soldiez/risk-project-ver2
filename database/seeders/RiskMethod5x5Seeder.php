<?php

namespace Database\Seeders;

use App\Models\Risk\RiskMethod;
use App\Models\Risk\RiskProbability;
use App\Models\Risk\RiskSeverity;
use App\Models\Risk\RiskZone;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RiskMethod5x5Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $riskMethodList = [
            'name' => '5 x 5 method',
            'status' => 'Active',
            'info' => 'Standard 5 x 5 method, matrix without calculating (Safety Culture)',
            'is_risk_calculated' => 0,
            'is_risk_frequency' => 0
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
        $riskZonesList = [
            ['name' => 'Very low', 'value' => 1, 'colour' => 'light green', 'info' => 'Acceptable – no further action may be needed and maintaining control measures is encouraged'],
            ['name' => 'Very low', 'value' => 2, 'colour' => 'light green', 'info' => 'Acceptable – no further action may be needed and maintaining control measures is encouraged'],
            ['name' => 'Low', 'value' => 3, 'colour' => 'green', 'info' => 'Acceptable – no further action may be needed and maintaining control measures is encouraged'],
            ['name' => 'Medium', 'value' => 4, 'colour' => 'yellow', 'info' => 'Acceptable – no further action may be needed and maintaining control measures is encouraged'],
            ['name' => 'Medium', 'value' => 5, 'colour' => 'yellow', 'info' => 'Adequate – may be considered for further analysis'],

            ['name' => 'Very low', 'value' => 2, 'colour' => 'light green', 'info' => 'Acceptable – no further action may be needed and maintaining control measures is encouraged'],
            ['name' => 'Low', 'value' => 4, 'colour' => 'green', 'info' => 'Acceptable – no further action may be needed and maintaining control measures is encouraged'],
            ['name' => 'Medium', 'value' => 6, 'colour' => 'yellow', 'info' => 'Adequate – may be considered for further analysis'],
            ['name' => 'Medium', 'value' => 8, 'colour' => 'yellow', 'info' => 'Adequate – may be considered for further analysis'],
            ['name' => 'High', 'value' => 10, 'colour' => 'orange', 'info' => 'Tolerable – must be reviewed in a timely manner to carry out improvement strategies'],

            ['name' => 'Low', 'value' => 3, 'colour' => 'green', 'info' => 'Acceptable – no further action may be needed and maintaining control measures is encouraged'],
            ['name' => 'Medium', 'value' => 6, 'colour' => 'yellow', 'info' => 'Adequate – may be considered for further analysis'],
            ['name' => 'Medium', 'value' => 9, 'colour' => 'yellow', 'info' => 'Adequate – may be considered for further analysis'],
            ['name' => 'High', 'value' => 12, 'colour' => 'orange', 'info' => 'Tolerable – must be reviewed in a timely manner to carry out improvement strategies'],
            ['name' => 'Very high', 'value' => 15, 'colour' => 'red', 'info' => 'Tolerable – must be reviewed in a timely manner to carry out improvement strategies'],

            ['name' => 'Medium', 'value' => 4, 'colour' => 'yellow', 'info' => 'Acceptable – no further action may be needed and maintaining control measures is encouraged'],
            ['name' => 'Medium', 'value' => 8, 'colour' => 'yellow', 'info' => 'Adequate – may be considered for further analysis'],
            ['name' => 'High', 'value' => 12, 'colour' => 'orange', 'info' => 'Tolerable – must be reviewed in a timely manner to carry out improvement strategies'],
            ['name' => 'Very high', 'value' => 16, 'colour' => 'red', 'info' => 'Tolerable – must be reviewed in a timely manner to carry out improvement strategies'],
            ['name' => 'Extreme', 'value' => 20, 'colour' => 'dark red', 'info' => 'Unacceptable – must implement cease in activities and endorse for immediate action'],

            ['name' => 'Medium', 'value' => 5, 'colour' => 'yellow', 'info' => 'Adequate – may be considered for further analysis'],
            ['name' => 'High', 'value' => 10, 'colour' => 'orange', 'info' => 'Tolerable – must be reviewed in a timely manner to carry out improvement strategies'],
            ['name' => 'Very high', 'value' => 15, 'colour' => 'red', 'info' => 'Tolerable – must be reviewed in a timely manner to carry out improvement strategies'],
            ['name' => 'Extreme', 'value' => 20, 'colour' => 'dark red', 'info' => 'Unacceptable – must implement cease in activities and endorse for immediate action'],
            ['name' => 'Extreme', 'value' => 25, 'colour' => 'dark red', 'info' => 'Unacceptable – must implement cease in activities and endorse for immediate action'],
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
        $count = 0;
        foreach ($riskMethod->riskSeverities as $riskSeverity) {
            foreach ($riskMethod->riskProbabilities as $riskProbability) {
                RiskZone::factory([
                    'name' => $riskZonesList[$count]['name'],
                    'value' => $riskZonesList[$count]['value'],
                    'colour' => $riskZonesList[$count]['colour'],
                    'info' => $riskZonesList[$count]['info'],
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
