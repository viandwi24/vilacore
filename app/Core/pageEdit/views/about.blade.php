@extends('layouts.admin')

@section('content.header')
    {!! plugin()->getContentHeaderSettingPage() !!}
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">About</h3>
                </div>
                <div class="card-body">
                    <b>Page Edit</b> adalah Alat untuk mengatur dan memanajemen
                    plugin lainya secara gui. Ini adalah salah satu widget dari Page Edit.
                    Kalian bisa nonaktifkan plugin ini di Pengaturan > Alat > Kelola.
                </div>
                <div class="card-header p-0"> </div>
                <div class="card-body table-responsive p-0">
                    <?php $plugin = plugin()->getInfo(plugin()->getActive()); ?>
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
                            <th>Author</th>
                            <td>: {{  $plugin->author }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>: fiandwi0424@gmail.com</td>
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
        </div>
    </div>
@stop