$(document).ready(function(){
    $(".focmd").on("submit",function(e) {
        e.preventDefault();
        if($(this).find(".chcm").prop('checked')==false && $("#table_opc input:checked").length==0){
            alert($("#lg1").text());
        }else{
            $("#"+$(this).attr("id")+" .cpc").val($("#table_opc input:checked").map(function() {return this.id;}).get().join());
            cmdA($(this).attr("id"));
        }
    });
    $(".chcm").click(function() {
        if($(this).prop('checked')){
     //  alert($(this).parents("form").first().find(".cmda").first().attr("class"));
            $(this).parents("form").first().find(".cmda").removeClass("d-none");
        }else{
            $(this).parents("form").first().find(".cmda").addClass("d-none");
        }
    });
});
function cmdA(fid) {
    var sbt=$("#"+fid+" .subcmd").text();
    alert($("#"+fid).serialize());
    $("#"+fid+" .alert").addClass('d-none');
    $.ajax({
        type: $("#"+fid).attr('method'),
        url: $("#"+fid).attr('action'),
        data: $("#"+fid).serialize(),
        beforeSend: function(e) {
            $("#"+fid+" .subcmd").prop('disabled', true);
            $("#"+fid+" .subcmd").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
        },
        success: function(data) {
            $("#"+fid+" .subcmd").prop('disabled', false);
            $("#"+fid+" .subcmd").html(sbt);    
            $("#tstm").text($("#lg2").text());
            $('#liveToast').toast('show');
        },
    })
    .fail(function(e){
        $("#"+fid+" .subcmd").prop('disabled', false);
        $("#"+fid+" .subcmd").html(sbt);
        var err=e.responseText;
        /*if(e.responseJSON['errors']!=undefined){
        $.each(e.responseJSON['errors'], function(key, value){
            err+="<br>"+key+": "+value;
            });
        }*/
        $("#"+fid+" .alert p").html(err);
        $("#"+fid+" .alert").removeClass('d-none');
    });
}