$(document).ready(function() {

    // sliders
    var sliders = $("input.slider");
    sliders.slider({
        tooltip: 'always'
    });
    sliders.on('slideStop', function() {
        var value = $(this).slider('getValue');
        $(this).val(value);
    }).trigger('slideStop');

    // create grid with the letters in the puzzle
    var grid = [];
    var gridIndex = 0;
    $('#woordzoeker-table').find('tr').each(function(index, tr) {
        var line = $('td', tr).map(function(index, td) {
            return $(td).text();
        });
        grid[gridIndex++] = line;
    });

    // canvas init
    var canvas = document.getElementById('canvas');
    var ctx = canvas.getContext('2d');
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.lineWidth = 10;
    ctx.strokeStyle = '#ff0000';
    ctx.globalAlpha = 0.5;

    var canvasFound =  document.getElementById('canvas-found');
    var ctxFound = canvasFound.getContext('2d');
    ctxFound.lineWidth = 10;
    ctxFound.strokeStyle = 'purple';
    ctxFound.globalAlpha = 0.5;

    // returns mouse position on grid
    function getMousePos(event)
    {
        var rect = canvas.getBoundingClientRect();
        return {
            x: Math.floor((event.clientX - rect.left) / 40),
            y: Math.floor((event.clientY - rect.top) / 40)
        };
    }

    function validateLine(startPos, currentPos)
    {
        if (startPos.x == currentPos.x && startPos.y == currentPos.y) {
            return false;
        }

        if (startPos.x == currentPos.x || startPos.y == currentPos.y) {
            return true;
        } else {
            return Math.abs(currentPos.x - startPos.x) == Math.abs(currentPos.y - startPos.y);
        }
    }

    var currentLine = '';
    function storeLine(startPos, currentPos)
    {
        currentLine = '';
        var x, y;
        if (startPos.x < currentPos.x) {
            if (startPos.y < currentPos.y) {
                for (x = startPos.x, y = startPos.y; x <= currentPos.x; x++, y++) {
                    currentLine += grid[y][x];
                }
            } else if (startPos.y > currentPos.y) {
                for (x = startPos.x, y = startPos.y; x <= currentPos.x; x++, y--) {
                    currentLine += grid[y][x];
                }
            } else /* (startPos.y == currentPos.y) */ {
                for (x = startPos.x, y = startPos.y; x <= currentPos.x; x++) {
                    currentLine += grid[y][x];
                }
            }
        } else if (startPos.x > currentPos.x) {
            if (startPos.y < currentPos.y) {
                for (x = startPos.x, y = startPos.y; x >= currentPos.x; x--, y++) {
                    currentLine += grid[y][x];
                }
            } else if (startPos.y > currentPos.y) {
                for (x = startPos.x, y = startPos.y; x >= currentPos.x; x--, y--) {
                    currentLine += grid[y][x];
                }
            } else /* (startPos.y == currentPos.y) */ {
                for (x = startPos.x, y = startPos.y; x >= currentPos.x; x--) {
                    currentLine += grid[y][x];
                }
            }
        } else if (startPos.x == currentPos.x) {
            if (startPos.y < currentPos.y) {
                for (x = startPos.x, y = startPos.y; y <= currentPos.y; y++) {
                    currentLine += grid[y][x];
                }
            } else if (startPos.y > currentPos.y) {
                for (x = startPos.x, y = startPos.y; y >= currentPos.y; y--) {
                    currentLine += grid[y][x];
                }
            }
        }
    }

    function handlePossiblyFoundWord(mousePos)
    {
        // all words to search are in a span with the word as id
        var wordSpan = document.getElementById(currentLine);
        if (wordSpan) {
            $(wordSpan)
                .css("text-decoration", "line-through")
                .animate({"font-size": "20px"})
                .fadeTo('slow', 0.5).fadeTo('slow', 1.0)
                .animate({"font-size": "14px"})
                .removeAttr('data-todo');

            // copy line as purple line to the canvas-found
            ctxFound.beginPath();
            ctxFound.moveTo(drawStartPos.x * 40 + 20.5, drawStartPos.y * 40 + 20.5);
            ctxFound.lineTo(mousePos.x * 40 + 20.5, mousePos.y * 40 + 20.5);
            ctxFound.stroke();
        }

        if ($('div.words-list span[data-todo]').size() == 0) {
            var imgWidth = 350;
            var imgHeight = 250;
            var centerOptions = {
                'position': 'absolute',
                'left': (window.innerWidth - imgWidth) / 2,
                'top': (window.innerHeight - imgHeight) / 2,
                'z-index': 2000
            }
            var fullScreenOptions = {
                'height' : '100%',
                'left': ((window.innerWidth - (imgWidth * window.innerHeight / imgHeight)) / 2),
                'top': 0
            }
            $('#hoera-image').css(centerOptions).fadeIn().animate(fullScreenOptions, 1000).fadeOut(10000);
        }
    }

    // the mouse move listener
    var drawStartPos = null;
    var drawing = false;
    var mouseListener = function(event) {
        var mousePos = getMousePos(event);
        if (drawing && validateLine(drawStartPos, mousePos)) {
            storeLine(drawStartPos, mousePos);
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.beginPath();
            ctx.moveTo(drawStartPos.x * 40 + 20.5, drawStartPos.y * 40 + 20.5);
            ctx.lineTo(mousePos.x * 40 + 20.5, mousePos.y * 40 + 20.5);
            ctx.stroke();
        }
    };

    canvas.addEventListener('mousedown', function(event) {
        drawStartPos = getMousePos(event);
        drawing = true;
        canvas.addEventListener('mousemove', mouseListener, false);
    });
    canvas.addEventListener('mouseup', function(event) {
        handlePossiblyFoundWord(getMousePos(event));
        drawStartPos = null;
        drawing = false;
        canvas.removeEventListener('mousemove', mouseListener, false);
    });
    canvas.addEventListener("mouseout", function(event) {
        if (drawing) {
            handlePossiblyFoundWord(getMousePos(event));
            drawStartPos = null;
            drawing = false;
        }
        canvas.removeEventListener('mousemove', mouseListener, false);
    })
});
