<?php

namespace App\Http\Livewire;

use App\Mail\HODNotify;
use App\Models\Audits;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;

class Response extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = "";
    public $data = 0;
    public $dateMade, $number, $checkbox, $auditor, $auditee, $site, $department;
    public $clause, $files, $status, $nonconformance, $report_id;
    public $solutions;
    public $cause, $proposed_solution, $proposed_date, $received, $hodName, $HODcomment;
    public $followName, $followDate, $EndfollowDate;
    public $followUpdateData, $HODMail, $respondent;
    public $manager, $manager_date;
    public $hr_comment, $communication_comment, $mt_comment, $final_comment;

    public function respond($id)
    {
        $this->received = Audits::with('responses', 'creator', 'manager', 'HODs', 'sayings', 'images')->where('id', $id)->first();
        $this->dateMade = $this->received->date;
        $this->number = $this->received->number;
        $this->respondent = $this->received->response_id;
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
        $this->hodName = $this->received->hod_id;
        $this->HODcomment = $this->received->comment;
        $this->followName = $this->received->followup_id;
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
    }

    public function back()
    {
        $this->reset();
    }

    public function update()
    {
        $this->received->update(['status' => 'Auditee responded', 'response_date' => Carbon::now()->toDateString()]);
        $this->HODMail = User::findOrFail($this->respondent)->HOD;
        Mail::to($this->HODMail)->send(new HODNotify($this->HODMail, $this->number, $this->auditee));
        $this->reset();
        session()->flash('message', 'Updated and sent to Manager');
    }

    public function answers()
    {
        $validatedDate = $this->validate([
            'cause' => 'required',
            'proposed_solution' => 'required',
            'proposed_date' => 'required',
        ]);
        if ($this->report_id) {
            $store = Audits::find($this->report_id);
            $store->responses()->Create([
                'cause' => $this->cause,
                'proposed_solution' => $this->proposed_solution,
                'proposed_date' => $this->proposed_date,
                'owner' => 'auditee',
            ]);
            $this->respond($this->report_id);
            $this->dispatchBrowserEvent('alert', [
                'type' => 'success',  'message' => 'response updated.Add another if you wish to'
            ]);
            $this->reset('cause', 'proposed_solution', 'proposed_date');
        }
    }


    public function render()
    {
        if (auth()->user()->RA) {
            $confomances = Audits::latest()->where('status','pending')
                ->when($this->search != '', function ($query) {
                    $query->where('auditee', 'like', '%' . $this->search . '%')
                        ->orwhere('number', 'like', '%' . $this->search . '%')
                        ->orwhere('date', 'like', '%' . $this->search . '%');
                })
                ->paginate(9);
        } else {
            $confomances = Audits::where('user_id', '=', auth()->id())->where('status', 'pending')
                ->when($this->search != '', function ($query) {
                    $query->where([['auditee', 'like', '%' . $this->search . '%'], ['user_id', '=', auth()->id()]])
                        ->orwhere([['number', 'like', '%' . $this->search . '%'], ['user_id', '=', auth()->id()]])
                        ->orwhere([['date', 'like', '%' . $this->search . '%'], ['user_id', '=', auth()->id()]]);
                })
                ->latest()
                ->paginate(9);
        }

        return view('car.response', [
            'conformances' => $confomances
        ]);
    }
}
