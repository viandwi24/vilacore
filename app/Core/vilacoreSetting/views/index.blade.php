@extends('layouts.admin')

@section('title', admin()->getAdminTitlePage('Env - Vilacore Setting'))

@section('content.header')
    {!! admin()->contentHeader('Env ', [
        ['name' => 'Admin'], 
        ['name' => 'Pengaturan'],
        ['name' => 'Env', 'active' => '']
    ]) !!}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i>
                Kesalahan Kecil dapat menyebabkan kerusakan keseluruhan aplikasi, berhati - hatilah!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">List</h3>
                    <div class="card-tools">
                        <a target="_blank" href="{{ route('vilacoreSetting.env.backup') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-download"></i> Backup
                        </a>
                        <button onclick="$('form#env').submit();" class="btn btn-sm btn-warning">
                            <i class="fas fa-sync"></i> Perbarui
                        </button>
                        <button onclick="$('#addModal').modal('show');" class="btn btn-sm btn-success">
                            <i class="fas fa-plus"></i> Tambah
                        </button>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <thead>
                            <th>Key</th>
                            <th>Value</th>
                        </thead>
                        <tbody>
                            <form id="env" method="POST">
                                @csrf
                                @method('PATCH')
                                @foreach ($env as $key => $item)
                                <tr>
                                    <td>{{ $key }}</td>
                                    <td>
                                        <input type="text" name="{{ $key }}" id="i-{{ $key }}" value="{{ $item }}" class="form-control">
                                    </td>
                                    <td>
                                        <form style="display:none;" id="del-{{ $key }}" action="{{ route('vilacoreSetting.env.delete') }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="key" value="{{ $key }}">
                                        </form>
                                        <button onclick="$('form#del-{{ $key }}').submit();" class="btn btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>                                
                                @endforeach
                            </form>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Tambah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add" action="{{ route('vilacoreSetting.env.create') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Key</label>
                        <input type="text" name="key" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Value</label>
                        <input type="text" name="value" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button onclick="$('form#add').submit();" type="submit" data-dismiss="modal" class="btn btn-primary">Tambah</button>
            </div>
            </div>
        </div>
    </div>
@stop

@push('js')
@endpush

@push('css')
@endpush