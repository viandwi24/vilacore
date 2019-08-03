@extends('layouts.admin')

@section('content.header')
    {!! admin()->contentHeader('Alat', [['name' => 'Admin'], ['name' => 'Alat'], ['name' => 'Kelola', 'active' => '']]) !!}          
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Semua Alat</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                <thead>
                    <tr>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Author</th>
                    <th>Version</th>
                    <th>Description</th>
                    <th>...</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (plugin()->getAllWithInfo() as $plugin)
                        <tr>
                            <td>{{ $plugin->name }}</td>
                            <td><span class="badge badge-{{ $plugin->status ? 'success' : 'danger' }}">{{ $plugin->status ? 'Aktif' : 'Tidak Aktif' }}</span></td>
                            <td>{{ $plugin->author }}</td>
                            <td>V{{ $plugin->version }}</td>
                            <td>{{ $plugin->description }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Aksi
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item disabled" href="#">{{ $plugin->package }}</a>
                                        <a class="dropdown-item" href="{{ route('admin.alat.toggle', ['package' => $plugin->package]) }}">{{ $plugin->status ? 'Nonaktifkan' : 'Aktifkan' }}</a>
                                        {{-- <a class="dropdown-item" href="#">Something else here</a> --}}
                                    </div>
                                </div>
                            </td>
                        </tr>                        
                    @endforeach
                </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop