

$( document ).ready(function() {
	/* scroll a grilla */
    $('a[href*=#]:not([href=#])').click(function() {
        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.substr(1) +']');
        if (target.length) {
            $('html,body').animate({
              scrollTop: target.offset().top-40
            }, 1000);
            return false;
        }
    });

	/*tooltips*/

    $("[rel='tooltip']").tooltip();

	$("input[data-toggle='tooltip']").on('focus', function() {
	    $(this).tooltip('show');
	});

	$("input[data-toggle='tooltip']").on('blur', function() {
	    $(this).tooltip('show');
	});


});

