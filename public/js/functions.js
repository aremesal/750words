var resizeTimer;

$(document).ready(function(){

    focusInput();

    adjustSizes();
    /*
    $(window).resize(function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function(){
            adjustSizes();
        }, 100);
    });
    */

    $('#fTodayText').submit( function(ev){
        ev.preventDefault();

        saveText();

    });

    $('form').submit(function(){
        var submit = $(this).children('input[submit]');
        submit.attr('disabled','disabled');
        submit.after(' <img src="/images/loading.gif" /> Enviando, espera por favor...');
    });

    $('.aFooterLogged').tipsy({gravity: 'e'});
    $('.aFooterHeader').tipsy({gravity: 'w'});
    $('.dvMsg a').tipsy({gravity: 'ne'});

    if( $('div.dvMsg').length > 0 ) {
        $('div.dvMsg a').click(function(ev){
            ev.preventDefault();
            $('div.dvMsg').slideUp(600);
        });
        $('div.dvMsg').slideDown(300, function(){
            setTimeout(function(){
                $('div.dvMsg').slideUp(600);
            }, 10000);
        });
    }
    
    if( $('textarea#text').length > 0 ) {
        $('textarea#text').wordCount({callback: colorCounter, callback_on_init: true});
    }

    // Autosave
    if( $('#fTodayText').length > 0 ) {
        autoSaveText();
    }
    
    // Attenuate password field
    $('input#registerpass').keypress( function(){        
        if( $(this).val().length > 0 ) {
            $(this).addClass('attenuated');
        }
        else {
            $(this).removeClass('attenuated');
        }
    });
    
});

var swSaving = 0;

function autoSaveText() {
    setTimeout( function(){
        if( swSaving == 0) {
            swSaving = 1;
            $('#fTodayText').submit();
        }
        autoSaveText();
    }, 15000);
}

function saveText() {
    $.ajax({
        type: 'POST',
        url: '/write/saveText',
        data: ({
            'uid': $('input#uid').val(),
            'text': $('textarea#text').val()
        }),
        success: function(data){
            //alert(data);
            if( data != 'NULL') {
                $('#spSaved_at').html(data);
            }
            swSaving = 0;
        }
    });
}

function colorCounter(count, elem) {
    if( count > 750 ) {
        $('#' + elem).addClass('challenge-completed');
    }
    else {
        $('#' + elem).removeClass('challenge-completed');
    }
}

function getTextByDay(date) {

    $('#dayText').fadeOut(200, function(){
        $('#dayText').html('<div>Cargando texto...</div>');
        $('#dayText').fadeIn(200, function(){
            $.ajax({
                type: 'POST',
                url: '/read/getTextByDay',
                data: ({
                    'date': date
                }),
                success: function(data){
                    //alert(data);
                    var retData = eval('(' + data + ')');
                    $('#dayCount span#dayCount').html(retData.count);
                    $('#dayText').fadeOut(500, function(){
                        $('#dayText').html(retData.text);
                        $('#dayText').fadeIn(500);
                    });


                }
            });
        });
    });
}

function adjustSizes() {
    var docH = $(document).height();

    if( $('#dayText').length > 0 ) {
        $('#dayText').css('height', eval(docH-200) + 'px');
    }

    if( $('#dvFooter div').length > 0 ) {
        $('#dvFooter div').css('margin-top', eval(docH-130) + 'px');
    }

    if( $('textarea#text').length > 0 ) {
        $('textarea#text').css('height', eval(docH-140) + 'px');
        /*
        $('textarea#text').autoResize({
            maxHeight: eval(docH-140)
        });
        */
    }
}

function focusInput() {
    $('label').click(function(){
        $(this).children('input').focus();
        $(this).children('input').select();
    });
}