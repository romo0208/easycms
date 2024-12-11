$(document).ready(function() {
    $('tr.post').click(function() {

        var href = $(this).find("a").attr("href");
        if(href) {
            window.location = href;
        }
    });

});
function calc(element, id)
{
    if(element.checked) {
        document.getElementById(id).checked = false;
    }                            
}
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah')
            .attr('src', e.target.result)
            .width(320)
            .height(240);
        };

        reader.readAsDataURL(input.files[0]);
    }
}