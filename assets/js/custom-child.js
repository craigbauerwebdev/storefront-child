jQuery(document).ready(function($) {
    var ChildEvents = function() {
        var events = {
            init: function() {
                MK.openMobileMenu();
                MK.closeMobileMenu();
            },
            closeMobileMenu: function() {
                $('.close-menu').on('click', function(){
                    $('.mobile-menu-inner').fadeOut();
                });
            },
            openMobileMenu: function() {
                $('.menu-toggle-custom').on('click', function(){
                    $('.mobile-menu-inner').fadeIn();
                });
            }
        }
        return events;  
    }
    MK = new ChildEvents();
    MK.init();
})(jQuery);