@extends('layouts.admin')

@section('title', admin()->getAdminTitlePage('Tentang > ' . $plugin->name))

@section('content.header')
{!! admin()->contentHeader($plugin->name, [['name' => 'Admin'], ['name' => 'Alat'], ['name' => $plugin->name, 'active' => '']]) !!}          
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">About</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-widget="collapse">
                        <i class="fas fa-plus"></i>
                      </button>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <tr>
                            <th>Name</th>
                            <td>: {{  $plugin->name }}</td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td>: {{  $plugin->description }}</td>
                        </tr>
                        <tr>
                            <th>Version</th>
                            <td>: V{{  $plugin->version }}</td>
                        </tr>
                        <tr>
                            <th>Core Version Required</th>
                            <td>: V{{  $plugin->required }}</td>
                        </tr>
                        <tr>
                            <th>Author Name</th>
                            <td>: {{  $plugin->author }}</td>
                        </tr>
                        <tr>
                            <th>Author Email</th>
                            <td>: {{  $plugin->email }}</td>
                        </tr>
                        <tr>
                            <th>Package Name</th>
                            <td>: {{ $plugin->package }}</td>
                        </tr>
                        <tr>
                            <th>Path</th>
                            <td>: {{ app_path('Core/'.$plugin->package) }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            @php
                $perm = plugin()->getPermissionPlugin($plugin->package);
                // dd($perm);
            @endphp

            <div class="card collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">Permission Apps</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-widget="collapse">
                        <i class="fas fa-plus"></i>
                      </button>
                    </div>
                </div>
                
                <div class="card-body">
                    <p class="text-center" style="color: orange;">
                        <i class="fas fa-exclamation-circle"></i>
                        Daftar ini tidak mencakup keseluruhan perizinan dari plugin,
                        hanya sebagian mapping saja yang bisa kami tampilkan seperti route, menu dll
                    </p>
                </div>


                
                <div class="card-body"><h4 class="card-title">
                    <i class="fas fa-dot-circle"></i>
                    Menu</h4></div>
                <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            @foreach ($perm->menu as $item)
                                <?php $item = (object) $item; ?>
                                <tr>
                                    <th> {{ $item->type }} </th>
                                    <td> {{ $item->name }} </td>
                                </tr>                            
                            @endforeach
                            @if (count($perm->menu) == 0)
                                <p class="text-center">Tidak ada.</p> 
                                <hr>
                            @endif
                        </table>
                </div>

                
                <div class="card-body" style="margin-top: 25px;">
                    <h4 class="card-title">
                        <i class="fas fa-dot-circle"></i> 
                        Dashboard Info Box
                    </h4>
                </div>
                <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            @foreach ($perm->dashboardInfoBox as $item)
                                <?php $item = (object) $item; ?>
                                <tr>
                                    <th> {{ $item->title }} </th>
                                </tr>                            
                            @endforeach
                            @if (count($perm->dashboardInfoBox) == 0)
                                <p class="text-center">Tidak ada.</p>   
                                <hr>                             
                            @endif
                        </table>
                </div>

                <div class="card-body" style="margin-top: 25px;">
                    <h4 class="card-title">
                        <i class="fas fa-dot-circle"></i>
                        Dashboard Widget
                    </h4>
                </div>
                <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            @foreach ($perm->dashboardWidget as $item)
                                <tr>
                                    <th> {{ $item }} </th>
                                </tr>                            
                            @endforeach
                            @if (count($perm->dashboardWidget) == 0)
                                <p class="text-center">Tidak ada.</p>  
                                <hr>                              
                            @endif
                        </table>
                </div>




                <div class="card-body" style="margin-top: 25px;">
                    <h4 class="card-title">
                        <i class="fas fa-dot-circle"></i> 
                        Route File
                    </h4>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <?php $sudah = []; ?>
                        @foreach ($perm->routeFile as $item)
                            <tr>
                                <th> {{ $item }} </th>
                            </tr>                            
                        @endforeach
                        @if (count($perm->routeFile) == 0)
                            <p class="text-center">Tidak ada.</p>    
                            <hr>                            
                        @endif
                    </table>
                </div>

                <div class="card-body" style="margin-top: 25px;">
                    <h4 class="card-title">
                        <i class="fas fa-dot-circle"></i> 
                        Route Action
                    </h4>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <?php $c = 0 ; ?>
                        @foreach ($perm->route as $item)
                            <?php $item = (object) $item; $c++; ?>
                            <tr>
                                <th> {{ $item->as }} </th>
                                <td> {{ $item->uri }} </td>
                                <td> {{  is_callable($item->uses) ? 'Closure' : str_replace("App\Core\\".$plugin->package, '', $item->uses) }}</td>
                                <td>{{ @implode(', ', $item->middleware) }}</td>
                            </tr>                            
                        @endforeach
                        @if ($c == 0)
                            <p class="text-center">Tidak ada.</p>                                
                        @endif
                    </table>
                </div>


            </div>
        </div>
    </div>
@stop