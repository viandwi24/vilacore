@extends('layouts.admin')

@section('title', admin()->getAdminTitlePage('Profil Saya - Akun'))

@section('content.header')
    {!! admin()->contentHeader('Profil Saya', [['name' => 'Admin'], ['name' => 'Pengaturan'], ['name' => 'Akun'], ['name' => 'Profil Saya', 'active' => '']]) !!}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Profil Saya</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <tr>
                            <th>Nama</th>
                            <td>: {{ Auth()->user()->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>: {{ Auth()->user()->email }}</td>
                        </tr>
                        <tr>
                            <th>ID</th>
                            <td>: {{ Auth()->user()->id }}</td>
                        </tr>
                    </table>
                </div>
            </div>


            <div class="card collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">Ganti Profil</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <form method="post" action="{{ route('vilacoreAuth.change') }}"> 
                    @csrf
                    <table class="table table-hover">
                        <tr>
                            <th>Nama</th>
                            <td>
                                <input type="text" name="name" class="form-control" value="{{ Auth()->user()->name }}">
                            </td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>
                                <input type="texemailt" name="email" class="form-control" value="{{ Auth()->user()->email }}">
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="text-right">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i>
                            Simpan
                        </button>
                    </div>
                    </form>
                </div>
            </div>




            <div class="card collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">Ganti Password</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <form method="post" action="{{ route('vilacoreAuth.change.password') }}"> 
                    @csrf
                    <table class="table table-hover">
                        <tr>
                            <th>Password</th>
                            <td>
                                <input type="password" name="password" class="form-control" required autocomplete="new-password">
                            </td>
                        </tr>
                        <tr>
                            <th>Re-Password</th>
                            <td>
                                <input type="password" name="password_confirmation" class="form-control" required autocomplete="new-password">
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="text-right">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i>
                            Simpan
                        </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop