@extends('layouts.admin')

@section('title', admin()->getAdminTitlePage('Error - Homepage'))

@section('content.header')
    {!! admin()->contentHeader('Error', [['name' => 'Admin'], ['name' => 'Homepage', 'active' => '']]) !!}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                Fitur ini membutuhkan Plugin <b>Page Editor [pageEdit]</b> untuk dapat berjalan.
            </div>
        </div>
    </div>
@stop