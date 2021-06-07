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
                    {{__('translate.cm')}}
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
                                                    {{ $value->name }}
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
                                                                    <form id="fc{{$value->id_listcmd}}" class="focmd" method="POST" action="{{route('create.cmd')}}">
                                                                    <input type="hidden" name="pc" class="cpc"/>
                                                                    @csrf
                                                        <div class="modal-body">
                                                                    <div class="form-group row">
                                                                        <label for="staticEmail" class="col-sm-3 col-form-label">{{__('translate.cmd')}}</label>
                                                                        <div class="col-sm-9">
                                                                            <input type="text" readonly class="form-control-plaintext text-white" name="cmm" value="{{ $value->name_cmd }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label for="inputPassword" class="col-sm-3 col-form-label">{{__('translate.pm')}}</label>
                                                                        <div class="col-sm-9">
                                                                            @for($i = 1; $i <= $value->param; $i++)
                                                                                <input type="text" class="form-control" placeholder="{{__('translate.pm')}} {{ $i }}" name="param_{{ $i }}" required />
                                                                                <br />
                                                                            @endfor
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label for="descc" class="col-sm-3 col-form-label">Description</label>
                                                                        <div class="col-sm-9">
                                                                            <div class="card" style="background-color:rgba(255,255,255,0.2);">
                                                                           <div class="card-body"> {{ $value->description }}</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                    <label for="inputPassword" class="col-sm-3 col-form-label"></label>
                                                                    <div class="col-sm-9">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input chcm" type="checkbox" name="chca" id="chcm{{$value->id_listcmd}}">
                                                                            <label class="form-check-label" for="chcm{{$value->id_listcmd}}">
                                                                                {{__('translate.aca')}}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    </div>
                                                                    <div class="form-group row cmda d-none">
                                                                        <label for="sop{{$value->id_listcmd}}" class="col-sm-3 col-form-label">Operation</label>
                                                                        <div class="col-sm-9">
                                                                            <select class="custom-select custom-select-sm w-50 mr-2" name="cop" id="sop{{$value->id_listcmd}}">
                                                                            <option selected disabled>{{__('translate.sop')}}</option>
                                                                            @foreach($operationpc as $pc)
                                                                                <option value="{{ $pc->ops_name }}">{{ $pc->ops_name }}</option>
                                                                            @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>  
                                                                    <div class="form-group row cmda d-none">
                                                                        <label for="inputPassword" class="col-sm-3 col-form-label">{{__('translate.ord')}}</label>
                                                                        <div class="col-sm-4">
                                                                        <input type="text" class="form-control" name="cord" value="1">
                                                                        </div>
                                                                    </div>
                                                                    <div class="alert alert-danger alert-dismissible fade show d-none" role="alert">
                                                                    <p></p>
                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                    </div>
                                                            </div>
                                                            <div class="modal-footer">

                                                                <button type="cancel" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">{{__('translate.ca')}}</button>
                                                                <button type="submit" class="btn btn-primary btn-sm subcmd">{{__('translate.se')}}</button>
                                                            </div>
                                                            </form>
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
                        <button class="btn btn-secondary btn-sm" data-target="#create_operation" data-toggle="modal">{{__('translate.cr')}}</button>
                    </span>
                    <span class="mr-1">{{__('translate.op')}} :</span>
                    <select class="custom-select custom-select-sm w-50 mr-2" id="selectOperation">
                        <option selected disabled>{{__('translate.sop')}}</option>
                        @foreach($operationpc as $pc)
                            <option value="{{ $pc->id }}">{{ $pc->ops_name }}</option>
                        @endforeach
                    </select>
                    <span class="mr-1">{{__('translate.on')}} :</span>
                    <input type="number" placeholder="Minute" class="form-control form-control-sm d-inline" id="selectTime" value="30" style="width: 100px" disabled />
                </div>
                <div class="card-body">

                    <div class="text-center h2 text-muted" id="canvas_pc_none">
                    {{__('translate.sop')}}
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
                            <b>{{__('translate.nm')}} :</b> <span id="name_opc"></span>
                            <br />
                            <b>{{__('translate.cmt')}} :</b> <span id="desc_opc"></span>
                        </h6>

                        <hr />

                        <div class="table-responsive" id="table_pc">
                            <table class="table table-hover table-dark table-sm">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="defaultCheck1">
                                        </div>
                                    </th>
                                    <th scope="col"></th>
                                    <th scope="col">{{__('translate.nm')}}</th>
                                    <th scope="col">IP</th>
                                    <th scope="col">{{__('translate.do')}}</th>
                                    <th scope="col">Description</th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody id="table_opc">
                                </tbody>
                            </table>
                        </div>

                        <h5 class="text-center text-muted" id="no_pc"> {{__('translate.nop')}} </h5>

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
                        <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#create_agent">{{__('translate.add')}}</button>
                    </span>
                    {{__('translate.lag')}}
                </div>
                <div class="card-body overflow-auto">

                    <div class="text-center text-small text-muted" id="canvas_ag_none">
                    {{__('translate.sop')}}
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
                                            <input class="form-check-input" type="checkbox" value="" >
                                        </div>
                                    </th>
                                    <th scope="col"></th>
                                    <th scope="col">{{__('translate.nm')}}</th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody id="table_agent">
                                </tbody>
                            </table>
                        </div>

                        <div class="text-center text-small text-muted" id="no_ag"> {{__('translate.nag')}} </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card bg-dark" style="height: 260px">
                <div class="card-header">
                    <span class="float-right" {{ Auth::user()->roles == 1 ? '' : 'hidden' }}>
                        <button class="btn btn-danger btn-sm" id="del_all_res" data-toggle="modal" data-target="#delete_result" disabled>{{__('translate.dela')}}</button>
                    </span>
                    {{__('translate.rcm')}} <span id="on_res"></span>
                </div>
                <div class="card-body overflow-auto">

                    <div class="text-center h2 text-muted" id="res_none_pc">
                    {{__('translate.spc')}}
                    </div>

                    <p id="canvas_res" class="text-center" style="display: none">
                        <img src="{{ asset('public/files/v24/loading.gif') }}" style="width: 50px" alt="loading" />
                    </p>

                    <h5 class="text-center text-muted" id="no_res_pc" style="display: none">{{__('translate.nrp')}}</h5>

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
                    <h6 class="modal-title" id="exampleModalLabel">{{__('translate.addag')}}</h6>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group row">
                          <label for="staticEmail" class="col-sm-3 col-form-label">{{__('translate.nm')}}</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="staticEmail" placeholder="{{__('translate.nmag')}}">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputPassword" class="col-sm-3 col-form-label">{{__('translate.fi')}}</label>
                          <div class="col-sm-9">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFileLangHTML">
                                <label class="custom-file-label" for="customFileLangHTML" data-browse="{{__('translate.br')}}">{{__('translate.fi')}}</label>
                              </div>
                          </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">{{__('translate.ca')}}</button>
                    <button type="submit" class="btn btn-primary btn-sm">{{__('translate.cr')}}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="all_cmd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">{{__('translate.auc')}}</h6>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <table class="table table-hover table-dark table-sm">
                        <thead class="thead-light">
                          <tr>
                            <th>{{__('translate.cmd')}}</th>
                            <th>{{__('translate.or')}}</th>
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
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">{{__('translate.cl')}}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="create_operation" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark">
                <form id="create_opc" method="post" action="{{ route('create.operation') }}">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel">{{__('translate.cop')}}</h6>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            @csrf
                            <div class="form-group row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">{{__('translate.nm')}}</label>
                            <div class="col-sm-9">
                                <input type="text" name="ops_name" class="form-control" placeholder="{{__('translate.nmop')}}" required />
                                <small></small>
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="inputPassword" class="col-sm-3 col-form-label">{{__('translate.cmt')}}</label>
                            <div class="col-sm-9">
                                <textarea name="description" rows="5" placeholder="{{__('translate.cmt')}}" class="form-control" required></textarea>
                                <small></small>
                            </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">{{__('translate.ca')}}</button>
                        <button type="submit" class="btn btn-primary btn-sm" id="btn_submit">{{__('translate.cr')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete_result" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">{{__('translate.drs')}}</h6>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                {{__('translate.wrn.drs')}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">{{__('translate.ca')}}</button>
                    <button type="submit" class="btn btn-danger btn-sm">{{__('translate.del')}}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit_operation" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark">
                <form id="edit_ops" method="post" action="{{ route('edit.operation') }}">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel">{{__('translate.eop')}}</h6>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            @csrf
                            <div class="form-group row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">{{__('translate.nm')}}</label>
                            <div class="col-sm-9">
                                <input type="hidden" name="id" id="ops_id" value="" />
                                <input type="text" name="ops_name" id="name_ops" class="form-control" placeholder="{{__('translate.nmop')}}" required />
                                <small></small>
                            </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-3 col-form-label">{{__('translate.cmt')}}</label>
                                <div class="col-sm-9">
                                    <textarea name="description" id="desc_opc" rows="5" placeholder="{{__('translate.cmt')}}" class="form-control" required></textarea>
                                    <small></small>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">{{__('translate.ca')}}</button>
                        <button type="submit" class="btn btn-primary btn-sm" id="btn_submit">{{__('translate.edit')}}</button>
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
                        <h6 class="modal-title" id="exampleModalLabel">{{__('translate.dop')}}</h6>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="" id="ops_id" />
                        {{__('translate.wrn.dop')}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">{{__('translate.ca')}}</button>
                        <button type="submit" class="btn btn-danger btn-sm" id="btn_submit">{{__('translate.del')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <span id="lg1" class="invisible">{{__('translate.pca')}}</span>
    <span id="lg2" class="invisible">{{__('translate.cmdcr')}}</span>
    <div class="position-fixed bottom-0 right-0 p-3" style="z-index: 5; right: 0; bottom: 0;">
  <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="2000">
    <div class="toast-header">
      <strong class="mr-auto">PentaDrone</strong>
      <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="toast-body" ><div class="alert alert-success" id="tstm"></div></div>
  </div>
</div>
    {{-- End --}}

</div>
@endsection

@section('scripts')
    @parent
<script type="text/javascript" src="{{ asset('public/js/script.js') }}"></script>

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
                    $('#btn_submit').html('{{__('translate.ca')}}');
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
                                body +='<input class="form-check-input defaultCheckChild" type="checkbox" value="" id="'+data.pc+'">';
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
                                body +='<input class="form-check-input" type="checkbox" value="">';
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
                                body += '<b>{{strtoupper(__('translate.cmd'))}} :</b> ' + data.cmd;
                                body += '</small>';
                                body += '<br />';
                                body += '<small class="alert-heading">';
                                body += '<b>{{strtoupper(__('translate.res'))}} :</b> ' + data.result;
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

       

    </script>
<script type="text/javascript" src="{{ asset('public/js/cmdcrud.js') }}"></script>

@endsection
