@extends('layouts.admin')

@section('title', admin()->getAdminTitlePage('Artisan - Vilacore Setting'))

@section('content.header')
    {!! admin()->contentHeader('Artisan [BETA]', [
        ['name' => 'Admin'], 
        ['name' => 'Pengaturan'],
        ['name' => 'Artisan', 'active' => '']
    ]) !!}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i>
                <b>Perhatian!</b> Perintah artisan yang meminta input
                tidak akan ditampilkan yang menyebabkan respon terminal terlalu lama.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i>
                <b>Perhatian!</b> Fitur ini bukanlah terminal, fitur ini hanya menjalankan
                perintah console melalui ajax request dan fungsi shell_exec pada php yang berarti
                adanya keterbatasan seperti tidak dapat menerima input dan lain sebagainya.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            @if (env('APP_ENV', 'production') == 'production')
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i>
                Aplikasi sedang dalam mode production, beberapa perintah mungkin tidak berfungsi
                tanpa adanya flag "--force"
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Terminal</h3>
                    <div class="card-tools">
                    </div>
                </div>
                <div class="card-body p-0">
                    <div id="webartisan" style="height: 55vh !important;max-height: 55vh !important;overflow:auto;"></div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">   
@endpush

@push('js')
    <script src="https://unpkg.com/jquery.terminal/js/jquery.terminal.js"></script>
    <script>
        const greetings = '[[b;yellow;]Welcome to Vilacore Web Artisan\nLaravel Artisan 5.8\nType "help" and enter to get All Available Command\n]';
        const WebArtisanEndpoint = '{{ route("vilacoreSetting.artisan.run") }}';
        let errorLog = '';

        jQuery(function($, undefined) {
            $('#webartisan').terminal(function(command, term) {
                if (command == 'help') {
                    term.echo('');
                    term.echo(greetings);
                    term.echo('');
                    term.echo("\tclear\tClear console");
                    term.echo('\thelp\tThis help text');
                    term.echo('\tartisan\tartisan command');
                    term.echo('');           
                } else if (command == 'error_log') {
                    term.echo('[Error Log] :');
                    term.echo(errorLog);
                    term.echo('');
                } else if (command.indexOf('artisan') === 0 || command.indexOf('artisan') === 7) {
                    
                    // $.jrpc(WebArtisanEndpoint, 'artisan', [command], function(json) {
                    //     term.echo(json.result);
                    // });terminal.echo("hello blue",
                    term.echo('[[b;blue;]<Running "' + command +'">]');
                    term.pause();
                    $.ajax({
                        url: WebArtisanEndpoint,
                        method: "POST",
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        data: { command: command.substr(8, command.length) },
                        context: document.body,
                        datatype: "json",
                        success: function(res) {
                            console.log(res);
                            term.echo(res.result);
                            term.resume();
                            term.echo('');
                        },
                        error: function(xhr, status, error){
                            term.error('Failed to run command, type "error_log" for detail.');
                            log = '\tCommand\t: ' + command
                                + '\n\tStatus\t: ' + xhr.status
                                + '\n\tText\t: ' + xhr.statusText;
                            errorLog = log;
                            term.resume();
                            term.echo('');
                        }
                    });
                    
                } else if (command == '') {
                    
                } else {
                    try {
                        var result = window.eval(command);
                        if (result !== undefined) {
                            term.echo(new String(result));
                        }
                    } catch(e) {
                        term.error(new String(e));
                    }
                }
            }, {
                greetings: greetings,
                name: 'laravel-webartisan',
                prompt: '[[b;green;]webartisan>] '
            });
        });

        function get(command) {
            return fetch(WebArtisanEndpoint, {
                headers:{
                    'Content-Type': 'application/json',
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content') 
                },                    
                method: 'POST',
                body: JSON.stringify({
                    method: 'artisan',
                    params: [command.replace(/^artisan ?/, '')]
                })
            }).then( res => res.json );
        }
    </script>
@endpush

@push('css')
    <link href="https://unpkg.com/jquery.terminal/css/jquery.terminal.css" rel="stylesheet"/>
@endpush