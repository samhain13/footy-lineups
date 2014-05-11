(function() {
    var playerCount = 0; // why? ->ready and ->save-button.click
    var pos0 = {"x": 0, "y": 0};
    function relabel(label) {
        var newLabel = prompt("Set player label:");
        if(newLabel.replace(" ","").length>0) {
            $(label).text(newLabel);
        } else {
            alert("Your input was empty.");
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
        var pitch = $("#gas-container");
        //var pitch = $("#pitch");
        // Original line by samhain13; places the players into the pitch.
        // However, I think this is a bit better :P
        for (playerCount=0; playerCount<11; playerCount++) {
            var p = $('<div id="player-' + (playerCount+1) + '" class="player"></div>');
            if (lineup) {
                var label = lineup[i]["label"];
                p.css({"left": lineup[i]["left"], "top": lineup[i]["top"]});
            } else {
                var label = "#" + (playerCount + 1);
                //p.css({"left": 0, "top": i * 50});
            }
            p.append($('<div class="player-button"></div>'));
            p.append($('<div class="player-label">' + label + '</div>'));
            pitch.append(p);
            $("#player-" + playerCount + " .player-button").mousedown(function(e) { move(this, e); });
            $("#player-" + playerCount + " .player-label").click(function() { relabel(this); });
        }
        $("#reset-button").click(function() {
            location.href = location.href.split("?")[0];
        });
        $("#save-button").click(function() { save_lineup(); });
        $("#player-add-button").click( function() {
            playerCount++;
            var pitch = $("#gas-container");
            var p = $('<div id="' + playerCount + '" class="player"></div>');
            p.append($('<div class="player-button"></div>'));
            p.append($('<div class="player-label">#' + playerCount + '</div>'));
            pitch.append(p);
            $("#player-" + playerCount + " .player-button").mousedown(function(e) { move(this, e); });
            $("#player-" + playerCount + " .player-label").click(function() { relabel(this); });
        });

    });
}).call(this);
