<?php

namespace App\Http\Livewire;

use App\Models\FSCAudits;
use Livewire\Component;

class AdminLogCarFSC extends Component
{
    public $selected;
    public $mt_comment, $new_date, $communication_comment, $hr_comment, $final_comment;

    public function mount($id)
    {
        $this->selected = $id;
        $audit = FSCAudits::find($id);
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
        $to_close = FSCAudits::findOrFail($id);
        abort_if($to_close->checkbox == 'Major',403,'Unauthorized action');
        
        $to_close->update(['status' => 'closed']);
        session()->flash('message', 'CAR FSC Closed');
        return redirect()->to('/CAR-FSCLogs');
    }

    public function render()
    {
        $nonConformance = FSCAudits::with('responses', 'nusery',  'creator', 'manager', 'HODs', 'sayings', 'images')->findOrFail($this->selected);
        return view('livewire.admin-log-carFSC', [
            "nonConformance" => $nonConformance,
        ]);
    }
}
