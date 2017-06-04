$(function(){
    var checkboxes = $('input[type=checkbox]');

    checkboxes.change(function() {
        var sendObj = {};
        sendObj.website = $(this).attr('data-website');
        sendObj.varnish = $(this).attr('data-varnish');
        if (this.checked) {
            $.ajax({
                url: "/varnish/link",
                type: 'POST',
                data: sendObj
            }).done(function() {

            });
        } else {
            $.ajax({
                url: "/varnish/link",
                type: 'DELETE',
                data: sendObj
            }).done(function() {

            });
        }
    });
});