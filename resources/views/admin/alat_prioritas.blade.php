@extends('layouts.admin')

@section('title', admin()->getAdminTitlePage('Kelola Alat'))

@section('content.header')
    {!! admin()->contentHeader('Prioritas Plugin', [['name' => 'Admin'], ['name' => 'Alat'], ['name' => 'Prioritas', 'active' => '']]) !!}          
@stop

@section('content')
<div class="row" id="table-plugin">
    <div class="col-12">
        
        <div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-info"></i> Info!</h5>
            Prioritas Plugin membantu anda untuk menentukan plugin mana yang di prioritas kan,
            plugin akan di load dari prioritas yang tertinggi (index 1) sampai ke tingkat rendah.
            Atur plugin yang membutuhkan prioritas tinggi di nomor index 1 agar plugin dapat di load
            terlebih dahulu dari pada plugin lain.
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Plugin Aktif</h3>
                <div class="card-tools">
                    <button v-on:click="save()" class="btn btn-sm btn-success">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                <thead>
                    <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Package</th>
                    <th>...</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item, index in plugin">
                        <th>@{{ index+1 }}</th>
                        <td>@{{ item.name }}</td>
                        <td>@{{ item.package }}</td>
                        <td>
                            <button v-on:click="up(index)" class="btn btn-primary btn-sm">
                                <i class="fas fa-chevron-up"></i>
                            </button>
                            <button v-on:click="down(index)" class="btn btn-danger btn-sm">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </td>
                    </tr>      
                </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@push('js')
    <script>
        var app = new Vue({
            el: '#table-plugin',
            data: {
                plugin: {!! json_encode(plugin()->getAllWithInfo(true), true) !!}
            },
            methods: {
                buildTable() {
                    
                },
                down(i){
                    if (app.plugin[i+1] != null) {
                        let plugin = app.plugin;
                        app.plugin = [];
                        let temp = plugin[i+1];
                        plugin[i+1] = plugin[i];
                        plugin[i] = temp;

                        app.plugin = plugin;
                    }

                    app.buildTable();
                },
                up(i){
                    if (app.plugin[i-1] != null) {
                        let plugin = app.plugin;
                        app.plugin = [];
                        let temp = plugin[i-1];
                        plugin[i-1] = plugin[i];
                        plugin[i] = temp;

                        app.plugin = plugin;
                    }

                    app.buildTable();
                },
                save() {
                    var form = $('<form method="post">{{ csrf_field() }}<input id="json" name="json" /></form>');
                    form.find("input#json").val(JSON.stringify(app.plugin));
                    console.log(form.find("input#json"));
                    form.appendTo('body').submit();
                },
            },
            mounted(){
                this.buildTable();
            }
        });
    </script>
@endpush