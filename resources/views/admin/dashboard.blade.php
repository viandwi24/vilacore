@extends('layouts.admin')

@section('title', admin()->getAdminTitlePage('Dashboard'))

@section('content.header')
    {!! admin()->contentHeader('Dashboard', [['name' => 'Admin'], ['name' => 'Dashboard', 'active' => '']]) !!}          
@stop

@section('content')
    {!! admin()->getDashboardInfoBox() !!}
    
    @foreach (admin()->getDashboardWidget() as $item)
        {{-- <h4 style="margin-top: 25px;">
            <i style="font-size: 1.3rem;" class="fas fa-chevron-circle-right"></i>
            Page Edit
        </h4><hr> --}}
        <div class="row">
            <div class="col-12">
                @include($item)
            </div>
        </div>        
    @endforeach
    @if (count(admin()->getDashboardWidget()) == 0)
        <div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
            Widget kosong, anda bisa membuat Widget untuk Dashboard ini dengan Plugin!
        </div>
    @endif
@stop