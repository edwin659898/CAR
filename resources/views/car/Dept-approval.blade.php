@extends('layouts.parent')

@section('content')

   @livewire('dept-approval',['Selectedsite' => $Selectedsite])

@endsection