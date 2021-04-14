@extends('layouts.app')

@section('title', 'Folder')

@section('content')
<div class="container-lg">

    @if(session('status'))
        <div class="alert alert-info" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-3">
            <div class="card bg-dark">
                <div class="card-body">
                    Nom
                    <br />
                    <small class="text-muted">xxxxxxxxxxxxx</small>
                    <br />
                    <br />
                    IP
                    <br />
                    <small class="text-muted">xxx.xxx.xxx.xxx</small>
                    <br />
                    <br />
                    Status
                    <br />
                    <span class="badge badge-success">Online</span>
                    <br />
                    <br />
                    Description
                    <br />
                    <small class="text-muted">xxxxxxxxxxxxxxxxxxx</small>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card bg-dark" style="height: 550px">
                <div class="card-header">
                    <span class="float-right">
                        <button class="btn btn-secondary btn-sm" data-target="#create_operation" data-toggle="modal" {{ Auth::user()->roles == 1 ? '' : 'hidden' }}>Ajouter</button>
                    </span>
                    <span class="mr-2">Gestion des fichiers</span>
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
                                <th scope="col">Description</th>
                                <th scope="col"></th>
                              </tr>
                            </thead>
                            <tbody>
                                @for($i = 0; $i < 50; $i++)
                                    <tr>
                                        <th scope="row">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                                <label class="form-check-label" for="defaultCheck1"></label>
                                            </div>
                                        </th>
                                        <td>xxx</td>
                                        <td>xxxxxxxxxxxxx</td>
                                        <td class="text-right" {{ Auth::user()->roles == 1 ? '' : 'hidden' }}>
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-dark text-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Modal --}}

    <div class="modal fade" id="create_operation" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Créer une opération</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group row">
                          <label for="inputPassword" class="col-sm-3 col-form-label">Fichier</label>
                          <div class="col-sm-9">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFileLangHTML">
                                <label class="custom-file-label" for="customFileLangHTML" data-browse="Parcourir">Fichier</label>
                              </div>
                          </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Créer</button>
                </div>
            </div>
        </div>
    </div>

    {{-- End --}}

</div>

@endsection

@section('scripts')
    @parent

@endsection
