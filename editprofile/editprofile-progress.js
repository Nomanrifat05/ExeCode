progressCircularBar('dirrerentIDForEachCircle', '#4caf4f');
progressFill('progressFillEasy', 75);
progressFill('progressFillMedium', 75);
progressFill('progressFillHard', 75);

function progressFill(incomingID, incomingPercent) {
    var el = document.getElementById(incomingID);
    var options = {
        percent: el.getAttribute('data-percent') || incomingPercent,
    };
    el.style.width = options.percent + '%';
}

function progressCircularBar(incomingID, incomingColor) {
    var el = document.getElementById(incomingID);
    var options = {
        percent: el.getAttribute('data-percent') || 0,
        problemSolved: el.getAttribute('data-problem-solved') || 0,
        totalProblem: el.getAttribute('data-total-problem') || 0,
        status: el.getAttribute('data-status') || 25,
        size: el.getAttribute('data-size') || 220,
        lineWidth: el.getAttribute('data-line') || 15,
        rotate: el.getAttribute('data-rotate') || 0,
    };

    var canvas = document.createElement('canvas');
    var span = document.createElement('div');
    // Set the text content of the span to the number of problems solved and the status in two lines
    span.className = 'circular-stat-inside';
    // span.style.width = options.size + 'px';
    // span.style.lineHeight = options.size + 'px';
    span.style.textAlign = 'center';
    span.style.fontSize = '25px';
    span.style.fontWeight = '600';
    span.style.color = '#555';
    span.style.display = 'flex';
    span.style.flexDirection = 'row';
    span.style.justifyContent = 'center';
    span.style.alignItems = 'center';
    span.style.height = '20px';
    // span.style.lineHeight = '1.5';
    span.textContent = options.problemSolved;

    // create a span for the total problems solved
    var totalProblemsSpan = document.createElement('span');
    totalProblemsSpan.textContent = '/' + options.totalProblem + '\n';
    totalProblemsSpan.style.fontSize = '16px';  
    totalProblemsSpan.style.fontWeight = '100';
    totalProblemsSpan.style.margin = '0px';
    totalProblemsSpan.style.color = '#9a9a9a';

    // Append the total problems span to the main span
    span.appendChild(totalProblemsSpan);
    // Set the text content of the span to the status


    // Create a second span for the status
    var span2 = document.createElement('div');
    span2.className = '';
    span2.style.textAlign = 'center';
    span2.style.fontSize = '16px';
    span2.style.fontWeight = '100';
    span2.style.color = '#9a9a9a';
    span2.textContent = options.status;

    if (typeof G_vmlCanvasManager !== 'undefined') {
        G_vmlCanvasManager.initElement(canvas);
    }

    var ctx = canvas.getContext('2d');
    canvas.width = canvas.height = options.size;

    el.appendChild(span);
    el.appendChild(span2);
    el.appendChild(canvas);

    ctx.translate(options.size / 2, options.size / 2); // change center
    ctx.rotate((-1 / 2 + options.rotate / 180) * Math.PI); // rotate -90 deg

    //imd = ctx.getImageData(0, 0, 240, 240);
    var radius = (options.size - options.lineWidth) / 2;

    var drawCircle = function (color, lineWidth, percent) {
        percent = Math.min(Math.max(0, percent || 1), 1);
        ctx.beginPath();
        ctx.arc(0, 0, radius, 0, Math.PI * 2 * percent, false);
        ctx.strokeStyle = color;
        ctx.lineCap = 'round'; // butt, round or square
        ctx.lineWidth = lineWidth;
        ctx.stroke();
    };

    drawCircle('#efefef', options.lineWidth, 100 / 100);
    drawCircle(incomingColor, options.lineWidth, options.percent / 100);

    document.getElementById(incomingID).style.width = options.size + 'px';
    document.getElementById(incomingID).style.height = options.size + 'px';
    // span.style.width = 92+"px";
    // span.style.lineHeight = options.size+"px";
}
