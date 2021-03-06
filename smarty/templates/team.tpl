<table style="width:100%">
    <tr>
        <td style="width:25%;vertical-align: top;">
            <center>
                <img id="team_logo" style="margin-top:10px">
            </center>
        </td>
        <td style="width: 40%;vertical-align: top;">
            <table id="team_tops_table" style="font-size: 12px;">
                <thead>
                    <td><h2><text id="teamname"></text></h2></td>
                </thead>
                <tr>
                    <td>Toppscorer:</td>
                    <td><text id="team_topscorer"></text></td>
                </tr>
                <tr>
                    <td>Flest minutter:</td>
                    <td><text id="team_minutes"></text></td>
                </tr>
                <tr>
                    <td>Flest gule kort:</td>
                    <td><text id="team_yellow"></text></td>
                </tr>
                <tr>
                    <td>Flest røde kort:</td>
                    <td><text id="team_red"></text></td>
                </tr>
                <tr>
                    <td>Beste seiersprosent: </td>
                    <td><text id="team_winpercentage"></text></td>
                </tr>
                <tr>
                    <td>Spillere brukt:</td>
                    <td><text id="team_players_used"></text></td>
                </tr>
                <tr>
                    <td>Mål scoret:</td>
                    <td><text id="team_scored"></text></td>
                </tr>
                <tr>
                    <td>Mål sluppet inn:</td>
                    <td><text id="team_conceded"></td>
                </tr>
                <tr>
                    <td>Clean sheets:</td>
                    <td><text id="team_cleansheets"></text></td>
                </tr>
                <tr>
                    <td>Gule kort:</td>
                    <td><text id="team_yellowcard"></text></td>
                </tr>
                <tr>
                    <td>Røde kort:</td>
                    <td><text id="team_redcard"></text></td>
                </tr>
                <tr>
                    <td>Over 2.5 mål:</td>
                    <td><text id="team_over3"></text></td>
                </tr>
                <tr>
                    <td>Over 3.5 mål:</td>
                    <td><text id="team_over4"></text></td>
                </tr>
                <tr>
                    <td>Hjemmebane:</td>
                    <td><text id="team_home"></text></td>
                </tr>
                <tr>
                    <td>Bortebane:</td>
                    <td><text id="team_away"></text></td>
                </tr>
                <tr>
                    <td>Tilskuersnitt:</td>
                    <td><text id="team_attendance_avg"></text></td>
                </tr>
                <tr>
                    <td>Tilskuerrekord:</td>
                    <td><text id="team_attendance_max"></text></td>
                </tr>
                <tr>
                    <td>Spiller på:</td>
                    <td><text id="team_surface"></text></td>
                </tr>
            </table>
        </td>
        <td style="width: 35%;">
            <div id="team_table">
                <table id="team_tables">
                    <tr>
                        <td>
                            <table id="team_leaguetable" class="tablesorter playerinfo"> </table>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
</table>

<table>
    <tr>
        <td>
            <table id="team_latestmatches" class="tablesorter matchinfo"></table>
            <table id="team_nextmatches" class="tablesorter matchinfo"></table>
        </td>
    </tr>
</table>


<table id="teamplayerinfo" class="tablesorter playerinfo"></table>

<div id="pies">
    <text style="margin-left: 250px; font-size: 10pt; font-weight: bold">Mål for</text>
    <text style="margin-left: 250px; font-size: 10pt; font-weight: bold">Mål mot</text>
    <br/>
    <br/>
    <div id="scoringminute" style="width: 410px; height: 150px;float:left;z-index: 1; "></div>
    <div id="concededminute" style="width: 410px; height: 150px;float:left;z-index: 1; "></div>
    <div id="infoWindow" class="infoWindow">
        <table id="infoTable" class="infoTable"></table>
    </div>
    <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
</div>

<ul id="rankingteam" class="ranking" style="margin-left:15px;"></ul>
<table id="team_allmatches" class="tablesorter playerinfo"></table>