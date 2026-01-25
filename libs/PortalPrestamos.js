$().ready(function(){
    $("#btnCancelar").click(function() {
        var url="http://www.sntsepomex.org/";
        $(location).attr('href',url);
    });
});

