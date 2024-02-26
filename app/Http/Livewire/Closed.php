<?php

namespace App\Http\Livewire;

use App\Models\Audits;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class Closed extends LivewireDatatable
{
    public $exportable = true;
    public function builder()
    {
        return Audits::query()
        ->where('status','=','closed');
    }

    public function columns()
    {
        return[
            NumberColumn::name('id')->label('#')->defaultSort('desc'),
            Column::name('number')->label('CAR No')->searchable(),
            Column::name('site')->label('Site')->filterable()->searchable(),
            Column::name('auditor')->label('Auditor')->filterable(),
            Column::name('auditee')->label('Auditee')->filterable(),
            Column::name('department')->label('Department')->filterable(),
            Column::callback(['id'], function ($id) {
                return view('livewire.closed', ['id' => $id]);
            })->excludeFromExport()
        ];
    }
}