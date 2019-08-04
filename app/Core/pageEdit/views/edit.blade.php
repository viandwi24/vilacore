@extends('layouts.admin')

@section('title', admin()->getAdminTitlePage('Edit "' . explode('/', $path)[count(explode('/', $path))-1] . '" - Plugin Page Editor'))

@section('content.header')
    {!! admin()->contentHeader('Edit "' . explode('/', $path)[count(explode('/', $path))-1] . '"' , [
        ['name' => 'Admin'], 
        ['name' => 'Page Edit', 'link' => route('pageEdit.index')],
        ['name' => $package, 'link' => route('pageEdit.explore', ['package' => $package])],
        ['name' => 'Edit'],
        ['name' => '"'.explode('/', $path)[count(explode('/', $path))-1].'"', 'active' => '']
    ]) !!}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Text Editor</h3>
                    <div class="card-tools">
                        @php
                            $mode = ["html", "json", "php", "javascript"];
                        @endphp
                        <select id="mode" class="form-control form-control-sm" style="display: inline;width: auto;" onchange="editor.session.setMode('ace/mode/'+$('#mode').val());">
                            <option value="{{ $file_info->extension }}">{{ $file_info->extension }}</option>      
                            @foreach ($mode as $item)
                                <?php if($file_info->extension == $item) continue; ?>
                                <option value="{{ $item }}">{{ $item }}</option>                                
                            @endforeach
                        </select>

                        <select id="theme" class="form-control form-control-sm" style="display: inline;width: auto;" onchange="editor.setTheme('ace/theme/' + $('#theme').val());">
                            <option value="chrome">Chrome Theme</option>
                            <option value="github">github</option>
                            <option value="monokai">monokai</option>
                            <option value="ambiance">ambiance</option>
                            <option value="cobalt">cobalt</option>
                            <option value="dracula">dracula</option>
                            <option value="dreamweaver">dreamweaver</option>
                            <option value="eclipse">eclipse</option>
                            <option value="solarized_dark">solarized_dark</option>
                            <option value="solarized_light">solarized_light</option>
                            <option value="terminal">terminal</option>
                            <option value="tomorrow_night">tomorrow_night</option>
                            <option value="twilight">twilight</option>
                        </select>
                        <?php
                        $tes = str_replace('%2F', '/', route('pageEdit.explore', ['package' => $package, 'path' => str_replace(explode('/', $path)[count(explode('/', $path))-1], '', str_replace(app_path('Core/'.$package), '', $path) )]));
                        $tes = explode('/', $tes);
                        unset($tes[count($tes)-1]);
                        $tes = implode('/', $tes);
                        ?>
                        <a href="{{ $tes }}" class="btn btn-sm btn-danger">
                            <i class="fas fa-chevron-left"></i>
                            Kembali
                        </a>
                        <button type="button" class="btn btn-sm btn-success" onclick="save()">
                            <i class="fas fa-save"></i>
                            Simpan
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <input type="text" class="form-control" value="{{ $path }}" disabled>
                </div>
                <div class="card-body" style="position: relative;">
                    <div id="editor">{{ $file }}</div>
                </div>
            </div>
            <form id="simpan" method="POST">
                @csrf
                <textarea name="editor" style="display: none;">{{ $file }}</textarea>
                <input type="hidden" name="path" value="{{ $path }}">
                <input type="hidden" name="prev_url" value="{{ url()->previous() }}">
            </form>
        </div>
    </div>
@stop

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.5/ace.js"></script>
    <script>
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        var editor = ace.edit("editor");
        var error = false;
        var textarea = $('textarea[name="editor"]');
        editor.setTheme("ace/theme/" + $('#theme').val());
        editor.session.setMode("ace/mode/{{ $file_info->extension }}");
        editor.getSession().on("change", function () {
            textarea.val(editor.getSession().getValue());
        });
        editor.getSession().on("changeAnnotation", function () {
        var annot = editor.getSession().getAnnotations();
        
        error = false;
        for (var key in annot) {
            if (annot.hasOwnProperty(key))
            console.log(annot[key].text + "on line " + " " + annot[key].row);
            error = true;
        }
        });

        function save(){
            if (error) {
                Toast.fire({
                    type: 'error',
                    title: 'Tidak bisa menyimpan karena ada beberapa kode error, cek kembali.'
                });
            } else {
                $('form#simpan').submit();
            }
        }
    </script>
@endpush

@push('css')
    <style type="text/css" media="screen">
        #editor { 
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            height: 50vh;
        }
    </style>
@endpush