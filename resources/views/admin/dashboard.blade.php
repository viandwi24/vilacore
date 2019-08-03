@extends('layouts.admin')

@section('content.header')
    {!! admin()->contentHeader('Dashboard', [['name' => 'Admin'], ['name' => 'Dashboard', 'active' => '']]) !!}          
@stop

@section('content')
    {!! admin()->getDashboardInfoBox() !!}
    
    @foreach (admin()->getDashboardWidget() as $item)
        <div class="row">
            <div class="col-12">
                @include($item)
            </div>
        </div>        
    @endforeach
@stop