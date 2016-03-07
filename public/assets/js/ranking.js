var start = 0;
var finish = 0;

$(document).ready(function(){
    reloadRanking();
    reloadRankingChart();
    reloadMessages();

    $.getJSON("/api/times.json", function(json){
        start = json.start_at;
        finish = json.finish_at;
        clock();
    });
});

function clock(){
    var date = new Date();
    var now = Math.floor(date.getTime() / 1000);
    $("#now").width(600 * ((now - start) / (finish - start)));
    $("#time").html((date.getMonth() + 1) + "/" + date.getDate() + " " + date.getHours() + ":" + date.getMinutes() +  ":" + date.getSeconds());
    setTimeout("clock()",1000);
}

function reloadMessages(){
    $.getJSON("/api/messages.json", function(json){
        $("#messages").empty();
        for(var i in json.messages){
            $("#messages").prepend("<p>" +
                json.messages[i].created_at + " " + json.messages[i].body +
                "</p>");
        }
    });
    setTimeout("reloadMessages()",60000);
}


function reloadRanking(){
    $.getJSON("/api/ranking.json", function(json){
        $("#ranking_tbody").empty();

        for(var i in json.ranking){
            var backgroundColor = "transparent";
            if(json.ranking[i].last_solved_at > Math.floor( new Date().getTime() / 1000) - 60){
                backgroundColor = "#F00";
                $("#correct")[0].currentTime = 0;
                $("#correct")[0].play();
            }
            $("#ranking_tbody").append("<tr style='background-color:" + backgroundColor + ";color:" +
                json.ranking[i].color
                + "'><td>"
                + ( parseInt(i) + 1 ) + "</td><td>" +
                json.ranking[i].team_name + "</td><td>" +
                json.ranking[i].score + "</td><td>" +
                json.ranking[i].first_point + "</td><td>" +
                json.ranking[i].total_score +
                "</td></tr>");
        }
    });
    setTimeout("reloadRanking()",60000);
}

function reloadRankingChart(){
    $.getJSON("/api/rankinghistory.json", function(json){

        var labels = [];
        for(var i in json.history[json.teams[0].id]){
            var date = new Date(json.history[json.teams[0].id][i].calculated_at * 1000);
            labels.push(date.getHours() + ":" + date.getMinutes());
        }

        var totalDatasets = [];
        var scoreDatasets = [];
        var firstScoreDatasets = [];

        for(var i in json.teams){

            var totalData = [];
            var scoreData = [];
            var firstScoreData = [];

            for(var j in json.history[json.teams[i].id]){
                totalData.push(json.history[json.teams[i].id][j].total_score);
                scoreData.push(json.history[json.teams[i].id][j].score);
                firstScoreData.push(json.history[json.teams[i].id][j].first_point);
            }

            var totalDataset = {
                    label: json.teams[i].name,
                    strokeColor: json.teams[i].color,
                    pointColor: json.teams[i].color,
                    pointStrokeColor: json.teams[i].color,
                    pointHighlightFill: json.teams[i].color,
                    pointHighlightStroke: json.teams[i].color,
                    data: totalData
                };

            var scoreDataset = {
                label: json.teams[i].name,
                strokeColor: json.teams[i].color,
                pointColor: json.teams[i].color,
                pointStrokeColor: json.teams[i].color,
                pointHighlightFill: json.teams[i].color,
                pointHighlightStroke: json.teams[i].color,
                data: scoreData
            };

            var firstScoreDataset = {
                label: json.teams[i].name,
                strokeColor: json.teams[i].color,
                pointColor: json.teams[i].color,
                pointStrokeColor: json.teams[i].color,
                pointHighlightFill: json.teams[i].color,
                pointHighlightStroke: json.teams[i].color,
                data: firstScoreData
            };

            totalDatasets.push(totalDataset);
            scoreDatasets.push(scoreDataset);
            firstScoreDatasets.push(firstScoreDataset);
        }

        var totalData = {
            labels: labels,
            datasets: totalDatasets
        };

        var scoreData = {
            labels: labels,
            datasets: scoreDatasets
        };

        var firstScoreData = {
            labels: labels,
            datasets: firstScoreDatasets
        };

        var options = {
            scaleShowGridLines : true,
            scaleGridLineColor : "rgba(50,50,50,1)",
            datasetFill : false,
            pointDot: false,
            animation: false,
            bezierCurve: false
        };

        var totalCtx = document.getElementById("total").getContext("2d");
        var totalLineChart = new Chart(totalCtx).Line(totalData, options);

        var scoreCtx = document.getElementById("score").getContext("2d");
        var scoreLineChart = new Chart(scoreCtx).Line(scoreData, options);

        var firstScoreCtx = document.getElementById("first_point").getContext("2d");
        var firstScoreLineChart = new Chart(firstScoreCtx).Line(firstScoreData, options);

        setTimeout("reloadRankingChart()",60000);
    });
}
