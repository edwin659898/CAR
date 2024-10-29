<?php

namespace App\Http\Livewire;

use App\Models\FSCAudits;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class ActionDemoTableFsc extends LivewireDatatable
{
    public $exportable = true;
    public function builder()
    {
        return FSCAudits::query()
         ->where('status','!=','closed')
         ->where('checkbox','=','Major');
    }

    public function columns()
    {
        return [
            NumberColumn::name('id')->label('#')->defaultSort('desc'),
            Column::name('number')->label('CAR No')->searchable(),
            DateColumn::name('created_at')->label('Date Created')->filterable()->format('Y-m-d'),
            Column::name('site')->label('Site')->filterable()->searchable(),
            Column::name('auditor')->label('Auditor')->filterable(),
            Column::name('name')->label('Name')->searchable(),
            Column::name('auditee')->label('Auditee')->filterable(),
            Column::callback(['id'], function ($id) {
                return view('livewire.action-demo-table-fsc', ['id' => $id]);
            })->excludeFromExport(),
            Column::name('department')->label('Department')->filterable(),
            Column::name('status')->label('Status')->searchable()->filterable(),
            Column::name('responses.proposed_date')->label('Completion Date')->filterable(),
        ];
    }
}
