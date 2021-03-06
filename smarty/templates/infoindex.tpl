<html>
    <head>     
        <title>FotballSentralen.com</title>
        <script type="text/javascript">

                var nrOfTicks = 26;
                var startTick = 18;

            !function(d,s,id){ var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){ js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
            
            (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/nb_NO/all.js#xfbml=1";
        fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
        
            $(document).ready(function() {
            
                $(window).on('hashchange', function() {
                   controlHash();
                });
                
                $('#time').html(getMonthYear(startTick) + " - " + getMonthYear(nrOfTicks));
                
                $("#slider-range").slider({
                    range: true,
                    min: 0,
                    max: nrOfTicks,
                    values: [startTick, nrOfTicks],
                    step:1,
                    slide: function(e, ui) {
                        if(allowClicks) {
                            var from = ui.values[0];
                            var to = ui.values[1];
                            $('#time').html(getMonthYear(from) + " - " + getMonthYear(to));
                        }
                    }
                });
                
//                $("#slider-range").mouseup(function () {
//                    if(allowClicks){
//                        getScope($("#slider-range").slider("values", 0),$("#slider-range").slider("values", 1));
//                    }
//                });
                
                controlHash();
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
        
        function submitFeedback(){
            var name = $('#feedback_name').val();
            var mail = $('#feedback_mail').val();
            var msg = $('#feedback_msg').val();
            var page = $('#feedback_page').val();
            var rating = $('input[name=group]:radio:checked').attr('value');
            
            if(name == '' || msg == ''){
                alert('Husk navn og kommentar!');
                return;
            }
            $.ajax({
                type: "POST",
                url: "receiver.php",
                dataType: "json",
                timeout: timeout,
                data: {
                    action: "submitFeedback",
                    name: name,
                    mail: mail,
                    msg: msg,
                    page: page,
                    rating: rating
                },
                error: function () {
                    stopLoad()
                },
                success: function() {
                    alert('Takk for tilbakemeldingen!');
                    closePopup();
                }
            });
        }
        // POPup functions:
        function showPopup(){
            $('#feedback_form').show('fast');
            $('#feedback_name').focus();
            $('#feedback_click').hide();
        }
        function closePopup(){
            $('#feedback_form').hide('fast');
            $('#feedback_click').show();
        }
        function openInfo(){
        
            $('#total_players').html({$status.playercount});
            $('#total_events').html({$status.eventcount});
            $('#total_matches').html({$status.matchcount});
            $('#total_lineups').html({$status.lineupcount});
            $('#total_click').html({$status.clickcount});
            $('#info_form').show('fast');
            $('#info_click').hide();
        }
        function openExtraInfo(){
            $('#extra_form').show('fast');
            $('#extra_click').hide();
        }
        function closeInfo(){
            $('#info_form').hide('fast');
            $('#info_click').show();
        }
        function closeExtraInfo(){
            $('#extra_form').hide('fast');
            $('#extra_click').show();
        }
  
        function controlHash()
        {            
            var paramArray =  window.location.hash.split("/");
            if(paramArray == ''){
                setSeason(2014);
                getTeam(0, 0);
                return;
            }
            
            setSeason(paramArray[1]);
            var type = paramArray[2];
            var id = paramArray[3];
            var specialid = paramArray[4];
            
            setCurrentPage(type,id,specialid);
            
        }
        
        </script> 
        
    </head>
    
    <body>
        <div id="fb-root"></div>
        <div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
        <div id="loader" class="loader"></div>
        {if $page == ''}
        <input id="next" type="image" src="images/arrow_next.png" style="position:absolute;bottom:35%;right:55px" title="Neste sesong" onclick="next()">
        <input id="previous" type="image" src="images/arrow_prev.png" style="position:absolute;bottom:35%;left:55px;" title="Forrige sesong" onclick="previous()">
        {/if}
        <div class="indexbody">
            <div id="info_form" hidden="true" align="center" style="font-size:10pt">
                <div style="width:400px;margin-right:10px;text-align: center">
                    Fotballsentralen samler informasjonen som ligger på fotball.no, og strukturerer denne slik at du skal få best mulig 
                    oversikt over de ulike lagene og divisjonene i Norge.
                    Per dags dato er vi de eneste i Norge har en komplett oversikt over spilte minutter i 2. divisjon siden 2012. 
                    Det finnes flere ulike oversikter som gir deg et unikt bilde over hvordan din klubb eller spiller gjør det i 
                    forhold til resten av fotball-Norge. Du kan også navigere deg tilbake til 2011 med detaljert informasjon for enkeltspillere.
                    Heller ingen andre i Norge har oversikt over suspensjoner i 2. divisjon!
                    <br/>
                    <br/>
                    Fotballsentralen blir oppdatert automatisk 3 timer etter endt kamp i hver divisjon. Hvis det spilles en kamp klokken 14.00 og en kamp klokken 18.00 
                    i samme divisjon, blir alle kampene fra denne divisjonen hentet og lastet opp på nettstedet klokken 21.00.
                    <br/>
                    <br/>
                    Vi har ambisjoner om å være statistikkansvarlig for flere og flere lag i Norge. Lag i 2.divisjon har ikke ressurser til å
                    oppdatere statistikken jevnlig, og vi håper at FotballSentralen kan være med på å automatisere akkurat denne prosessen for lag.
                    Sålangt er det noen lag som benytter seg av dette (bla. <a href="#" onclick="getTeam(0,139);return false">Kvik Halden</a>) men
                    vi oss ønsker flere!
                    <br/>
                    <br/>
                    <b>Live status:</b>
                    <br/>
                    Antall spillere: <b><text id="total_players"></text></b><br/>
                    Antall kamper: <b><text id="total_matches"></text></b><br/>
                    Antall kort, bytter og mål: <b><text id="total_events"></text></b><br/>
                    Antall spilletidoppføringer: <b><text id="total_lineups"></text></b><br/>
                    Antall klikk på siden: <b><text id="total_click"></text></b><br/>
                    <br/>
                    <br/>
                    <a href="mailto:kontakt@fotballsentralen.com">Kontakt</a>
                </div>
                <button id="info_close" onclick="closeInfo();return false;">Lukk</button>
            </div>
            <div id="scope_form" hidden="true" align="center" style="font-size:10pt">
                <div style="width:500px;margin-right:10px;text-align: center">
                    <b>Hvordan Statoskopet fungerer:</b>
                    <br/><br/>
                    Statoskopet er et verktøy hvor du kan spesfisere ting som tidsperiode og liga, for å så hente ut valgfri data
                    fra akkurat denne spesifiseringen. Du kan også lage en offentlig oversikt som alle kan være innom, eller en privat
                    som de kun med link fra deg kan besøke.
              
                    <br/><br/>
                    Det første du kan gjøre, er å velge en spesfikk liga. Deretter kan du velge en tidsperiode du ønsker å 
                    kikke nærmere på. Hvis du for eksempel ønsker å studere høst-sesongen 2012 i 2.divisjon, velger du startdato
                    og sluttdato på slideren i toppen. Helt øverst vil du kunne se hvilken måned og år du studerer akkurat nå. Deretter
                    velger du 2.divisjon i ligavalget.
                    
                    <br/><br/>
                    Når dette er gjort kan du begynne med å velge hvilke data du ønsker å ta med i oversikten. Ønsker du feks å se hvem
                    som gjorde det best poengmessig høstsesongen, velger du graftype tabell, hjemme/borte, om du vil ha poengsnitt eller 
                    totalt poeng, og deretter hvor mange lag som skal være med på tabellen.
                    
                    <br/><br/>
                    Du kan lagre opptil 9 tabeller på hver skjerm. Disse tabellene blir ikke fjernet hvis du velger en ny tidsperiode eller
                    velger en ny liga. Tabellene lastes på nytt med ligavalg og tidsperiode for hvert trykk på "Hent data".
                    
                </div> 
                <button id="scope_close" onclick="closeScopeInfo();return false;">Lukk</button>
            </div>
            <div id="extra_form" hidden="true" align="center" style="font-size:10pt">
                <div style="width:500px;margin-right:10px;text-align: center">
                    Er du en gambler? Eller er du bare nysgjerrig på norsk fotball? Da kan vi hjelpe deg! Vi har i det siste jobbet 
                    med å utvikle en tjeneste som sender ut mail når lagoppstillingene på fotball.no blir tilgjengelig. Dette kommer til
                    å være en betalingstjeneste, der man betaler en viss sum per liga og får tilsendt lagoppstillinger per kamp. I tillegg til
                    begge lagene vil det være utfyllende informasjon om disse spillerene, og om laget mangler noen spillere fra tidligere kamper.
                
                </div>
                <button id="extra_close" onclick="closeExtraInfo();return false;">Lukk</button>
            </div>
            <div id="feedback_form" hidden="true" align="right" style="font-size:9pt">
                <table style="font-size:9pt;">
                    <tr>
                       <td>Navn: <text style="color:red"> *</text></td> 
                       <td>
                           <input type="text" id="feedback_name"></input> 
                       </td>  
                    </tr>
                    <tr>
                        <td>Mail:</td>
                        <td>
                            <input type="text" title="Kun hvis du ønsker svar" id="feedback_mail"></input>  
                        </td>
                    </tr>
                    <tr>
                        <td>Gjelder side:</td>
                            <td>
                                <input type="text" id="feedback_page" disabled="true"><text ></text></input> 
                            </td>
                    </tr>
                    <tr>
                        <td>Kommentar:</td>
                        <td>
                            <textarea id="feedback_msg" style="width:240px;height:100px;resize: none;"></textarea> 
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Rangering:
                        </td>
                        <td>    
                            <input type="radio" name="group" title="Håpløst" value="1" id="feedback_radio_1"></input>
                            <input type="radio" name="group" title="Dårlig" value="2" id="feedback_radio_2"></input>
                            <input type="radio" name="group" title="Middels" value="3" id="feedback_radio_3" checked></input>
                            <input type="radio" name="group" title="Bra" value="4" id="feedback_radio_4"></input>
                            <input type="radio" name="group" title="Strålende" value="5" id="feedback_radio_5"></input>
                        </td>
                    </tr>
                </table>
                <button id="feedback_close" onclick="closePopup();return false;">Lukk</button>
                <button id="feedback_send" onclick="submitFeedback();return false;">Send inn</button>
            </div>
            <div align="right" id="feedback_index" style="margin-right: 10px">
                <a href="#" id="feedback_click" style="font-size: 8pt" title="Hjelp FotballSentralen bli bedre!" onclick="showPopup();return false;">Feedback</a>
                <br/>
                <a href="#" id="info_click" style="font-size: 8pt" onclick="openInfo();return false;">Ny på FotballSentralen?</a>
                <!--
                <br/>
                <a href="#" id="extra_click" style="font-size: 8pt" onclick="openExtraInfo();return false;">Lagoppstillinger Live</a>
                -->
                <a href="#" id="info_scope_click" style="font-size: 8pt" onclick="openScopeInfo();return false;">Hva er dette?</a>
            </div>
            
            
            <div id="eventoverview">
                {include file="events.tpl"}
            </div>
            <div id="team">
                {include file="team.tpl"}
            </div>
            <div id="player">
                {include file="player.tpl"}
            </div>
            <div id="events">
               {include file="allevents.tpl"}
            </div>
            <table id="populare" align="center" width="100%">
                <tr>
                    <td><table id="trending" class="tablesorter playerinfo" style="float:left; "></table></td>
                    <td><table id="popularePlayers" class="tablesorter playerinfo" style="float:left;"></table></td>
                    <td><table id="populareTeams" class="tablesorter playerinfo" style="float:left; "></table></td>
                </tr>
                <br/>
                <br/>
            </table>
            <div id="transfer_div">
                <text id="transfer_text" style="margin-left:20px"></text>
                <table id="transfer_table" align="center" width="100%">
                    <tr>
                        <td><table id="transfer_transfer" class="tablesorter playerinfo" style="float:left; "></table></td>
                    </tr>
                </table>
            </div>
            <div id="preview">
                {include file="preview.tpl"}
            </div>
            
            <div id="scope">
                {include file="scope.tpl"}
            </div>
            
             <div id="futsal_player">
                {include file="futsal/player.tpl"}
            </div>

            <div id="futsal_team">
                {include file="futsal/team.tpl"}
            </div>
            
            <div id="futsal_league">
                {include file="futsal/league.tpl"}
            </div>
            
            <div id="match_main">
                {include file="match.tpl"}
            </div>
            
            <div id="referee">
                <table id="referee_table" class="tablesorter playerinfo"></table>
                <table id="referee_table_specific" class="tablesorter playerinfo"></table>
            </div>
            <center><text id="noData" style="font-size: 9pt">Ingen data denne sesongen!</text></center>

            <div id="suspensionList">
                <label class="selectlabel">
                    <select id="suspensionSelect" style="margin: 20px" onchange="selectSuspendedLeague()">
                        <option value="138918">Tippeligaen</option>
                        <option value="138920">Adeccoligaen</option>
                        <option value="138924">2.divisjon avd 1</option>
                        <option value="138925">2.divisjon avd 2</option>
                        <option value="138926">2.divisjon avd 3</option>
                        <option value="138927">2.divisjon avd 4</option>
                    </select>
                </label>
                <br/>
                <table id="suspensionTable" class="tablesorter playerinfo " style="float: none; width:auto;"></table>
                <br/>
            </div>
            <div id="loaderdiv" style="min-height: 300px"> </div>
            <text id="lastupdate" style="font-size: 7pt;margin-left: 15px;" >Sist oppdatert: </text>
            <br/>
            <br/>
            <div style="margin-left:15px" id="social">
                <div class="fb-like" data-href="http://www.facebook.com/fotballsentral1" data-send="false" data-width="400" data-show-faces="true"></div>
                <br/>
                <a href="https://twitter.com/share" class="twitter-share-button" data-lang="en" data-url="http://www.fotballsentralen.com/">Tweet</a>
            </div>
            <br/>
            <br/>
        </div>
    </body>
</html>