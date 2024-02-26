<?php

namespace App\Http\Livewire;

use App\Models\activity_in_site;
use App\Models\MonitoringActivity;
use App\Models\User;
use App\Models\WeeklyPlan;
use App\Models\Weeks;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class ViewYearPlan extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $current, $currentYear;
    public $newActivity;
    public $assign = false;
    public $activity_in_sites_id, $user_id, $date, $site;

    public function selected($plan)
    {
        abort_if(auth()->user()->site != $plan['site'] && auth()->user()->head == false, 403);
        $this->reset('assign');
        $this->current = $plan['id'];
    }

    public function mount()
    {
        $this->currentYear = Carbon::now()->year;
    }

    public function next()
    {
        $this->reset('current');
        $this->resetPage();
        $this->currentYear++;
    }

    public function previous()
    {
        $this->reset('current');
        $this->resetPage();
        $this->currentYear--;
    }

    public function remove($id)
    {
        abort_if(!auth()->user()->LA, 403, 'unauthorised action');
        $this->reset('assign');
        $activity = activity_in_site::findorFail($id);
        $activity->userplan()->delete();
        $activity->delete();
        session()->flash('message', 'Deleted.');
    }

    public function addNew()
    {
        abort_if(!auth()->user()->LA, 403, 'unauthorised action');
        $this->reset('assign');
        $data = $this->validate([
            'newActivity' => 'required',
        ]);
        activity_in_site::create([
            'site_in_weeks_id' => $this->current,
            'todos' => $this->newActivity
        ]);
        $this->reset('newActivity');

        session()->flash('message', 'New one added.');
    }

    public function assign($id)
    {
        abort_if(!auth()->user()->LA, 403, 'unauthorised action');
        $this->assign = true;
        $this->activity_in_sites_id = $id;
    }

    public function assignTask()
    {
        abort_if(!auth()->user()->LA, 403, 'unauthorised action');
        $plan = $this->validate([
            'user_id' => 'required',
            'date' => 'required',
        ]);

        $this->site = User::findOrFail($this->user_id)->site;

        $UserWeeklyPlan = WeeklyPlan::where('activity_in_sites_id', '=', $this->activity_in_sites_id)->first();

        if ($UserWeeklyPlan != '') {
            $UserWeeklyPlan->update($plan + [
                'activity_in_sites_id' => $this->activity_in_sites_id,
                'site' => $this->site
            ]);
        } else {
            WeeklyPlan::Create($plan + [
                'activity_in_sites_id' => $this->activity_in_sites_id,
                'site' => $this->site
            ]);
        }

        $this->reset(['user_id', 'date', 'assign', 'activity_in_sites_id', 'site']);
    }

    public function Unassign($id)
    {
        abort_if(!auth()->user()->LA, 403, 'unauthorised action');
        $task = WeeklyPlan::where('activity_in_sites_id', '=', $id)->first();
        $task->checks()->delete();
        $task->delete();
        $task = activity_in_site::findOrFail($id)->update(['checked' => false]);
    }

    public function render()
    {
        return view('car.view-year-plan', [
            'plans' => Weeks::with(['sitess' => function ($q) {
                $q->whereYear('created_at', $this->currentYear);
            }])->paginate(7),
            'todos' => activity_in_site::where('site_in_weeks_id', '=', $this->current)->get(),
            'lists' => MonitoringActivity::all(),
            'Users' => User::where('auditee', true)->get(),
        ]);
    }
}
