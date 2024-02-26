<?php

namespace App\Http\Livewire;

use App\Mail\NewNonConformance;
use App\Models\User;
use App\Models\Checklist;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithFileUploads;

class Nonconformance extends Component
{
  use WithFileUploads;

  public $unique;
  public $auditee;
  public $auditeeN;
  public $site;
  public $department;
  public $number;
  public $date;
  public $auditor, $users;
  public $clause;
  public $checkbox;
  public $report;
  public $file, $selectedTask;
  public $auditeeMail, $usersArray = [];

  protected $rules = [
    'date' => 'required',
    'number' => 'required',
    'auditor' => 'required',
    'auditeeN' => 'required',
    'site' => 'required',
    'department' => 'required',
    'clause' => 'required',
    'checkbox' => 'required',
    'report' => 'required',
    'file' => 'nullable|max:1024'
  ];

  public function updatedAuditee($auditee)
  {
    array_push($this->usersArray, [1]);
    $selected = User::where('id', $auditee)->first();
    $this->site =  $selected->site;
    $this->auditeeN =  $selected->name;
    $this->department =  $selected->department;
    $this->auditeeMail =  $selected->email;
    $this->unique = rand(10, 10000);
    $this->number =  $this->unique;
  }

  public function save()
  {
    $this->validate();
    $results = auth()->user()->audits()->create([
      'date' => $this->date,
      'number' => $this->number,
      'auditor' => $this->auditor,
      'auditee' => $this->auditeeN,
      'site' => $this->site,
      'department' => $this->department,
      'clause' => $this->clause,
      'checkbox' => $this->checkbox,
      'report' => $this->report,
      'response_id' => $this->auditee,
      'checklist_id' => $this->selectedTask,
    ]);

    $this->file =  Session::get('Fname');
    if ($this->file != '') {
      $done = $results->images()->Create([
        'file' => Session::get('location') . '/' . $this->file,
      ]);
      Session::forget('Fname', 'location');
    }

    Checklist::findOrFail($this->selectedTask)->update(['car' => true]);
    Mail::to($this->auditeeMail)->send(new NewNonConformance($this->auditeeN, auth()->user()));

    $this->dispatchBrowserEvent('alert', [
      'type' => 'success',  'message' => 'Nonconformance Created.'
    ]);
    return redirect()->to('/My-Tasks');
  }

  public function mount()
  {
    $this->users = User::all();
    $this->auditor = auth()->user()->name;
    $this->date = Carbon::now()->toDateString();
  }

  public function render()
  {
    return view('livewire.nonconformance');
  }
}
