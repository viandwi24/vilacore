@extends('layouts.admin')

@section('title', admin()->getAdminTitlePage('Kelola Alat'))

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
                    <th>Core Required</th>
                    <th>Description</th>
                    <th>...</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $not_compatible = 0; ?>
                    @foreach (plugin()->getAllWithInfo(false, false) as $plugin)
                        <tr>
                            <td>{{ $plugin->name }}</td>
                            <td><span class="badge badge-{{ $plugin->status ? 'success' : 'danger' }}">{{ $plugin->status ? 'Aktif' : 'Tidak Aktif' }}</span></td>
                            <td>{{ $plugin->author }}</td>
                            <td>V{{ $plugin->version }}</td>
                            <td>
                                @php
                                    $compatible = true;
                                    $required = explode('.', $plugin->required);
                                    $core = explode('.', env('VILACORE_CORE_VERSION', "0.0.0"));

                                    for ($i=2; $i >= 0; $i--) { 
                                        // echo $i;
                                        if ($required[$i] == 'x') {
                                            // $compatible = true;
                                        } elseif ($required[$i] == $core[$i]) {
                                            // $compatible = true;
                                        } else {
                                            $compatible = false;
                                        }
                                    }
                                @endphp

                                @if (!$compatible)
                                    <?php $not_compatible++; ?>
                                    <span style="color:red;">V{{ $plugin->required }}</span>    
                                    <span class="badge badge-danger">!</span>  
                                @else
                                    <span style="color:green;">V{{ $plugin->required }}</span>                             
                                @endif
                            </td>
                            <td>{{ $plugin->description }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Aksi
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item disabled" href="#">{{ $plugin->package }}</a>
                                        <a class="dropdown-item" href="{{ route('admin.alat.toggle', ['package' => $plugin->package]) }}">{{ $plugin->status ? 'Nonaktifkan' : 'Aktifkan' }}</a>
                                        {{-- <button onclick="openPerm({{ json_encode(plugin()->getPermissionPlugin($plugin->package)) }})" class="dropdown-item">
                                            Check Permission
                                        </button> --}}
                                        {{-- <a class="dropdown-item" href="#">Something else here</a> --}}
                                    </div>
                                </div>
                            </td>
                        </tr>                        
                    @endforeach
                </tbody>
                </table>
            </div>
            @if ($not_compatible > 0)
            <div class="card-footer">
                
                <span style="color: red;">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ $not_compatible }} Plugin Yang Kemungkinan Tidak Dapat Berjalan Dengan Baik. 
                    Silahkan perbarui versi plugin tersebut.
                </span>
            </div>                
            @endif
        </div>

        <div>
            <strong>Core Version : </strong> {{ env('VILACORE_CORE_VERSION', "0.0.0") }}
        </div>
    </div>
</div>
@stop

@push('js')
    <script>
        function openPerm(packageInfo) {
            $('#modal-default').modal('show');
        }
    </script>
@endpush