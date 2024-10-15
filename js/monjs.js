

$(function (){
    //Afficher l'ancien mot de passe lors de l'evenement hover sur l'icone show-old-pwd
    var txtoldpwd=$('.oldpwd');
    $('.show-old-pwd').hover(function (){
        txtoldpwd.attr('type','text');

    },
        function () {
            txtoldpwd.attr('type','password');
        });

    //Afficher le nouveau mot de passe lors de l'evenement hover sur l'icone show-new-pwd
    var txtnewpwd=$('.newpwd');
    $('.show-new-pwd').hover(function (){
            txtnewpwd.attr('type','text');

        },
        function () {
            txtnewpwd.attr('type','password');
        });

    //cacher un élément
  /* $('body').onload(function(){
        $('#toutes').hide();
        $('#pardate').hide();
        $('#parperiode').hide();
    });*/

    //afficher un le div par article
    $('#toutesradio').click(function(){
        $('#toutes').show();
    });

    $('#radiopardate').click(function(){
        $('#pdate').hidden();
    });

    $('#parperioderadio').click(function(){
        $('#parperiode').show();
    });

});








