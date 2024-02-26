<?php

namespace App\Http\Livewire;

use App\Mail\NewNonConformance;
use App\Models\Audits;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Livewire\WithFileUploads;

use Livewire\Component;

class NonIdNonconformance extends Component
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
  public $file;
  public $auditeeMail, $usersArray = [];

  protected $rules = [
    'date' => 'required',
    'auditor' => 'required',
    'clause' => 'required',
    'checkbox' => 'required',
    'report' => 'required',
    'file' => 'nullable|max:1024'
  ];

  public function mount()
  {
    $this->users =  User::where('auditee', true)->orderBy('name', 'asc')->get();
    $this->auditor = auth()->user()->name;
    $this->date = Carbon::now()->toDateString();
  }

  public function updatedAuditee($auditee)
  {
    if (!is_null($auditee)) {
      $selected = User::where('id', $auditee)->first();
      $this->site =  $selected->site;
      $this->auditeeN =  $selected->name;
      $this->department =  $selected->department;
      $this->auditeeMail =  $selected->email;
      $this->unique = rand(10, 10000);
      $this->number =  $this->unique;
      array_push($this->usersArray, [$this->auditeeN, $this->site, $this->department, $this->number, $this->auditeeMail, $auditee]);
      $this->reset('auditee', 'site', 'auditeeN', 'department', 'auditeeMail', 'number');
    }
  }

  public function unsetting($index)
  {
    unset($this->usersArray[$index]);
  }

  public function save()
  {
    $this->validate();
    if (!empty($this->usersArray)) {
      foreach ($this->usersArray as $index => $chosen) {
        $results = auth()->user()->audits()->create([
          'date' => $this->date,
          'number' => $chosen[3],
          'auditor' => $this->auditor,
          'auditee' => $chosen[0],
          'site' => $chosen[1],
          'department' => $chosen[2],
          'clause' => $this->clause,
          'checkbox' => $this->checkbox,
          'report' => $this->report,
          'response_id' => $chosen[5],
        ]);

        $this->file =  Session::get('Fname');
        if ($this->file != '') {
          $done = $results->images()->Create([
            'file' => Session::get('location') . '/' . $this->file,
          ]);
          Session::forget('Fname', 'location');
        }

        Mail::to($chosen[4])->send(new NewNonConformance($chosen[0], auth()->user()));
      }

      $this->dispatchBrowserEvent('alert', [
        'type' => 'success',  'message' => 'Nonconformance Created.'
      ]);
      return redirect()->to('/Auditee-Response');
    }
  }


  public function render()
  {
    return view('car.non-id-nonconformance');
  }
}
