<?php /* Smarty version Smarty-3.1.12, created on 2013-06-03 07:39:20
         compiled from "smarty\templates\infoindex.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2783150ad1bad17d3d9-99298101%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '279da6dfa57648cbbd671987e62eec3cbf48ae9c' => 
    array (
      0 => 'smarty\\templates\\infoindex.tpl',
      1 => 1370245159,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2783150ad1bad17d3d9-99298101',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_50ad1bad24f056_48494864',
  'variables' => 
  array (
    'player_id' => 0,
    'team_id' => 0,
    'season' => 0,
    'league_id' => 0,
    'matchid' => 0,
    'refereeid' => 0,
    'page' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50ad1bad24f056_48494864')) {function content_50ad1bad24f056_48494864($_smarty_tpl) {?><html>
    <head>     
        <title>FotballSentralen.com</title>
        <script type="text/javascript">
           
            
            !function(d,s,id){ var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){ js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
            
            (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/nb_NO/all.js#xfbml=1";
        fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
        
            $(document).ready(function() {

               
                var player_id = '<?php echo $_smarty_tpl->tpl_vars['player_id']->value;?>
';
                var team_id = '<?php echo $_smarty_tpl->tpl_vars['team_id']->value;?>
';
                var season = '<?php echo $_smarty_tpl->tpl_vars['season']->value;?>
';
                var league_id = '<?php echo $_smarty_tpl->tpl_vars['league_id']->value;?>
';
                var matchid = '<?php echo $_smarty_tpl->tpl_vars['matchid']->value;?>
';
                var refereeid = '<?php echo $_smarty_tpl->tpl_vars['refereeid']->value;?>
';
                var page = '<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
';
                
                if(season != '') {
                    setSeason(season);
                }
                if(player_id != ''){
                    getPlayer(player_id);
                }
                else if(team_id != '') {
                    getTeam(0,team_id);
                }
                else if(league_id != '' && page == '') {
                    getTeam(league_id,0);
                }
                else if(page == 'populare'){
                    getPopulare();
                }
                else if(page == 'suspension'){
                    getSuspensionList(league_id);
                }
                else if(page == 'preview'){
                    if(matchid != ''){
                        getPreview(matchid);
                    }else{
                        getPreviewMatches();
                    }
                }
                else if(page == 'referee'){
                    if(refereeid == ''){
                        getReferee();
                    }else{
                        getRefereeId(refereeid);
                    }
                }
                else{
                    getTeam(0,0);
                }

                if(league_id == '' && team_id == '' && player_id == '' && page == ''){
                    $('#welcometext').show();
                }
                
                //Hover arrows functions
                
                $('#previous').hover(function () {
                    this.src = 'images/arrow_prev_shadow.png';
                }, function () {
                    this.src = 'images/arrow_prev.png';
                });$('#next').hover(function () {
                    this.src = 'images/arrow_next_shadow.png';
                }, function () {
                    this.src = 'images/arrow_next.png';
                });
                
                
            });
            
        </script> 
        
    </head>
    <body>
        <div id="fb-root"></div>
        <div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
        <div id="loader" class="loader"></div>
        <?php if ($_smarty_tpl->tpl_vars['page']->value==''){?>
        <input id="next" type="image" src="images/arrow_next.png" style="position:absolute;bottom:35%;right:55px" title="Neste sesong" onclick="nextSeason()">
        <input id="previous" type="image" src="images/arrow_prev.png" style="position:absolute;bottom:35%;left:55px;" title="Forrige sesong" onclick="previousSeason()">
        <?php }?>
        <div class="indexbody">
            
            <div id="welcometext" style="font-size: 10pt; margin-left:16px;margin-right:20px; background-color: #8dbdd8 ">
                <b>Velkommen til FotballSentralen.com!</b>
                <br/>
                <br/>
                Denne nystartede siden samler offisielle kampfakta og resultater fra fotball.no, og sorterer dette slik at du 
                enkelt kan bla deg gjennom fotball-Norge! Kort sagt er dette en oversikt over spilleminutter, bytter, mål og kort for 
                ALLE spillere fra 2.divisjon og opp. Per dags dato ligger det statistikker fra 2011 (Tippeligaen og Adeccoligaen) 
                samt alle 2.divisjons-avdelingene fra 2012-sesongen.
                <br/>
                <br/>
                Siden er stadig under utvikling, og har du tips eller innspill tas de gjerne imot <a href="mailto:kontakt@fotballsentralen.com">her</a>.
                <br/>
                <br/>
                </div>
            
            <div id="eventoverview">
                <?php echo $_smarty_tpl->getSubTemplate ("events.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

            </div>
            
            <div id="team">
                <?php echo $_smarty_tpl->getSubTemplate ("team.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

            </div>
            <div id="player">
                <?php echo $_smarty_tpl->getSubTemplate ("player.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

            </div>
            <div id="events">
                <center> 
                    <div id="radio">
                        <input id="teamradio" type="radio" value="team" name="type" onclick="getEventsTotalTeamSelected()"></input>
                        <label for="teamradio"><text style="font-size:10pt">Lag</text></label>
                        <input id="playerradio" type="radio" value="player" name="type" onclick="getEventsTotalSelected()"></input>
                        <label for="playerradio"><text style="font-size:10pt">Spillere</text></label>
                    </div>
                    <div style="text-align: -moz-center">
                        <table id="allEvents" class="tablesorter" style="width:auto;table-layout: fixed;"></table>
                    </div>
                </center>
            </div>
            <div id="playerminutes">
                <center> 
                    <div style="text-align: -moz-center">
                        <table id="playerminutes_table" class="tablesorter" style="width:auto;table-layout: fixed;"></table>
                    </div>
                </center>
            </div>
            <div id="populare" align="center">
                <table id="trending" class="tablesorter playerinfo" style="float:left; "></table>
                <table id="popularePlayers" class="tablesorter playerinfo" style="float:left;"></table>
                <table id="populareTeams" class="tablesorter playerinfo" style="float:left; "></table>
                </table>
                <br/>
            </div>
                            
            <div id="preview">
                <?php echo $_smarty_tpl->getSubTemplate ("preview.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

            </div>
            
            <div id="referee">
                <table id="referee_table" class="tablesorter playerinfo"></table>
                <table id="referee_table_specific" class="tablesorter playerinfo"></table>
            </div>

            <div id="suspensionList">
                <text id="suspensionText" style="margin-left:20px"></text>
                <br/>
                <select id="suspensionSelect" style="margin: 20px" onchange="selectSuspendedLeague()">
                    <option value="134365">Tippeligaen</option>
                    <option value="134367">Adeccoligaen</option>
                    <option value="134371">2.divisjon avd 1</option>
                    <option value="134372">2.divisjon avd 2</option>
                    <option value="134373">2.divisjon avd 3</option>
                    <option value="134374">2.divisjon avd 4</option>
                </select>
                <br/>
                <table id="suspensionTable" class="tablesorter" style="float: none; width:auto;"></table>
                <br/>
                <br/>
                <table id="suspensionTableDanger" class="tablesorter" style="float: none; width:auto;"></table>
                
            </div>
            <text id="lastupdate" style="font-size: 7pt;margin-left: 15px;" >Sist oppdatert: </text>
            <br/>
            <br/>
            <div style="margin-left:15px" id="social">
                <div class="fb-like" data-href="http://www.facebook.com/fotballsentral1" data-send="false" data-width="400" data-show-faces="true"></div>
                <br/>
                <a href="https://twitter.com/share" class="twitter-share-button" data-lang="en">Tweet</a>
            </div>
            <br/>
            <br/>
        </div>
    </body>
</html><?php }} ?>