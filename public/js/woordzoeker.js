$(document).ready(function() {

    // sliders
    var sliders = $("input.slider");
    sliders.slider({
        tooltip: 'always'
    });
    sliders.on('slideStop', function() {
        var value = $(this).slider('getValue');
        $(this).val(value);
    });

    // drawing lines on canvas
    var canvas = document.getElementById('canvas');
    var ctx = canvas.getContext('2d');
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.lineWidth = 10;
    ctx.strokeStyle = '#ff0000'; // TODO use pretty color

    // returns mouse position on grid
    function getMousePos(event) {
        var rect = canvas.getBoundingClientRect();
        return {
            x: Math.floor((event.clientX - rect.left) / 40),
            y: Math.floor((event.clientY - rect.top) / 40)
        };
    }

    // the mouse move listener
    var drawStartPos = null;
    var drawing = false;
    var mouseListener = function(event) {
        var mousePos = getMousePos(event);
        if (drawing) {
            ctx.beginPath();
            ctx.moveTo(drawStartPos.x * 40 + 20.5, drawStartPos.y * 40 + 20.5);
            ctx.lineTo(mousePos.x * 40 + 20.5, mousePos.y * 40 + 20.5);
            ctx.stroke();
        }
    };

    canvas.addEventListener('click', function(event) {
        if (drawing) {

            drawStartPos = null;
            drawing = false;
            canvas.removeEventListener('mousemove', mouseListener, false);
        } else {
            drawStartPos = getMousePos(event);
            drawing = true;
            canvas.addEventListener('mousemove', mouseListener, false);
        }
    });
});
