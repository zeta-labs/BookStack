
// Smooth scrolling
jQuery.fn.smoothScrollTo = function() {
    if(this.length === 0) return;
    $('body').animate({
        scrollTop: this.offset().top - 60 // Adjust to change final scroll position top margin
    }, 800); // Adjust to change animations speed (ms)
    return this;
};

// Making contains text expression not worry about casing
$.expr[":"].contains = $.expr.createPseudo(function(arg) {
    return function( elem ) {
        return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
    };
});

// Submit the form that the called upon element sits in.
jQuery.fn.submitForm = function() {
    $(this).closest('form').submit();
};

// Dropdown menu display
jQuery.fn.dropDown = function() {
    var container = $(this),
        menu = container.find('ul');
        container.find('[data-dropdown-toggle]').on('click', function() {
        menu.show().addClass('anim menuIn');
        container.mouseleave(function() {
            menu.hide();
            menu.removeClass('anim menuIn');
        });
    });
};