@extends('layouts.admin')

@section('content.header')
    {!! admin()->contentHeader('Plugin Page Editor', [['name' => 'Admin'], ['name' => 'Page Edit', 'active' => '']]) !!}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Plugin</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-default">
                            <i class="fas fa-plus"></i>
                            Buat Plugin Baru
                        </button>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Package</th>
                                <th>...</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (plugin()->getAllWithInfo() as $plugin)
                            <tr>
                                <td>{{ $plugin->name }}</td>
                                <td>{{ $plugin->package }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Aksi
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item disabled" href="#">{{ $plugin->package }}</a>
                                            <a class="dropdown-item" href="#">Edit info.json</a>
                                            <a class="dropdown-item" href="#">Edit {{ $plugin->package }}.php</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="{{ route('pageEdit.explore', ['package' => $plugin->package]) }}" class="dropdown-item" href="#">Jelajahi</a>
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
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Buat Plugin Baru</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('pageEdit.create') }}">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama</label>
                        <input type="string" name="name" class="form-control" value="Example">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama Package</label>
                        <input type="string" name="package" class="form-control" value="example">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Author</label>
                        <input type="string" name="author" class="form-control" value="viandwi24">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Versi</label>
                        <input type="string" name="version" class="form-control" value="1.0.0">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Deskripsi</label>
                        <textarea name="description" class="form-control">Description your plugin...</textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="$('form').submit();">Buat</button>
            </div>
            </div>
        </div>
    </div>
@stop