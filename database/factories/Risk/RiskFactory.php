<?php

namespace Database\Factories\Risk;

use App\Models\Risk\HazardCategory;
use App\Models\Risk\InjuredBodyPart;
use App\Models\Risk\RiskMethod;
use App\Models\Risk\RiskZone;
use App\Models\Unit\Unit;
use App\Models\User;
use DateInterval;
use Faker\Core\DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Risk\Risk>
 */
class RiskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

//        $unitId = Unit::all()->first()->id;

        $riskMethod = RiskMethod::all()->first();
        $riskMethodId = $riskMethod->id;
        $baseSeverityId = $riskMethod->riskSeverities->random()->id;
        $baseProbabilityId = $riskMethod->riskProbabilities->random()->id;
        $propSeverityId = $riskMethod->riskSeverities->random()->id;
        $propProbabilityId = $riskMethod->riskProbabilities->random()->id;


        if($riskMethod->is_risk_frequency) {
            $baseFrequencyId = $riskMethod->riskFrequencies->random()->id;
            $propFrequencyId = $riskMethod->riskFrequencies->random()->id;
        }

        $baseCalcRiskId = RiskZone::where('risk_severity_id',$baseSeverityId)->where('risk_probability_id',$baseProbabilityId)->first()->id;
        $propCalcRiskId = RiskZone::where('risk_severity_id', $propSeverityId)->where('risk_probability_id', $propProbabilityId)->first()->id;


        $one_year = new DateInterval('P1Y');
        $createDate = now();
        $reviewDate = $createDate->add($one_year);



        return [


            'hazard_info' => $this->faker->realText,
            'hazard_category_id' => HazardCategory::all()->random()->id,
            'injured_body_part_id' => InjuredBodyPart::all()->random()->id,
            'base_risk_info' => $this->faker->realText,
            'base_preventive_action' => $this->faker->realText,

            'risk_method_id' => $riskMethodId,
            'base_severity_id' => $baseSeverityId,
            'base_probability_id' => $baseProbabilityId,
        //    'base_frequency_id' => RiskMethod::find($riskMethodId)->riskSeverities->random()->id,
            'base_calc_risk' => $baseCalcRiskId,

            'prop_preventive_action' => $this->faker->realText,
            'prop_severity_id' => $propSeverityId,
            'prop_probability_id' => $propProbabilityId,
        //    'prop_frequency_id',
            'prop_calc_risk' => $propCalcRiskId,

            'create_date_time' => $this->faker->dateTime,
            'creator_id' => User::all()->random()->id,
            'review_date' => $reviewDate,
            'auditor_id' => User::all()->random()->id,
            'control_review_date' => $reviewDate,
            'risk_status' => array_rand(array_flip([
                'Created',
                'Has Actions',
                'Action closed',
                'Reviewed',
                'Archive'
            ]))
        ];
    }
}
