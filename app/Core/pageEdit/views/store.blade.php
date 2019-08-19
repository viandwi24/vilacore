@extends('layouts.admin')

@section('title', admin()->getAdminTitlePage('Plugin Store'))

@section('content.header')
    {!! admin()->contentHeader('Plugin Store', [['name' => 'Admin'], ['name' => 'Page Edit'],  ['name' => 'Plugin Store', 'active' => '']]) !!}
@endsection

@section('content')
<div id="app">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        Plugin Store
                    </h3>
                    <div class="card-tools">
                        <span style="color: grey;" v-if="json == null">
                            <i class="fas fa-circle-notch fa-spin"></i>
                            loading...
                        </span>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Description</th>
                                <th>Version</th>
                                <th>...</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item, i in json">
                                <td>@{{ item.name }}</td>
                                <td>@{{ item.description }}</td>
                                <td>@{{ item.version }}</td>
                                <td>
                                    <button v-on:click="detail(item)" class="btn btn-sm btn-primary">
                                        <i class="fas fa-info-circle"></i>
                                        Detail
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="json == null">
                                <td colspan="4" class="text-center">
                                    <i class="fas fa-circle-notch fa-spin"></i> Getting list...
                                </td>
                            </tr>
                            <tr v-else-if="json.length == 0">
                                <td colspan="4" class="text-center">Tidak ada satupun.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div>
                <strong>Store Url : </strong> @{{ url }}
                {{-- <br>
                <strong>Core Version : </strong> {{ env('VILACORE_CORE_VERSION', "0.0.0") }} --}}
            </div>
        </div>
    </div>

    <div class="modal fade" id="detailModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table v-if="selectedDetail != null">
                        <tr>
                            <th>Name</th>
                            <td>: @{{ selectedDetail.name }}</td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td>: @{{ selectedDetail.description }}</td>
                        </tr>
                        <tr>
                            <th>Version</th>
                            <td>: @{{ selectedDetail.version }}</td>
                        </tr>
                        <tr>
                            <th>Author</th>
                            <td>: @{{ selectedDetail.author }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>: @{{ selectedDetail.email }}</td>
                        </tr>
                        <tr>
                            <th>Required Core</th>
                            <td>: @{{ selectedDetail.required }}</td>
                        </tr>
                    </table>
                    <div v-if="selectedDetail == null">Tidak ada</div>
                </div>
                <div class="modal-footer justify-content-between">
                    <a v-bind:download="this.fileDownloadSelectedDetail" target="_blank" v-bind:href="this.downloadSelectedDetail" class="btn btn-success">
                        <i class="fas fa-download"></i>
                        Download
                    </a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@push('js')
    <script>
    var app = new Vue({
        el: '#app',
        data: {
            json: null,
            url: "https://raw.githubusercontent.com/viandwi24/vilacore-plugin/master/list.json",
            selectedDetail: null,
            downloadSelectedDetail: null,
            fileDownloadSelectedDetail: null
        },
        methods: {
            getJson() {
                var _this = this;
                $.getJSON(_this.url, function (json) {
                    _this.json = json;
                })
                  .fail(function(){
                    _this.json = [];
                  });
            },
            detail(json) {
                this.selectedDetail = json;
                this.downloadSelectedDetail = "https://github.com/viandwi24/vilacore-plugin/raw/master/files/"+json.package+"/"+json.package+'-'+json.version+".zip";
                this.fileDownloadSelectedDetail = json.package + '-' + json.version + '.zip';
                $('#detailModal').modal('show');
            }
        },
        mounted() {
            var _this = this;
            setTimeout(function(){ _this.getJson(); }, 100);
        }
    })
    </script>  
@endpush