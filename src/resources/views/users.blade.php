@extends('layouts.app')

@section('title', 'Utilisateurs')

@section('content')
<div class="container-lg">

    @if(session('status'))
        <div class="alert alert-info" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card bg-dark" style="height: 550px">
                <div class="card-header">
                    <span class="mr-2">Gestion des utilisateurs</span>
                </div>
                <div class="card-body overflow-auto">

                    <div class="table-responsive">
                        <table class="table table-hover table-dark table-sm">
                            <thead class="thead-light">
                              <tr>
                                <th scope="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                        <label class="form-check-label" for="defaultCheck1"></label>
                                    </div>
                                </th>
                                <th scope="col">Nom</th>
                                <th scope="col">Email</th>
                                <th scope="col">Avatar</th>
                                <th scope="col">Role</th>
                                <th scope="col">Description</th>
                                <th scope="col"></th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $u)
                                    <tr>
                                        <th scope="row">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                                <label class="form-check-label" for="defaultCheck1"></label>
                                            </div>
                                        </th>
                                        <td>{{ $u->name }}</td>
                                        <td>{{ $u->email }}</td>
                                        <td>{{ $u->avatar }}</td>
                                        <td>{{ $u->role_name->roles_name }}</td>
                                        <td>{{ $u->user_description }}</td>
                                        <td class="text-right">
                                            <div class="btn-group btn-group-sm" {{ Auth::user()->roles == 1 && Auth::user()->roles != $u->id ? '' : 'hidden' }}>
                                                <button class="btn btn-dark text-info">
                                                    <i class="fas fa-pen"></i>
                                                </button>
                                                <button class="btn btn-dark text-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
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
    </div>

</div>

@endsection

@section('scripts')
    @parent

@endsection
