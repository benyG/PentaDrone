@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
<div class="container-lg">

    @if(session('status'))
        <div class="alert alert-info p-2" role="alert">
            {{ session('status') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-3">
            <div class="card bg-dark" style="height: 340px">
                <div class="card-header">
                    <span class="float-right">
                        <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#all_cmd">Auto</button>
                    </span>
                    Commandes
                </div>
                <div class="card-body p-1 overflow-auto">

                    <div class="accordion" id="accordionExample">
                        @foreach($category_cmd as $cc)
                            <div class="card">
                                <div class="card-header p-0" id="headingOne">
                                    <button class="btn btn-secondary btn-sm btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{ $cc->id }}" aria-expanded="true" aria-controls="collapse{{ $cc->id }}">
                                         {{ $cc->category_name }}
                                    </button>
                                </div>

                                <div id="collapse{{ $cc->id }}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="card-body p-0">
                                        <div class="list-group">
                                            @foreach($cc->command_list as $value)
                                                <button type="button" class="list-group-item list-group-item-action p-2" data-target="{{ Auth::user()->roles == 1 ? '#cmd' . $value->id_listcmd : '' }}" data-toggle="modal">
                                                    {{ $value->name_cmd }}
                                                </button>

                                                <div class="modal fade" id="cmd{{ $value->id_listcmd }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content bg-dark">
                                                            <div class="modal-header">
                                                                <h6 class="modal-title" id="exampleModalLabel">{{ $value->name_cmd }}</h6>
                                                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form>
                                                                    <div class="form-group row">
                                                                        <label for="staticEmail" class="col-sm-3 col-form-label">Commande</label>
                                                                        <div class="col-sm-9">
                                                                            <input type="text" readonly class="form-control-plaintext text-white" id="staticEmail" value="!{{ $value->name_cmd }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                    <label for="inputPassword" class="col-sm-3 col-form-label">Paramètre</label>
                                                                    <div class="col-sm-9">
                                                                        @for($i = 1; $i <= $value->param; $i++)
                                                                            <input type="password" class="form-control" id="inputPassword" placeholder="Paramètre {{ $i }}" name="param_{{ $i }}" required />
                                                                            <br />
                                                                        @endfor
                                                                    </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                    <label for="inputPassword" class="col-sm-3 col-form-label"></label>
                                                                    <div class="col-sm-9">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                                                            <label class="form-check-label" for="defaultCheck1">
                                                                                Ajouter comme commande automatique
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Annuler</button>
                                                                <button type="button" class="btn btn-primary btn-sm">Envoyer</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card bg-dark" style="height: 340px">
                <div class="card-header">
                    <span class="float-right" {{ Auth::user()->roles == 1 ? '' : 'hidden' }}>
                        <button class="btn btn-secondary btn-sm" data-target="#create_operation" data-toggle="modal">Créer</button>
                    </span>
                    <span class="mr-1">Opération :</span>
                    <select class="custom-select custom-select-sm w-50 mr-2" id="selectOperation">
                        <option selected disabled>Sélectionner une opération</option>
                        @foreach($operationpc as $pc)
                            <option value="{{ $pc->id }}">{{ $pc->ops_name }}</option>
                        @endforeach
                    </select>
                    <span class="mr-1">Online :</span>
                    <input type="number" placeholder="Minute" class="form-control form-control-sm d-inline" id="selectTime" value="30" style="width: 100px" disabled />
                </div>
                <div class="card-body">

                    <div class="text-center h2 text-muted" id="canvas_pc_none">
                        Sélectionner une opération
                    </div>

                    <p id="canvas_opc" class="text-center" style="display: none">
                        <img src="{{ asset('public/files/v24/loading.gif') }}" style="width: 50px" alt="loading" />
                    </p>

                    <div id="content_opc" style="display: none">
                        <span class="float-right" {{ Auth::user()->roles == 1 ? '' : 'hidden' }}>
                            <div class="btn-group btn-group-sm">
                                <button class="btn text-info btn-sm btn-dark" id="edit_opc" data-target="#edit_operation" data-toggle="modal"><i class="fas fa-pen"></i></button>
                                <button class="btn text-danger btn-sm btn-dark" id="delete_opc" data-target="#del_operation" data-toggle="modal"><i class="fas fa-trash"></i></button>
                            </div>
                        </span>
                        <h6>
                            <b>Nom :</b> <span id="name_opc"></span>
                            <br />
                            <b>Commentaire :</b> <span id="desc_opc"></span>
                        </h6>

                        <hr />

                        <div class="table-responsive" id="table_pc">
                            <table class="table table-hover table-dark table-sm">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="defaultCheck1">
                                            <label class="form-check-label" for="defaultCheck1"></label>
                                        </div>
                                    </th>
                                    <th scope="col"></th>
                                    <th scope="col">Nom</th>
                                    <th scope="col">IP</th>
                                    <th scope="col">Domain</th>
                                    <th scope="col">Description</th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody id="table_opc">
                                </tbody>
                            </table>
                        </div>

                        <h5 class="text-center text-muted" id="no_pc"> Aucun PC pour cette opération </h5>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <br />

    <div class="row">
        <div class="col-md-3">
            <div class="card bg-dark" style="height: 260px">
                <div class="card-header">
                    <span class="float-right" {{ Auth::user()->roles == 1 ? '' : 'hidden' }}>
                        <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#create_agent">Ajouter</button>
                    </span>
                    Liste des agents
                </div>
                <div class="card-body overflow-auto">

                    <div class="text-center text-small text-muted" id="canvas_ag_none">
                        Sélectionner une opération
                    </div>

                    <p id="canvas_ag" class="text-center" style="display: none">
                        <img src="{{ asset('public/files/v24/loading.gif') }}" style="width: 50px" alt="loading" />
                    </p>

                    <div id="content_ag" style="display: none">

                        <div class="table-responsive" id="table_ag">
                            <table class="table table-hover table-dark table-sm">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                            <label class="form-check-label" for="defaultCheck1"></label>
                                        </div>
                                    </th>
                                    <th scope="col"></th>
                                    <th scope="col">Nom</th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody id="table_agent">
                                </tbody>
                            </table>
                        </div>

                        <div class="text-center text-small text-muted" id="no_ag"> Aucun Agent pour cette opération </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card bg-dark" style="height: 260px">
                <div class="card-header">
                    <span class="float-right" {{ Auth::user()->roles == 1 ? '' : 'hidden' }}>
                        <button class="btn btn-danger btn-sm" id="del_all_res" data-toggle="modal" data-target="#delete_result" disabled>Supprimer tout</button>
                    </span>
                    Résultats des commandes <span id="on_res"></span>
                </div>
                <div class="card-body overflow-auto">

                    <div class="text-center h2 text-muted" id="res_none_pc">
                        Sélectionner un PC
                    </div>

                    <p id="canvas_res" class="text-center" style="display: none">
                        <img src="{{ asset('public/files/v24/loading.gif') }}" style="width: 50px" alt="loading" />
                    </p>

                    <h5 class="text-center text-muted" id="no_res_pc" style="display: none">Aucun resultat pour ce PC</h5>

                    <div id="res_pc"></div>

                </div>
            </div>
        </div>
    </div>


    {{-- Modal --}}

    <div class="modal fade" id="create_agent" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Ajouter un agent</h6>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group row">
                          <label for="staticEmail" class="col-sm-3 col-form-label">Nom</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="staticEmail" placeholder="Nom de l'agent">
                          </div>
                        </div>
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
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary btn-sm">Créer</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="all_cmd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Commandes automatiques</h6>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <table class="table table-hover table-dark table-sm">
                        <thead class="thead-light">
                          <tr>
                            <th>Commande</th>
                            <th>Ordre</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($cmd_auto as $c)
                                <tr>
                                    <td>{{ $c->cmd_auto }}</td>
                                    <td>{{ $c->ordre }}</td>
                                </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="create_operation" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark">
                <form id="create_opc" method="post" action="{{ route('create.operation') }}">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel">Créer une opération</h6>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            @csrf
                            <div class="form-group row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Nom</label>
                            <div class="col-sm-9">
                                <input type="text" name="ops_name" class="form-control" placeholder="Nom de l'opération" required />
                                <small></small>
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="inputPassword" class="col-sm-3 col-form-label">Commentaire</label>
                            <div class="col-sm-9">
                                <textarea name="description" rows="5" placeholder="Le commentaire" class="form-control" required></textarea>
                                <small></small>
                            </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary btn-sm" id="btn_submit">Créer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete_result" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Supprimer tout les resultats</h6>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Vous souhaitez supprimer tout les resultats?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit_operation" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark">
                <form id="edit_ops" method="post" action="{{ route('edit.operation') }}">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel">Modifier une opération</h6>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            @csrf
                            <div class="form-group row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Nom</label>
                            <div class="col-sm-9">
                                <input type="hidden" name="id" id="ops_id" value="" />
                                <input type="text" name="ops_name" id="name_ops" class="form-control" placeholder="Nom de l'opération" required />
                                <small></small>
                            </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-3 col-form-label">Commentaire</label>
                                <div class="col-sm-9">
                                    <textarea name="description" id="desc_opc" rows="5" placeholder="Le commentaire" class="form-control" required></textarea>
                                    <small></small>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary btn-sm" id="btn_submit">Modifier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="del_operation" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark">
                <form id="delete_ops" method="post" action="{{ route('delete.operation') }}">
                    @method('delete')
                    @csrf
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel">Supprimer une opération</h6>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="" id="ops_id" />
                        Vous souhaitez supprimer cette opération ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-danger btn-sm" id="btn_submit">Supprimer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- End --}}

</div>
@endsection

@section('scripts')
    @parent

    <script>
        $(document).ready(function(){

            var url = window.location.href;
            if (url.includes("#")) {
                var hash = url.substring(url.indexOf('#')+1);
                $('#selectOperation option[value="' + hash + '"]').prop('selected', true);
                $('#selectOperation option').each(function() {
                    if(this.selected) {
                        getOperation(new Event('build'));
                    }
                });
            }

            $('#selectOperation').on('change', function(){
                $('#selectTime').prop('disabled', false);
                if (!$('#selectTime').val()) {
                    $('#selectTime').val(30);
                }
                getOperation(event, $('#selectTime').val());
            });

            $('#selectTime').on('keyup', function(){
                if (!$('#selectTime').val()) {
                    getOperation(event, 30);
                } else {
                    getOperation(event, $(this).val());
                }
            });

            $('#create_opc').on('submit', function(e) {
                e.preventDefault();

                $('input+small').text('');
                $('input').removeClass('is-invalid');
                $('textarea+small').text('');
                $('textarea').removeClass('is-invalid');

                $.ajax({
                    type: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    beforeSend: function(e) {
                        $('#create_opc button').prop('disabled', true);
                        $('#create_opc #btn_submit').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                    },
                    success: function(data) {
                        document.location.assign("{{ route('home') }}#" + data.data.id);
                        document.location.reload();
                    },
                    error: function(e) {
                        console.log(e);
                    }
                })
                .fail(function(f){
                    $('#create_opc button').prop('disabled', false);
                    $('#btn_submit').html('Créer');
                    $.each(f.responseJSON['errors'], function(key, value){
                    var input = '#create_opc input[name=' + key +']';
                    var inputT = '#create_opc textarea[name=' + key +']';
                    $(input + '+small').addClass("text-danger");
                    $(input + '+small').text(value);
                    $(input).addClass('is-invalid');
                    $(inputT + '+small').addClass("text-danger");
                    $(inputT + '+small').text(value);
                    $(inputT).addClass('is-invalid');
                    });
                });
            });

            $('#edit_ops').on('submit', function(e) {
                e.preventDefault();

                $('input+small').text('');
                $('input').removeClass('is-invalid');
                $('textarea+small').text('');
                $('textarea').removeClass('is-invalid');

                $.ajax({
                    type: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    beforeSend: function(e) {
                        $('#edit_ops button').prop('disabled', true);
                        $('#edit_ops #btn_submit').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                    },
                    success: function(data) {
                        document.location.assign("{{ route('home') }}#" + data.data.id);
                        document.location.reload();
                    },
                    error: function(e) {
                        console.log(e);
                    }
                })
                .fail(function(f){
                    $('#edit_ops button').prop('disabled', false);
                    $('#edit_ops #btn_submit').html('Modifier');
                    $.each(f.responseJSON['errors'], function(key, value){
                    var input = '#edit_ops input[name=' + key +']';
                    var inputT = '#edit_ops textarea[name=' + key +']';
                    $(input + '+small').addClass("text-danger");
                    $(input + '+small').text(value);
                    $(input).addClass('is-invalid');
                    $(inputT + '+small').addClass("text-danger");
                    $(inputT + '+small').text(value);
                    $(inputT).addClass('is-invalid');
                    });
                });
            });

            $('#delete_ops').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    type: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    beforeSend: function(e) {
                        $('#delete_ops button').prop('disabled', true);
                        $('#delete_ops #btn_submit').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                    },
                    success: function(data) {
                        document.location.assign("{{ route('home') }}");
                        document.location.reload();
                    },
                    error: function(e) {
                        console.log(e);
                    }
                });
            });
        });

        function getOperation(e, hash = 30) {

            $.ajax({
                type: 'get',
                url: '{{ url("get/operation") }}/' + $('#selectOperation').val() + '/' + hash,
                beforeSend: function(e) {
                    $('[id="canvas_pc_none"]').hide();
                    $('[id="canvas_opc"]').show();
                    $('[id="content_opc"]').hide();
                    $('[id="canvas_ag_none"]').hide();
                    $('[id="canvas_ag"]').show();
                    $('[id="content_ag"]').hide();
                },
                success: function(data) {
                    $('[id="name_opc"]').html(data.data.ops_name);
                    $('[id="name_ops"]').val(data.data.ops_name);
                    $('[id="ops_id"]').val(data.data.id);
                    $('[id="desc_opc"]').html(data.data.description);

                    if (data.data.ops_name == "Default") {
                        $('#edit_opc, #delete_opc').hide();
                    } else {
                        $('#edit_opc, #delete_opc').show();
                    }

                    $('[id="no_pc"]').hide();
                    $("#table_opc").empty();
                    if (data.pc.length > 0) {
                        $.each(data.pc, function (i, data) {
                            var body = '<tr>';
                                body +='<th scope="row">';
                                body +='<div class="form-check">';
                                body +='<input class="form-check-input" type="checkbox" value="" id="defaultCheckChild">';
                                body +='<label class="form-check-label" for=""></label>';
                                body +='</div>';
                                body +='</th>';
                                if (data.online) {
                                    body +='<td><i class="fas fa-desktop fa-sm text-success"></i></td>';
                                } else {
                                    body +='<td><i class="fas fa-desktop fa-sm text-danger"></i></td>';
                                }
                                body +='<td>' + data.hostname + '</td>';
                                body +='<td>' + data.ip + '</td>';
                                body +='<td>' + data.domain + '</td>';
                                body +='<td>' + data.obs + '</td>';
                                body +='<td class="text-right">';
                                body +='<div class="btn-group btn-group-sm">';
                                body +='<button class="btn btn-dark" onclick="pcRes(\'' + data.pc + '\',\'' + data.hostname + '\')">';
                                body +='<i class="fas fa-terminal"></i>';
                                body +='</button>';
                                body +='<a href="{{ route("folder") }}" class="btn btn-dark">';
                                body +='<i class="fas fa-folder"></i>';
                                body +='</a>';
                                body +='</div>';
                                body +='</td>';
                                body += '</tr>';
                            $("#table_opc").prepend(body);
                        });
                        $('[id="table_pc"]').show();
                    } else {
                        $('[id="table_pc"]').hide();
                        $('[id="no_pc"]').show();
                    }

                    $('[id="no_ag"]').hide();
                    $("#table_agent").empty();
                    if (data.agent.length > 0) {
                        $.each(data.agent, function (i, data) {
                            var body = '<tr>';
                                body +='<th scope="row">';
                                body +='<div class="form-check">';
                                body +='<input class="form-check-input" type="checkbox" value="" id="defaultCheck1">';
                                body +='<label class="form-check-label" for="defaultCheck1"></label>';
                                body +='</div>';
                                body +='</th>';
                                body +='<td>' + data.id_agent + '</td>';
                                body +='<td class="text-right">';
                                body +='<div class="btn-group btn-group-sm">';
                                body +='<button class="btn btn-dark" onclick="pcRes(' + data.pc + ')">';
                                body +='<i class="fas fa-eye"></i>';
                                body +='</button>';
                                body +='<button class="btn btn-dark text-info" onclick="pcRes(' + data.pc + ')">';
                                body +='<i class="fas fa-pen"></i>';
                                body +='</button>';
                                body +='<button class="btn btn-dark text-danger" {{ Auth::user()->roles == 1 ? "" : "hidden" }}>';
                                body +='<i class="fas fa-trash"></i>';
                                body +='</button>';
                                body +='</div>';
                                body +='</td>';
                                body += '</tr>';
                            $("#table_agent").prepend(body);
                        });
                        $('[id="table_ag"]').show();
                    } else {
                        $('[id="table_ag"]').hide();
                        $('[id="no_ag"]').show();
                    }

                    $('[id="canvas_opc"]').hide();
                    $('[id="content_opc"]').show();
                    $('[id="canvas_ag"]').hide();
                    $('[id="content_ag"]').show();
                },
                error: function(e) {
                    console.log(e);
                }
            });

        }

        function pcRes(id, hostname) {

            $('#on_res').html('[' + hostname + ']')

            $.ajax({
                type: 'get',
                url: '{{ url("get/pc/result") }}/' + id,
                beforeSend: function(e) {
                    $('#res_none_pc').hide();
                    $('#canvas_res').show();
                    $("#res_pc").hide();
                    $('#no_res_pc').hide();
                    $("#del_all_res").prop('disabled', true);
                },
                success: function(data) {

                    $("#res_pc").empty();
                    if (data.data.length > 0) {
                        $.each(data.data, function (i, data) {
                            var body = '<div class="alert alert-light" role="alert">';
                                body += '<span class="float-right">';
                                body += '<button type="button" class="btn btn-light btn-sm text-danger" data-dismiss="alert" aria-label="Close"';
                                body += '{{ Auth::user()->roles == 1 ? "" : "hidden" }}>';
                                body += '<span aria-hidden="true"><i class="fas fa-trash"></i></span>';
                                body += '</button>';
                                body += '</span>';
                                body += '<small class="alert-heading">';
                                body += '<b>COMMANDE :</b> ' + data.cmd;
                                body += '</small>';
                                body += '<br />';
                                body += '<small class="alert-heading">';
                                body += '<b>RESULTAT :</b> ' + data.result;
                                body += '</small>';
                                body += '</div>';
                            $("#res_pc").prepend(body);
                        });
                        $("#res_pc").show();
                        $("#del_all_res").prop('disabled', false);
                    } else {
                        $("#res_pc").hide();
                        $('#no_res_pc').show();
                    }

                    $('#canvas_res').hide();
                },
                error: function(e) {
                    console.log(e);
                }
            });

        }

        if($('#defaultCheck1').is(":checked")) {
            $('[id="defaultCheckChild"]').prop("checked", true);
        }

    </script>

@endsection
