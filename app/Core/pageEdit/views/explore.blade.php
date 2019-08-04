@extends('layouts.admin')

@section('title', admin()->getAdminTitlePage('Jelajahi "' . $package . '" - Plugin Page Editor'))

@section('content.header')
    {!! admin()->contentHeader('Jelajahi "'.$package.'"', [
        ['name' => 'Admin'], 
        ['name' => 'Page Edit'], 
        ['name' => $package], 
        ['name' => 'Jelajahi', 'active' => '']
    ]) !!}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">List</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-folder">
                            <i class="fas fa-plus"></i>
                            <i class="fas fa-folder"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-file">
                            <i class="fas fa-plus"></i>
                            <i class="fas fa-file"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <input type="text" class="form-control" value="{{ $path }}" disabled>
                    <table class="table table-hover">
                        @if ($current_path != '/')
                        <tr ondblclick="$(this).find('a')[0].click();">
                            <td colspan="3">
                                <a href="explore?path={{ $prev_path }}">...</a>
                            </td>
                        </tr>
                        @endif
                        <?php $i = 0; ?>
                        @foreach ($files as $item)
                            <tr ondblclick="{{ ($item->type == 'folder') ? "$(this).find('a')[0].click();" : '' }}">
                                <td>
                                    @if ($item->type == 'folder')
                                        <a href="explore?path={{ $current_path . $item->item }}">
                                            <i class="fas fa-{{ $item->type }} mr-2"></i>
                                            {{ $item->item }}
                                        </a>
                                    @else
                                        <i class="fas fa-{{ $item->type }} mr-2"></i>
                                        {{ $item->item }}
                                    @endif
                                </td>
                                <td>
                                    {{ $item->modified }}
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Aksi
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item disabled" href="#">{{ $item->item }}</a>
                                            <div class="dropdown-divider"></div>
                                            <form id="del-{{ $i }}" action="{{ route('pageEdit.explore.delete', ['package' => $package]) }}" method="post">
                                                @csrf
                                                <input type="hidden" name="path" value="{{ $current_path . $item->item }}">
                                            </form>
                                            <a class="dropdown-item" onclick="$('form#del-{{ $i }}').submit();">Hapus</a>
                                            @if ($item->type == 'folder')
                                            @else
                                                <a class="dropdown-item" href="{{ route('pageEdit.explore.edit', ['package' => $package, 'path' => $current_path . $item->item]) }}">Edit {{ $item->item }}</a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php $i++; ?>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal-folder">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Buat Folder Baru</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="folder" method="POST" action="{{ route('pageEdit.explore.create', ['package' => $package]) }}">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Folder</label>
                        <input type="string" name="name" class="form-control" value="">
                    </div>
                    <input type="hidden" name="path" value="{{ $current_path }}">
                    <input type="hidden" name="type" value="folder">
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="$('form#folder').submit();">Buat</button>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-file">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Buat File Baru</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="file" method="POST" action="{{ route('pageEdit.explore.create', ['package' => $package]) }}">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">File</label>
                        <input type="string" name="name" class="form-control" value="file.php">
                    </div>
                    <input type="hidden" name="path" value="{{ $current_path }}">
                    <input type="hidden" name="type" value="file">
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="$('form#file').submit();">Buat</button>
            </div>
            </div>
        </div>
        </div>
@stop