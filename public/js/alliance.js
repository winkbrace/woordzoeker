function drawAlliance(selected)
{
    var size = 10;
    var offsetX = 25.5;
    var offsetY = -15.5;
    var limitX = (3 * size) + offsetX;
    var limitY = (3 * size) + offsetY;

    var canvas = document.getElementById("allianceCanvas");
    var ctx = canvas.getContext("2d");

    function clearCanvas()
    {
        canvas.width = canvas.width; // clears contents
        ctx.rotate(Math.PI / 4);
    }

    function drawAllianceCanvas()
    {
        clearCanvas();

        // vertical lines
        for (var x = offsetX; x <= limitX; x += size)
        {
            ctx.moveTo(x, offsetY);
            ctx.lineTo(x, limitY);
        }

        // horizontal lines
        for (var y = offsetY; y <= limitY; y += size)
        {
            ctx.moveTo(offsetX, y);
            ctx.lineTo(limitX, y);
        }

        ctx.strokeStyle = "black";
        ctx.stroke();

        // text
        ctx.font = "8px Arial";
        ctx.fillStyle = "black";
        ctx.fillText("LAWFUL", offsetX, offsetY - 4);
        ctx.fillText("CHAOTIC", offsetX - 2, limitY + 10);

        ctx.rotate(-Math.PI / 2);
        ctx.fillText("GOOD", -11, 22);
        ctx.fillText("EVIL", -8, 65);
        ctx.rotate(Math.PI / 2);
    }

    function fillAllianceTile(alliance, selectColor)
    {
        // reinitialize the tiny canvas is the simplest way
        drawAllianceCanvas();

        var xAxis = {'G': offsetX, 'N': offsetX + size, 'E': offsetX + 2*size};
        var yAxis = {'L': offsetY, 'N': offsetY + size, 'C': offsetY + 2*size};

        // fill tile
        ctx.fillStyle = selectColor;
        ctx.fillRect(xAxis[alliance[1]], yAxis[alliance[0]], size, size);

        // set hidden input value
        $('#alliance').val(alliance);
    }

    function getMousePos(event) {
        var rect = canvas.getBoundingClientRect();
        return {
            x: event.clientX - rect.left,
            y: event.clientY - rect.top
        };
    }

    drawAllianceCanvas();

    if (selected) {
        fillAllianceTile(selected, 'black');
    }

    canvas.addEventListener('click', function(event) {
        var pos = getMousePos(event);
        if (pos.x >= 25.5 && pos.x <= 32.5 && pos.y >= 11.5 && pos.y <= 17.5) { fillAllianceTile('LG', 'grey'); }
        else if (pos.x >= 17.5 && pos.x <= 25.5 && pos.y >= 17.5 && pos.y <= 25.5) { fillAllianceTile('NG', 'grey'); }
        else if (pos.x >= 11.5 && pos.x <= 17.5 && pos.y >= 25.5 && pos.y <= 32.5) { fillAllianceTile('CG', 'grey'); }
        else if (pos.x >= 32.5 && pos.x <= 38.5 && pos.y >= 17.5 && pos.y <= 25.5) { fillAllianceTile('LN', 'grey'); }
        else if (pos.x >= 25.5 && pos.x <= 32.5 && pos.y >= 25.5 && pos.y <= 32.5) { fillAllianceTile('NN', 'grey'); }
        else if (pos.x >= 18.5 && pos.x <= 25.5 && pos.y >= 32.5 && pos.y <= 38.5) { fillAllianceTile('CN', 'grey'); }
        else if (pos.x >= 38.5 && pos.x <= 46.5 && pos.y >= 25.5 && pos.y <= 32.5) { fillAllianceTile('LE', 'grey'); }
        else if (pos.x >= 32.5 && pos.x <= 38.5 && pos.y >= 32.5 && pos.y <= 38.5) { fillAllianceTile('NE', 'grey'); }
        else if (pos.x >= 25.5 && pos.x <= 32.5 && pos.y >= 38.5 && pos.y <= 45.5) { fillAllianceTile('CE', 'grey'); }
    }, false);
}

drawAlliance();
