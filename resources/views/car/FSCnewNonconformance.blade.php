@extends('layouts.parent')

@section('content')

   @livewire('FSCnonconformance',['selectedTask' => $selectedTask])

@endsection