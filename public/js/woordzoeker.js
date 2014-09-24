$(document).ready(function() {

    var sliders = $("input.slider");
    sliders.slider({
        tooltip: 'always'
    });
    sliders.on('slideStop', function() {
        var value = $(this).slider('getValue');
        $(this).val(value);
    });

});
