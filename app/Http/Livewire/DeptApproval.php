<?php

namespace App\Http\Livewire;

use App\Mail\HODRejected;
use App\Mail\HODResponded;
use App\Models\Audits;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;

class DeptApproval extends Component
{
    use WithPagination;
    
    public $Selectedsite;
    public $search = "";
    public $data = 0;
    public $dateMade, $number, $checkbox, $auditor, $auditee, $site, $department;
    public $clause, $files, $status, $nonconformance, $report_id;
    public $solutions;
    public $cause, $proposed_solution, $proposed_date, $received;
    public $decision, $HODcomment, $respondent, $auditorEmail;
    public $manager, $manager_date;
    public $hr_comment, $communication_comment, $mt_comment, $final_comment;

    public function respond($id)
    {
        $this->received = Audits::with('responses', 'creator', 'manager')->where('id', $id)->first();
        $this->dateMade = $this->received->date;
        $this->number = $this->received->number;
        $this->respondent = $this->received->response_id;
        $this->checkbox = $this->received->checkbox;
        $this->auditor = $this->received->creator->name;
        $this->auditorEmail = $this->received->creator->email;
        $this->auditee = $this->received->auditee;
        $this->site = $this->received->site;
        $this->department = $this->received->department;
        $this->clause = $this->received->clause;
        $this->status = $this->received->status;
        $this->nonconformance = $this->received->report;
        $this->report_id = $this->received->id;
        $this->files = $this->received->images;
        $this->solutions = $this->received->responses;
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
        $this->reset('data', 'received');
    }

    public function update()
    {
        $validatedDate = $this->validate([
            'decision' => 'required',
        ]);

        $this->received->update([
            'status' => $this->decision, 'hod_date' => Carbon::now()->toDateString(),
            'comment' => $this->HODcomment, 'hod_id' => auth()->id()
        ]);
        $AuditeeMail = User::findOrFail($this->respondent)->email;
        if ($this->decision == 'HOD approved') {
            Mail::to($AuditeeMail)->cc('frederick.och@betterglobeforestry.com', 'diana@betterglobeforestry.com')
                ->send(new HODResponded($this->auditee, auth()->user()));
        } else {
            Mail::to($AuditeeMail, $this->auditorEmail, $this->manager->email)->send(new HODRejected($this->auditee, auth()->user()));
        }
        $this->reset(['decision', 'HODcomment', 'received', 'data']);
        session()->flash('message', 'Updated and sent to Manager,Auditee and Initiator');
    }


    public function render()
    {
        return view('livewire.dept-approval', [
             'conformances' => Audits::where('department', $this->Selectedsite)
             ->where('status', 'Manager responded')
             ->when($this->search, function ($query) {
                 $query->where(function ($subquery) {
                     $subquery->where('auditee', 'like', '%' . $this->search . '%')
                         ->orWhere('number', 'like', '%' . $this->search . '%')
                         ->orWhere('date', 'like', '%' . $this->search . '%');
                 });
             })
             ->where(function ($query) {
                 $query->where(function ($subquery) {
                     $subquery->where('checkbox', 'Major')
                         ->where(function ($subsubquery) {
                             $subsubquery->whereNotNull('hr_comment')
                                 ->WhereNotNull('communication_comment');
                         });
                 })
                 ->orWhere(function ($subquery) {
                     $subquery->where('checkbox', 'Minor');
                 });
             })
             ->latest()
             ->paginate(10)
        
        ]);
    }
}
