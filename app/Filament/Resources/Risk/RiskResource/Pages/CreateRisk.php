<?php

namespace App\Filament\Resources\Risk\RiskResource\Pages;

use App\Filament\Resources\Risk\RiskResource;
use App\Models\Risk\Risk;
use App\Models\Unit\Activity;
use App\Models\Unit\Department;
use App\Models\Unit\Position;
use App\Models\Unit\Process;
use App\Models\Unit\Product;
use App\Models\Unit\Service;
use App\Models\Unit\Territory;
use App\Models\Unit\Worker;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateRisk extends CreateRecord
{
    protected static string $resource = RiskResource::class;

public function create(bool $another = false): void
{
    $data = $this->data;
    $risks = $data['risks'];

    foreach ($risks as $risk) {
        $model = Risk::create([
            'unit_id' => $data['unit_id'],
            'hazard_info'=> $risk['hazard_info'],
            'hazard_category_id'=> $risk['hazard_category_id'],
            'injured_body_part_id' => $risk['injured_body_part_id'],
            'base_risk_info' => $risk['base_risk_info'],
            'base_preventive_action' => $risk['base_preventive_action'],
            'risk_method_id' => $data['risk_method_id'],
            'base_severity_id' => $risk['base_severity_id'],
            'base_probability_id' => $risk['base_probability_id'],
            'base_frequency_id'=> $risk['base_frequency_id'],
            'base_calc_risk' => $risk['base_calc_risk'],
            'prop_preventive_action' => $risk['prop_preventive_action'],
            'prop_severity_id' => $risk['prop_severity_id'],
            'prop_probability_id' => $risk['prop_probability_id'],
            'prop_frequency_id' => $risk['prop_frequency_id'],
            'prop_calc_risk' => $risk['prop_calc_risk'],
            'create_date_time' => $data['create_date_time'],
            'creator_id' => $data['creator_id'],
            'review_date' => $risk['review_date'],
            'auditor_id' => $risk['auditor_id'],
//            'control_review_date' => $data['control_review_date'], //TODO control review date
            'risk_status' => 'Created',
        ]);
        foreach ($data['authors'] as $author) { $model->authors()->save(Worker::find($author));}
        foreach ($data['territories'] as $territory) { $model->territories()->save(Territory::find($territory));}
        foreach ($data['positions'] as $position) { $model->positions()->save(Position::find($position));}
        foreach ($data['departments'] as $department) { $model->departments()->save(Department::find($department));}
        foreach ($data['activities'] as $activity) { $model->activities()->save(Activity::find($activity));}

        Notification::make()
            ->title(__('Saved successfully'))
            ->success()
            ->send();
    }
}
}

