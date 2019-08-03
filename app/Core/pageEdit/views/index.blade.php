@extends('layouts.admin')

@section('content.header')
    {!! admin()->contentHeader('Plugin Page Editor', [['name' => 'Admin'], ['name' => 'Page Edit'],  ['name' => 'Daftar Plugin', 'active' => '']]) !!}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Plugin</h3>
                    <div class="card-tools">
                        <form style="display: none;" method="post" id="import" enctype="multipart/form-data" action="{{ route('pageEdit.import') }}">
                            @csrf
                            <input onchange="fileImportChange(event)" type="file" name="file" id="fileImport">
                        </form>
                        <script>
                            function fileImportChange(e) {
                                if (e.target.files.length) { $('form#import').submit(); }
                            }
                        </script>
                        <button onclick="$('#fileImport').click();" type="button" class="btn btn-sm btn-primary">
                            <i class="fas fa-file"></i>
                            Import .zip
                        </button>
                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-default">
                            <i class="fas fa-plus"></i>
                            Buat Plugin Baru
                        </button>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover" style="min-height: 40vh;">
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
                                            <a class="dropdown-item" href="{{ route('pageEdit.explore.edit', ['package' => $plugin->package, 'path' => '/info.json']) }}">Edit info.json</a>
                                            <a class="dropdown-item" href="{{ route('pageEdit.explore.edit', ['package' => $plugin->package, 'path' => '/' . $plugin->package . '.php']) }}">Edit {{ $plugin->package }}.php</a>
                                            <div class="dropdown-divider"></div>
                                            <form id="del-{{ $plugin->package }}" action="{{ route('pageEdit.delete', ['package' => $plugin->package]) }}" method="POST">@csrf</form>
                                            <a onclick="event.preventDefault();$('form#del-{{ $plugin->package }}').submit();" href="{{ route('pageEdit.delete', ['package' => $plugin->package]) }}" class="dropdown-item" href="#">Hapus Plugin</a>
                                            <a target="_blank" href="{{ route('pageEdit.export', ['package' => $plugin->package]) }}" class="dropdown-item" href="#">Ekspor .zip</a>
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
                <form id="create" method="POST" action="{{ route('pageEdit.create') }}">
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
                        <label for="exampleInputEmail1">Syarat Versi Core</label>
                        <input type="string" name="required" class="form-control" value="{{ env('VILACORE_CORE_VERSION', '1.0.0') }}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Deskripsi</label>
                        <textarea name="description" class="form-control">Description your plugin...</textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="$('form#create').submit();">Buat</button>
            </div>
            </div>
        </div>
    </div>
@stop