/**
 * Set recently viewed ADMIN page url in cookies.
 * Get recently viewed PUBLIC page url from cookies and change switcher button url.
 */

document.addEventListener("DOMContentLoaded", function() {
    var get_cookie = function(name) {
        name += "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i <ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    };

    var set_cookie = function(name, value) {
        var d = new Date();
        d.setTime(d.getTime() + (30*24*60*60*1000));
        var expires = "expires="+ d.toUTCString();
        document.cookie = name + "=" + value + ";" + expires + ";path=/";
    };

    var recent_page_url = get_cookie('switcher_recent_page_url');
    if (recent_page_url) {
        var wp_admin_bar_switcher = document.getElementById('wp-admin-bar-switcher');
        var wp_admin_bar_switcher_links = wp_admin_bar_switcher.getElementsByTagName('a');
        if (wp_admin_bar_switcher_links.length) {
            wp_admin_bar_switcher_links[0].href = recent_page_url;
        }
    }

    set_cookie('switcher_admin_recent_page_url', window.location.href);
});