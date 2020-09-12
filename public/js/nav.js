$(document).ready(function(){
    $('.menujq > ul > li:has(ul)').addClass('desplegable');
    $('.menujq > ul > li > a').click(function() {
        var comprobar = $(this).next();
        $('.menujq li').removeClass('activa');
        $(this).closest('li').addClass('activa');
        if((comprobar.is('ul')) && (comprobar.is(':visible'))) {
            $(this).closest('li').removeClass('activa');
            comprobar.slideUp('normal');
        }
        if((comprobar.is('ul')) && (!comprobar.is(':visible'))) {
            $('.menujq ul ul:visible').slideUp('normal');
            comprobar.slideDown('normal');
        }
    });
});


$(document).ready(function(){
    $(".hamburger .hamburger__inner").click(function(){
    $(".wrapper").toggleClass("active")
    document.getElementsByClassName('profile_dd')[0].classList.remove('active')
    })

    $(".top_navbar .fas").click(function(){
        $(".profile_dd").toggleClass("active");
        document.getElementsByClassName('wrapper')[0].classList.add('active')
    });
})
