<?php

namespace App\Http\Livewire;

use App\Mail\HODNotify;
use App\Mail\HODRejected;
use App\Mail\HODResponded;
use App\Models\Audits;
use App\Models\Response;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;

class HODResponse extends Component
{
    use WithPagination;

    public $Selectedsite;
    public $search = "";
    public $data = 0;
    public $dateMade, $number, $checkbox, $auditor, $auditee, $site, $department;
    public $clause, $files, $status, $nonconformance, $report_id;
    public $solutions;
    public $cause, $proposed_solution, $proposed_date, $received;
    public $respondent, $auditorEmail;
    public $hr_comment, $communication_comment, $mt_comment, $final_comment;

    public function respond($id)
    {
        $this->received = Audits::with('responses', 'creator')->where('id', $id)->first();
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
        abort_if($this->received->response_id == auth()->id(), 403);
        $this->received->update([
            'status' => 'Manager responded',
            'manager_date' => Carbon::now()->toDateString(),
            'manager_id' => auth()->id()
        ]);
        $data = [
            'intro'  => 'Dear HOD ' . auth()->user()->department . ',',
            'content'   => 'New Non-conformance:' . $this->number . 'has been submitted for your review by ' . auth()->user()->name . ' Logon to the system for action',
            'email' => auth()->user()->HOD,
            'subject'  => 'New Non Conformance for you review'
        ];
        Mail::send('emails.email', $data, function ($message) use ($data) {
            $message->to($data['email'])
                ->subject($data['subject']);
        });
        session()->flash('message', 'Updated and sent to HOD for review');
    }

    public function answers()
    {
        $store = audits::find($this->report_id);
        abort_if($store->response_id == auth()->id(), 403);
        $validatedDate = $this->validate([
            'cause' => 'required',
            'proposed_solution' => 'required',
            'proposed_date' => 'required',
        ]);
        if ($this->report_id) {
            $store->responses()->Create([
                'cause' => $this->cause,
                'proposed_solution' => $this->proposed_solution,
                'proposed_date' => $this->proposed_date,
                'owner' => 'HOD',
            ]);
            $this->respond($this->report_id);
            session()->flash('message', 'response updated.Add another if you wish to');
            $this->reset('cause', 'proposed_solution', 'proposed_date');
        }
    }

    public function destroy($id)
    {
        Response::findOrFail($id)->delete();
        $this->respond($this->report_id);
        $this->dispatchBrowserEvent('alert',[
            'type' => 'success',  'message' => 'response Deleted!'
        ]);

    }

    public function render()
    {
        return view('livewire.h-o-d-response', [
            'conformances' => Audits::where([['department', '=', $this->Selectedsite], ['status', '=', 'Auditee responded']])
                ->orWhere([['department', '=', $this->Selectedsite], ['status', '=', 'HOD declined']])
                ->when($this->search != '', function ($query) {
                    $query->where([['auditee', 'like', '%' . $this->search . '%'], ['department', '=', $this->Selectedsite], ['status', '=', 'Auditee responded']])
                        ->orwhere([['number', 'like', '%' . $this->search . '%'], ['department', '=', $this->Selectedsite], ['status', '=', 'Auditee responded']])
                        ->orwhere([['date', 'like', '%' . $this->search . '%'], ['department', '=', $this->Selectedsite], ['status', '=', 'Auditee responded']]);
                })
                ->latest()
                ->paginate(10),
        ]);
    }
}
