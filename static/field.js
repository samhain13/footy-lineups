(function() {
    var pos0 = {"x": 0, "y": 0};
    function relabel(label) {
        var newLabel = prompt("Set player label:");
        if(newLabel.replace(" ","").length>0) {
            $(label).text(newLabel);
        }
    }
    function move(p, e) {
        pos0 = {"x": e.pageX, "y": e.pageY}; // initial position.
        $(window).mousemove( function(e) {
            var player = $(p).parent();
            var pos1 = {"x": e.pageX, "y": e.pageY};
            player.css({
                "left": parseInt(player.css("left")) + (pos1["x"] - pos0["x"]),
                "top": parseInt(player.css("top")) + (pos1["y"] - pos0["y"]),
            });
            pos0 = pos1; // update the actual position.
        });
        $(window).mouseup( function(e) {
            $(window).unbind("mousemove");
            $(window).unbind("mouseup");
        });
    }
    function save_lineup() {
        var players = [];
        $(".player").each(function() {
            var l = $($(this).find(".player-label")).text();
            var p = parseInt($(this).css("left")) + value_delimiter +
                parseInt($(this).css("top")) + value_delimiter +
                l.replace(/"/g, "\\\"");
            players.push(p);
        });
        var frm = $('<form action="' +save_action+ '" method="post"></form>');
        var tx = $("<textarea name=\"lineup\">" + players.join("\n") + "</textarea>");
        frm.append(tx);
        frm.hide();
        $("body").append(frm);
        frm.submit();
    }
    $(document).ready( function() {
        var pitch = $("#pitch");
        for (var i=0; i<11; i++) {
            var pid = "player-" + (i + 1);
            if (has_lineup < 1) {
                var p = $('<div id="' + pid + '" class="player"></div>');
                var label = "Player " + (i + 1);
                p.css({"left": -75, "top": i * 50});
            } else {
                var p = $("#" + pid);
                var label = p.data()["label"];
            }
            p.append($('<div class="player-button"></div>'));
            p.append($('<div class="player-label">' + label + '</div>'));
            pitch.append(p);
            $("#" + pid + " .player-button").mousedown(function(e) { move(this, e); });
            $("#" + pid + " .player-label").click(function() { relabel(this); });
        }
        $("#reset-button").click(function() {
            location.href = location.href.split("?")[0];
        });
        $("#save-button").click(function() { save_lineup(); });
    });
}).call(this);
