jQuery.fn.wordCount = function(params)
{
    var p =  {
        counterElement: "wordcount_count",
        callback_on_init: false
    };

    if(params) {
        jQuery.extend(p, params);
    }

    // Shows actual number of words, if any (or zero if empty)
    var total_words = this.val().length > 0 ? this.val().split(/[\s\.,;:\!\?]+/).length : 0;
    jQuery('#'+p.counterElement).html(total_words);

    // Calls callback if defined and set to call callback on init
    if( p.callback && p.callback_on_init ) {
        p.callback(total_words, p.counterElement);
    }

    //for each keypress function on text areas
    this.keypress(function()
    {
        total_words = this.value.split(/[\s\.,;:\!\?]+/).length;
        jQuery('#'+p.counterElement).html(total_words);

        if( p.callback )
            p.callback(total_words, p.counterElement);

    });
};