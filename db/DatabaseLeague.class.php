<?php

include "dbConnection.php";

class DatabaseLeague {
    
    public function getLeagueInfo($leagueid,$teamid,$season)
    {
        DatabaseUtils::setLeagueHit($leagueid,$season);
        if($season == 0){
            $season = Constant::ALL_STRING;
        }
       
        $leagueHome = DatabaseLeague::getLeagueTableHome($leagueid, $season, $teamid);
        $leagueAway =  DatabaseLeague::getLeagueTableAway($leagueid, $season, $teamid);
        
        $events = array (
            'lastupdate' => DatabaseUtils::getLastUpdate($leagueid,$season),
            'yellow' => DatabaseUtils::getEventInfoTotalJSON(2,10,$season,$leagueid),
            'yellow_red' => DatabaseUtils::getEventInfoTotalJSON(1,10,$season,$leagueid),
            'red' => DatabaseUtils::getEventInfoTotalJSON(3,10,$season,$leagueid),
            'goal' => DatabaseUtils::getEventInfoTotalJSON(4,10,$season,$leagueid),
            'subin' => DatabaseUtils::getEventInfoTotalJSON(6,10,$season,$leagueid),
            'subout' => DatabaseUtils::getEventInfoTotalJSON(7,10,$season,$leagueid),
            'penalty' => DatabaseUtils::getEventInfoTotalJSON(8,10,$season,$leagueid),
            'owngoal' => DatabaseUtils::getEventInfoTotalJSON(9,10,$season,$leagueid),
            'minutes' => DatabaseUtils::getTotalPlayerminutes($season,10,$leagueid,$teamid),
            'topscorer' => DatabaseUtils::getEventInfoTotalJSON('4,8',10,$season,$leagueid),
            'topscorercount' => DatabaseTeam::getTopscorerCount($teamid,$leagueid,$season),
            'hometeam' => array_slice($leagueHome,0,1),
            'awayteam' => array_slice($leagueAway,0,1),
            'leaguetable' => DatabaseLeague::getLeagueTable($season, $leagueid, $teamid),
            'leaguetablehome' => $leagueHome,
            'leaguetableaway' => $leagueAway
         );
        return $events;
    }
    
    public function getLeagues()
    {
        $q = "SELECT * FROM leaguetable ORDER by leaguename ASC";
        $data = array();
        $result = mysql_query($q);
        $data[] = 'Alle ligaer';
        while($row = mysql_fetch_array($result))
        {
            $data[$row['leagueid']] = $row['leaguename'];
        }
        return $data;
    }
    
    public function getTeamsJSON($leagueId, $season)
    {
        if($season == 0){
            $season = Constant::ALL_STRING;
        }
        $q = "SELECT t.*,l.lastupdate FROM teamtable t 
            JOIN matchtable m ON m.hometeamid = t.teamid
            JOIN leaguetable l ON l.leagueid = m.leagueid
            WHERE l.java_variable = {$leagueId} and l.year IN ( {$season} )
            GROUP BY m.`hometeamid`
            ORDER BY t.teamname ASC";
        $data = array();
        $result = mysql_query($q);
        while($row = mysql_fetch_array($result))
        {
            $data[] = array(
                'teamid' => $row['teamid'],
                'teamname' => $row['teamname']
            );
        }
        return $data;
    }
    
    public function getLeagueTable($season, $leagueid, $teamid)
    {
        $orderby = 'points';
        $index = $orderby;
        $limit = 20;
        
        $teamids = DatabaseLeague::getCustomLeagueTeams($leagueid);
        if(!empty($teamids)){
            $teamid = implode(" , ", $teamids);
            $leagueid = 0;
        }
        
        if($leagueid == 0){
           $leagueid = '1,2,3,4,5,6';
           //quickfix
           $index = 'pointavg';
           $orderby = 'pointavg DESC, played ';
        }
        
        $q = "
        SELECT 
          home.teamid,
           home.teamname,
        SUM(home.wins + away.wins) AS wins,
        SUM(home.draws + away.draws) AS draws,
        SUM(home.loss + away.loss) AS loss,
        SUM(home.goals + away.goals) AS goals,
        SUM(home.conceded + away.conceded) AS conceded,
        SUM(home.mf + away.mf) AS mf,
        SUM(home.points + away.points) AS points,
        (SUM(home.wins + away.wins) + SUM(home.draws + away.draws) + SUM(home.loss + away.loss)) AS played,
        ROUND(SUM(home.points + away.points) / (SUM(home.wins + away.wins) + SUM(home.draws + away.draws) + SUM(home.loss + away.loss)),2) as pointavg 
        FROM
        (SELECT 
            m.hometeamid AS teamid,
            t.teamname,
            (
            SUM(IF(m.teamwonid = m.hometeamid, 1, 0)) * 3 + SUM(IF(m.teamwonid = 0, 1, 0))
            ) AS points,
            SUM(m.homescore) AS goals,
            SUM(m.awayscore) AS conceded,
            SUM(IF(m.teamwonid = m.hometeamid, 1, 0)) AS wins,
            SUM(IF(m.teamwonid = 0, 1, 0)) AS draws,
            SUM(IF(m.teamwonid = m.awayteamid, 1, 0)) AS loss,
            (SUM(m.homescore) - SUM(m.awayscore)) AS mf 
        FROM
            matchtable m 
            JOIN teamtable t 
            ON t.teamid = m.hometeamid 
            JOIN leaguetable l 
            ON m.`leagueid` = l.`leagueid` 
        WHERE l.`year` IN ( {$season} )
            AND m.`result` NOT REGEXP '- : -|(Utsatt)' 
            AND l.java_variable IN ( {$leagueid} ) ";
       
            if($teamid != 0){
                $q .= " AND  m.hometeamid IN (".$teamid.")  ";
            }  

            $q .= " GROUP BY m.hometeamid 
        ORDER BY points DESC,
            mf DESC) AS home JOIN 
        (SELECT 
            m.awayteamid AS teamid,
            (
            SUM(IF(m.teamwonid = m.awayteamid, 1, 0)) * 3 + SUM(IF(m.teamwonid = 0, 1, 0))
            ) AS points,
            SUM(m.awayscore) AS goals,
            SUM(m.homescore) AS conceded,
            SUM(IF(m.teamwonid = m.awayteamid, 1, 0)) AS wins,
            SUM(IF(m.teamwonid = 0, 1, 0)) AS draws,
            SUM(IF(m.teamwonid = m.hometeamid, 1, 0)) AS loss,
            (SUM(m.awayscore) - SUM(m.homescore)) AS mf 
        FROM
            matchtable m 
            JOIN teamtable t 
            ON t.teamid = m.awayteamid 
            JOIN leaguetable l 
            ON m.`leagueid` = l.`leagueid` 
        WHERE l.`year` IN ( {$season} ) AND l.`java_variable` IN ( {$leagueid} ) ";
        
        if($teamid != 0){
            $q .= " AND m.awayteamid IN (".$teamid.") ";
        }
        
        $q .= " AND m.`result` NOT REGEXP '- : -|(Utsatt)' 
        GROUP BY m.awayteamid 
        ORDER BY points DESC,
            mf DESC) away ON home.teamid = away.teamid GROUP BY teamid ORDER BY $orderby DESC, mf DESC, goals DESC LIMIT $limit";
        $data = array();
        $result = mysql_query($q);
        while($row = mysql_fetch_array($result))
        {
            $data[] = array(
                'teamid' => $row['teamid'],
                'teamname' => $row['teamname'],
                'wins' => $row['wins'],
                'draws' => $row['draws'],
                'loss' => $row['loss'],
                'goals' => $row['goals'],
                'conceded' => $row['conceded'],
                'mf' => $row['mf'],
                'points' => $row[$index],
                'played' => $row['played']
            );
        }
        return $data;
    }
    
    public function getLeagueTableHome($leagueid,$season,$teamid)
    {
        return DatabaseLeague::getBestTeam('hometeam',$leagueid,$season,$teamid,20);
    }
    public function getLeagueTableAway($leagueid,$season,$teamid)
    {
        return DatabaseLeague::getBestTeam('awayteam',$leagueid,$season,$teamid,20);
    }  
    
    public function getBestTeam($team,$leagueid,$season,$teamid = 0, $limit = 1)
    {
        if($team == 'hometeam'){
            $team = 'm.hometeamid';
            $opposite = 'm.awayteamid';
            $scored = 'm.homescore';
            $conceded = 'm.awayscore';
        }
        else if($team == 'awayteam')
        {
            $team = 'm.awayteamid';
            $opposite = 'm.hometeamid';
            $scored = 'm.awayscore';
            $conceded = 'm.homescore';
        }
        else{
            echo $team . ' not supported ';
            return;
        }
        
        $teamids = DatabaseLeague::getCustomLeagueTeams($leagueid);
        if(!empty($teamids)){
            $teamid = implode(" , ", $teamids);
            $leagueid = 0;
        }
        
        $orderby = 'points';
        $index = $orderby;
        if($leagueid == 0 || $leagueid == '3,4,5,6'){
            $orderby = 'pointavg DESC, played';
            $index = 'pointavg';
        }
        
        $q = "SELECT 
            tabell.*,
            tabell.wins + tabell.draws + tabell.loss AS played ,
            ROUND((points/(tabell.wins + tabell.draws + tabell.loss)),2) AS pointavg
            FROM(SELECT t.`teamname`,{$team} as teamid, " .
        "(SUM(IF(m.teamwonid = {$team}, 1,0)) * 3 + SUM(IF(m.teamwonid = 0, 1,0))) AS points,  " .
        "SUM({$scored}) AS goals,  " .
        "SUM({$conceded}) AS conceded, " .
        "SUM(IF(m.teamwonid = {$team}, 1,0)) AS wins, " .
        "SUM(IF(m.teamwonid = 0, 1,0)) AS draws, " .
        "SUM(IF(m.teamwonid = {$opposite}, 1,0)) AS loss,  " .
        "(SUM({$scored}) - SUM({$conceded})) AS mf ,"  .      
        "(SUM(IF(m.teamwonid = m.awayteamid, 1, 0))+SUM(IF(m.teamwonid = 0, 1, 0))+SUM(IF(m.teamwonid = m.hometeamid, 1, 0))) AS played "    .     
        "FROM matchtable m " .
        "JOIN teamtable t ON t.teamid = {$team} " .
        "JOIN leaguetable l ON m.`leagueid` = l.`leagueid`  " .
        "WHERE l.`year` IN ( {$season} ) " .
        ($leagueid == 0 ? ' ' : ' AND l.java_variable IN ('.$leagueid.') ') .
        ($teamid == 0 ? ' ' : ' AND t.teamid IN ('.$teamid.' ) ') .
        "AND m.`result` NOT REGEXP '- : -|(Utsatt)' " .
        "GROUP BY {$team} " .
        "" .
        ") as tabell 
        ORDER BY $orderby DESC, mf DESC LIMIT {$limit}";
        
        $data = array();   
            
        $result = mysql_query($q);
        while($row = mysql_fetch_array($result))
        {
            $data[] = array(
                'points' => $row[$index],
                'teamid' => $row['teamid'],
                'teamname' => $row['teamname'],
                'goals'=> $row['goals'],
                'conceded' => $row['conceded'],
                'mf' => $row['mf'],
                'wins' => $row['wins'],
                'draws' => $row['draws'],
                'loss' => $row['loss'],
                'played' => $row['played']
           );
        }
        return $data;
    }
    
    public function getHomestats($teamid, $season)
    {
        return DatabaseLeague::getBestTeam('hometeam',0,$season,$teamid);
    }
    
    public function getAwaystats($teamid, $season)
    {
        return DatabaseLeague::getBestTeam('awayteam',0,$season,$teamid);
    }

    public function getBestHometeam($leagueid,$season,$teamid)
    {
        return DatabaseLeague::getBestTeam('hometeam',$leagueid,$season,$teamid);
    }

    public function getBestAwayteam($leagueid,$season,$teamid)
    {
        return DatabaseLeague::getBestTeam('awayteam',$leagueid,$season,$teamid);
    } 
    
    public function getAvereageEventLeague($eventtype,$leagueid,$year,$groupby)
    {
        $q = "SELECT 
            FORMAT(AVG(grouped.yellow), 2) AS average 
            FROM
            (SELECT 
                COUNT(*) AS yellow 
            FROM
                eventtable e 
                JOIN leaguetable l 
                ON l.`leagueid` = e.`leagueid` 
            WHERE l.`java_variable` IN ($leagueid) 
                AND l.`year` IN ( $year )
                AND e.`eventtype` IN ($eventtype) 
                AND e.`ignore` = 0 
            GROUP BY e.`$groupby`) AS grouped";
        
        $average = 0;
        $result = mysql_query($q);
        while($row = mysql_fetch_array($result))
        {
            $average = $row['average'];
           
        }
        return $average;  
    }
    public function getCustomLeagueTeams($leagueid)
    {
        $q = "SELECT teamid FROM league_to_team where leagueid IN (" . $leagueid. ")";
        $data = array();
        $result = mysql_query($q);
        while($row = mysql_fetch_array($result))
        {
            $data[] = $row['teamid'];
        }
        return $data;
    }
    public function isCustomLeague($leagueid)
    {
        $q = "SELECT teamid FROM league_to_team where leagueid IN ( " .$leagueid. ")";
        $data = array();
        $result = mysql_query($q);
        while($row = mysql_fetch_array($result))
        {
            $data[] = $row['teamid'];
        }
        return !empty($data);
    }
}
