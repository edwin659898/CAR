<div class="content-wrapper">
    @section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css" />
    @endsection
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-4">
                    <h5 class="m-0 text-green-500  text-lg">Car FSC Logs</h5>
                </div><!-- /.col -->
                <div class="col-sm-4 flex justify-center">
                    <svg class="mt-0.5 stroke-current h-9 w-9 animate-spin text-gray-400" wire:loading="wire:loading" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <div class="col-sm-4">
                    <ol class="breadcrumb float-sm-right text-sm">
                        <li class="breadcrumb-item active"><a href="{{route('closed.car')}}" class="font-bold">Closed CARs</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="max-w-md mx-auto sm:max-w-7xl">

                        <x-success-message />
                        <section class="m-1 p-2 w-12/12 flex flex-col rounded border sm:pt-0 text-sm">
                            <!-- <x-auth-validation-errors class="mb-4" :errors="$errors" /> -->

                            <div class="flex ml-1">
                                <a href="{{route('admin.car.logs')}}">
                                    <span class="cursor-pointer flex items-center" style="line-height: 32px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0019 16V8a1 1 0 00-1.6-.8l-5.333 4zM4.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0011 16V8a1 1 0 00-1.6-.8l-5.334 4z" />
                                        </svg> Go back</span>
                                </a>
                            </div>

                            <div class="sm:min-w-screen flex items-center justify-between mt-2 mb-3">
                                <section class="lg:w-2/12">
                                </section>
                                <section class="lg:w-8/12 sm:w-full">
                                    <div class="rounded bg-white overflow-hidden shadow-md px-2 py-2">

                                        <header class="flex justify-center">
                                            <img class="w-12 h-12 rounded-full" src="{{asset('/storage/logo.png')}}" alt="logo image" />
                                            <h5 class="mt-2.5 font-bold">Monitoring and Evaluation Department</h5>
                                        </header>
                                        <div class="flex justify-center">
                                            <h6 class="mt-2 font-bold">Corrective Action Report</h6>
                                        </div>
                                        <div class="flex justify-center space-x-1 mt-3">
                                            <label for="disabledSelect" class="text-green-500">Status:</label>
                                            <p class="form-control-static font-bold text-blue-700">{{$nonConformance->status}}</p>
                                        </div>

                                        <section class="p-2 w-full border rounded">
                                            <div class="rounded border py-3 px-3">

                                                <div class="flex justify-between">
                                                    <div>
                                                        <label class="text-green-500">Company</label>
                                                        <p class="form-control-static">Better Globe<br>Forestry</p>
                                                    </div>
                                                    <div>
                                                        <label class="text-green-500">Date</label>
                                                        <p class="form-control-static">{{$nonConformance->date}}</p>
                                                    </div>
                                                    <div>
                                                        <label class="text-green-500">CAR Number</label>
                                                        <p class="form-control-static">{{$nonConformance->number}}</p>
                                                    </div>
                                                    <div>
                                                        <label class="text-green-500">Type</label>
                                                        <p class="form-control-static">{{$nonConformance->checkbox}}</p>
                                                    </div>
                                                </div>


                                                <div class="flex justify-between">
                                                    <div>
                                                        <label class="text-green-500">Auditor</label>
                                                        <p class="form-control-static">{{$nonConformance->auditor}}</p>
                                                    </div>
                                                    <div>
                                                        <label class="text-green-500">Auditee</label>
                                                        <p class="form-control-static">{{$nonConformance->auditee}}</p>
                                                    </div>
                                                    <div>
                                                        <label class="text-green-500">Department</label>
                                                        <p class="form-control-static">{{$nonConformance->department}}</p>
                                                    </div>
                                                    <div>
                                                        <label class="text-green-500">Site</label>
                                                        <p class="form-control-static">{{$nonConformance->site}}</p>
                                                    </div>
                                                </div>

                                                <div class="mt-2 flex justify-between">
                                                    <div>
                                                        <label for="disabledSelect" class="text-green-500">Reference</label>
                                                        <p class="form-control-static">{{$nonConformance->clause}}</p>
                                                    </div>

                                                    <div>
                                                        <label for="disabledSelect" class="text-green-500">Name of the Farmer</label>
                                                        <p class="form-control-static">{{$nonConformance->name}}</p>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="rounded border mt-2 py-3 px-4">
                                                <div>
                                                    <label for="disabledSelect" class="text-green-500">Non Conformance</label>
                                                    <p class="form-control-static">{!!$nonConformance->report!!}</p>
                                                </div>
                                            </div>

                                            <div class="rounded border mt-2 py-3 px-4">
                                                <label for="disabledSelect" class="text-green-500">Evidence</label>
                                                @forelse ($nonConformance->images as $attach)
                                                <p class="form-control-static">
                                                    <a href="{{route('view.file',$attach->id)}}" target="_blank">{{$attach->file}}</a>
                                                </p>
                                                @empty
                                                <p>No Evidence was attached</p>
                                                @endforelse
                                            </div>

                                            <h5 class="text-blue-700 mt-2 py-3 px-4">Auditees Response</h5>
                                            @forelse($nonConformance->responses as $solution)
                                            @if($solution->owner == 'auditee')
                                            <div class="rounded border mt-2 py-3 px-4">
                                                <div class="flex justify-between">
                                                    <div>
                                                        <label class="text-green-500">Cause {{$loop->iteration}}</label>
                                                        <p class="form-control-static">{{$solution->cause}}</p>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label class="text-green-500">Proposed Corrective Action {{$loop->iteration}}</label>
                                                    <p class="form-control-static">{{$solution->proposed_solution}}</p>
                                                </div>
                                                <div>
                                                    <label class="text-green-500">Proposed Completion Date {{$loop->iteration}}</label>
                                                    <p class="form-control-static">{{$solution->proposed_date}}</p>
                                                </div>
                                            </div>
                                            @endif
                                            @empty
                                            <div class="rounded border mt-2 py-3 px-4">
                                                <span class="text-red-600">No response added yet</span>
                                            </div>
                                            @endforelse

                                            <h5 class="text-blue-700 mt-2 py-3 px-4">Manager Response</h5>
                                            @foreach($nonConformance->responses as $solution)
                                            @if($solution->owner == 'HOD')
                                            <div class="rounded border mt-2 py-3 px-4">
                                                <div class="flex justify-between">
                                                    <div>
                                                        <label class="text-green-500">Cause</label>
                                                        <p class="form-control-static">{{$solution->cause}}</p>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label class="text-green-500">Proposed Corrective Action</label>
                                                    <p class="form-control-static">{{$solution->proposed_solution}}</p>
                                                </div>
                                                <div>
                                                    <label class="text-green-500">Proposed Completion Date</label>
                                                    <p class="form-control-static">{{$solution->proposed_date}}</p>
                                                </div>
                                            </div>
                                            @endif
                                            @endforeach
                                            @if($nonConformance->manager_date != '')
                                            <div class="rounded border mt-2 py-3 px-4">
                                                <div class="flex justify-between">
                                                    <div>
                                                        <label class="text-green-500">Manager Signature</label>
                                                        <p class="form-control-static">{{$nonConformance->manager->name}}</p>
                                                    </div>
                                                    <div>
                                                        <label class="text-green-500">Date</label>
                                                        <p class="form-control-static">{{$nonConformance->manager_date}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            @if($nonConformance->hod_id != '')
                                            <div class="mt-2 flex space-x-2 rounded border py-3 px-4">
                                                <div class="flex-1">
                                                    <span class="text-green-500 font-bold">HOD Name</span>
                                                    <p class="form-control-static">{{App\Models\User::find($nonConformance->hod_id)->name}}</p>
                                                </div>
                                                <div class="flex-1">
                                                    <Span class="text-green-500 font-bold">HOD Comment</span>
                                                    <p class="form-control-static">{{$nonConformance->comment}}</p>
                                                </div>
                                            </div>
                                            @endif

                                            @if($nonConformance->status == 'follow up')
                                            <div class="mt-2 flex space-x-2 rounded border py-3 px-4">
                                                <div class="flex-1">
                                                    <span class="text-green-500 font-bold">Follow Up By</span>
                                                    <p class="form-control-static">{{App\Models\User::find($nonConformance->followup_id)->name}}</p>
                                                </div>
                                                <div class="flex-1">
                                                    <Span class="text-green-500 font-bold">Start Follow-up date</span>
                                                    <p class="form-control-static">{{$nonConformance->followup_date}}</p>
                                                </div>
                                                <div class="flex-1">
                                                    <Span class="text-green-500 font-bold">End Follow-up date</span>
                                                    <p class="form-control-static">{{$nonConformance->followup_end_date}}</p>
                                                    <h5 data-toggle="modal" data-target="#exampleModal" class="badge badge-warning cursor-pointer uppercase">Update Date</h5>
                                                </div>
                                            </div>

                                            <div class="mt-2 rounded border py-3 px-4">
                                                <Span class="text-green-500 font-bold">Follow Up Observations</span>
                                                @forelse($nonConformance->sayings as $follow)
                                                <div class="flex justify-between">
                                                    {{$loop->iteration}}
                                                    <span class="w-10/12 ml-1">{{$follow->saying}}</span>
                                                    <span class="w-2/12">{{$follow->created_at->format('d-m-Y')}}</span>
                                                </div>
                                                @empty
                                                <p class="text-red-500">No Observations recorded yet</p>
                                                @endforelse
                                            </div>
                                            @endif

                                            @if($communication_comment != '')
                                            <div class="mt-2 flex space-x-2 rounded border py-3 px-4">
                                                <div class="flex-1">
                                                    <Span class="text-green-500 font-bold">Communication Comment</span>
                                                    <p class="form-control-static">{!!$communication_comment!!}</p>
                                                </div>
                                            </div>
                                            @endif

                                            @if($hr_comment != '')
                                            <div class="mt-2 flex space-x-2 rounded border py-3 px-4">
                                                <div class="flex-1">
                                                    <Span class="text-green-500 font-bold">HR Comment</span>
                                                    <p class="form-control-static">{!! $hr_comment!!}</p>
                                                </div>
                                            </div>
                                            @endif

                                            @if($mt_comment != '')
                                            <div class="mt-2 flex space-x-2 rounded border py-3 px-4">
                                                <div class="flex-1">
                                                    <Span class="text-green-500 font-bold">HOD Comment</span>
                                                    <p class="form-control-static">{!! $mt_comment !!}</p>
                                                </div>
                                            </div>
                                            @endif

                                            @if($final_comment != '')
                                            <div class="mt-2 flex space-x-2 rounded border py-3 px-4">
                                                <div class="flex-1">
                                                    <Span class="text-green-500 font-bold">Final Comment</span>
                                                    <p class="form-control-static">{!! $final_comment !!}</p>
                                                </div>
                                            </div>
                                            @endif

                                            <div class="pt-4 flex justify-between">
                                                <button onclick="confirm('Are you sure of Closing?') || event.stopImmediatePropagation()" wire:click.prevent="close({{ $nonConformance->id }})" class="items-center cursor-pointer px-3 py-2 bg-blue-500 border  rounded-md  text-xs 
                                                    text-white hover:bg-blue-800 focus:outline-none focus:border-gray-900
                                                    focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                                    Close
                                                </button>
                                                <x-button id="submit" type="submit"> Save </x-button>
                                            </div>

                                        </section>
                                        <!-- footer -->
                                    </div>

                                </section>
                                <section class="lg:w-2/12">

                                </section>

                            </div>

                        </section>

                    </div>


                </div>
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>


    <!-- /.content -->
</div>