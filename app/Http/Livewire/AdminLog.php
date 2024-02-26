<?php

namespace App\Http\Livewire;

use App\Models\Audits;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class AdminLog extends LivewireDatatable
{
    public $exportable = true;
    public function builder()
    {
        return Audits::query()
         ->where('status','!=','closed');
    }

    public function columns()
    {
        return [
            NumberColumn::name('id')->label('#')->defaultSort('desc'),
            Column::name('number')->label('CAR No')->searchable(),
            DateColumn::name('created_at')->label('Date Created')->filterable()->format('Y-m-d'),
            Column::name('site')->label('Site')->filterable()->searchable(),
            Column::name('auditor')->label('Auditor')->filterable(),
            Column::name('auditee')->label('Auditee')->filterable(),
            Column::callback(['id'], function ($id) {
                return view('livewire.admin-log', ['id' => $id]);
            })->excludeFromExport(),
            Column::name('department')->label('Department')->filterable(),
            Column::name('status')->label('Status')->searchable()->filterable(),
            Column::name('responses.proposed_date')->label('Completion Date')->filterable(),
        ];
    }
}
