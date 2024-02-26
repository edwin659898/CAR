<?php

namespace App\Http\Livewire;

use App\Models\Audits;
use Livewire\Component;

class LogCar extends Component
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

    public function update()
    {
        $validated = $this->validate([
            'mt_comment' => 'nullable',
            'hr_comment' => 'nullable',
            'communication_comment' => 'nullable',
            'final_comment' => 'nullable',
        ]);

        if ($this->mt_comment != '' || $this->hr_comment != '' || $this->communication_comment != '') {
            Audits::findOrFail($this->selected)->update([
                'mt_comment' => $this->mt_comment,
                'communication_comment' => $this->communication_comment,
                'hr_comment' => $this->hr_comment,
                'final_comment' => $this->final_comment,
            ]);
            
            $this->dispatchBrowserEvent('alert',[
                'type' => 'success',  'message' => 'Comment saved Successfully!'
            ]);
        }
    }

    public function change()
    {
        $validated = $this->validate([
            'new_date' => 'required',
        ]);

        Audits::findOrFail($this->selected)->update([
            'followup_end_date' => $this->new_date,
        ]);
        $this->reset('new_date');
        session()->flash('message', 'Date Updated');
    }

    public function close($id)
    {
        $to_close = Audits::findOrFail($id);
        abort_if(
            !auth()->user()->RA && $to_close->hr_comment == null && $to_close->communication_comment == null,
            403,
            'Unauthorized action'
        );
        $to_close->update(['status' => 'closed']);
        session()->flash('message', 'CAR Closed');
        return redirect()->to('/CAR-Logs');
    }

    public function render()
    {
        $nonConformance = Audits::with('responses', 'creator', 'manager', 'HODs', 'sayings', 'images')->findOrFail($this->selected);
        return view('livewire.log-car', [
            "nonConformance" => $nonConformance,
        ]);
    }
}
