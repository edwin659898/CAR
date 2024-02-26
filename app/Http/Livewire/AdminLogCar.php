<?php

namespace App\Http\Livewire;

use App\Models\Audits;
use Livewire\Component;

class AdminLogCar extends Component
{
    public $selected;
    public $mt_comment, $new_date, $communication_comment, $hr_comment, $final_comment;

    public function mount($id)
    {
        $this->selected = $id;
        $audit = Audits::find($id);
        $this->mt_comment = $audit->mt_comment;
        $this->communication_comment = $audit->communication_comment;
        $this->hr_comment = $audit->hr_comment;
        $this->final_comment = $audit->final_comment;
    }

    public function back()
    {
        $this->reset();
    }

    public function close($id)
    {
        $to_close = Audits::findOrFail($id);
        abort_if($to_close->checkbox == 'Major',403,'Unauthorized action');
        
        $to_close->update(['status' => 'closed']);
        session()->flash('message', 'CAR Closed');
        return redirect()->to('/CAR-Logs');
    }

    public function render()
    {
        $nonConformance = Audits::with('responses', 'nusery',  'creator', 'manager', 'HODs', 'sayings', 'images')->findOrFail($this->selected);
        return view('livewire.admin-log-car', [
            "nonConformance" => $nonConformance,
        ]);
    }
}
