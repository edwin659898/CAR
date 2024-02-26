<?php

namespace App\Exports;

use App\Models\WeeklyPlan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class WeeklyPlansExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return WeeklyPlan::latest()->get();
    }

    public function map($plan) : array {
        return [
            $plan->id,
            $plan->date,
            $plan->activityParent->MonitoringActivities?->list,
            $plan->userowner?->name,
            $plan->site,
            $plan->inspected,
            $plan->findings,
            $plan->comment,
            $plan->inspected == 'yes' ? 'completed' : 'pending',
        ] ;
 
    }

    public function headings() : array {
        return [
            '#',
            'Plan for',
            'Activity',
            'Assigned to',
            'Site',
            'Inspected',
            'Findings',
            'Reviwer Comments',
            'Task Status',
        ] ;
    }
}
