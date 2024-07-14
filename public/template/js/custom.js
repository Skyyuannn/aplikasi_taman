/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

var path = location.pathname.split('/')
if (path[2] == 'master-data' || path[2] == 'flowers') {
    var url = location.origin + "/" + path[1] + "/" + path[2] + "/" + path[3]
    $('ul.sidebar li a').each(function () {
        if ($(this).attr('href').indexOf(url) !== -1) {
            $(this).parent().parent().parent('li').addClass('active')
            console.log($(this));
        }
    })
}
else {
    var url = location.origin + "/" + path[1] + "/" + path[2]
    $('ul.sidebar li a').each(function () {
        if ($(this).attr('href').indexOf(url) !== -1) {
            $(this).parent().addClass('active').parent().parent('li').addClass('active')
        }
    })
    
}