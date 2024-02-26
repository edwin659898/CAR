<?php

namespace App\Http\Livewire;

use App\Models\Audits;
use App\Models\FollowUpdate;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class FollowUp extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $data = 0;
    public $dateMade, $number, $checkbox, $auditor, $auditee, $site, $department;
    public $clause, $files, $status, $nonconformance, $report_id;
    public $solutions;
    public $cause, $proposed_solution, $proposed_date, $received;
    public $decision, $HODcomment;
    public $hodName;
    public $assigned_to, $date_to_monitor, $followDate, $EndfollowDate;
    public $saying, $followUpdateData, $evidence, $file;
    public $manager, $manager_date;
    public $hr_comment, $communication_comment, $mt_comment, $final_comment;

    public function respond($id)
    {
        $this->received = Audits::with('responses', 'creator', 'manager', 'HODs', 'sayings', 'images')->where('id', $id)->first();
        $this->dateMade = $this->received->date;
        $this->number = $this->received->number;
        $this->checkbox = $this->received->checkbox;
        $this->auditor = $this->received->creator->name;
        $this->auditee = $this->received->auditee;
        $this->site = $this->received->site;
        $this->department = $this->received->department;
        $this->clause = $this->received->clause;
        $this->status = $this->received->status;
        $this->nonconformance = $this->received->report;
        $this->report_id = $this->received->id;
        $this->files = $this->received->images;
        $this->solutions = $this->received->responses;
        $this->hodName = $this->received->HODs->name;
        $this->HODcomment = $this->received->comment;
        $this->followDate = $this->received->followup_date;
        $this->EndfollowDate = $this->received->followup_end_date;
        $this->followUpdateData = $this->received->sayings;
        $this->manager = $this->received->manager;
        $this->manager_date = $this->received->manager_date;
        $this->communication_comment = $this->received->communication_comment;
        $this->hr_comment = $this->received->hr_comment;
        $this->mt_comment = $this->received->mt_comment;
        $this->final_comment = $this->received->final_comment;
        $this->data = 1;
        $this->dispatchBrowserEvent('reinit');
    }

    public function back()
    {
        $this->reset();
    }

    public function close()
    {
        $this->received->update(['status' => 'closed']);
        $this->reset();
        $this->dispatchBrowserEvent('alert',[
            'type' => 'success',  'message' => 'CAR Closed!'
        ]);
    }


    public function remove($id)
    {
        $Follow_comment =  FollowUpdate::findOrFail($id);
        $filename = $Follow_comment->file;

        if ($filename != '') {
            $path = storage_path('app/public/images/' . $filename);
            if ($path) {
                unlink($path);
            }
        }

        $Follow_comment->delete();
        $this->reset();
        session()->flash('message', 'Deleted');
        $this->dispatchBrowserEvent('reinit');
    }

    public function update()
    {
        $validated = $this->validate([
            'saying' => 'required',
        ]);

        $givenfollowup = FollowUpdate::create($validated + ['user_id' => auth()->id(), 'audit_id' => $this->report_id]);
        $this->file =  Session::get('Fname');
        if ($this->file != '') {
            $givenfollowup->update([
                'file' => Session::get('location') . '/' . $this->file,
            ]);
            Session::forget('Fname', 'location');
        }

        $this->reset('saying');
        $this->respond($this->report_id);
        $this->dispatchBrowserEvent('reinit');
        session()->flash('message', 'Commented successfully');
    }

    public function render()
    {
        return view('livewire.follow-up', [
            'conformances' => Audits::where([['status', '=', 'follow up'], ['followup_id', '=', auth()->id()]])
                ->latest()
                ->paginate(10),
        ]);
    }
}
