<?php 
require_once('Gladiator.php');
class Provider{
    private $myServer = "MUHSIN-PC";
    private $myUser = "";
    private $myPass = "";
    private $myDB = "gladiator_db";

    private $conn;
    
    function __construct() {
        $connectionInfo = array("Database"=>"gladiator_db");
        //connection to the database
        $this->conn = sqlsrv_connect($this->myServer, $connectionInfo)
          or die("Couldn't connect to SQL Server on $this->myServer"); 
    }

    public function checkLogin($username, $password)
    {
        
        //declare the SQL statement that will query the database
        $query = "SELECT [playerID] FROM [dbo].[players] WHERE [username] = '".$username."' AND [password] = '".$password."'";

        //execute the SQL query and return records
        $result = sqlsrv_query($this->conn, $query);

        //$numRows = sqlsrv_num_rows($result); 
        //echo "<h1>" . $numRows . " Row" . ($numRows == 1 ? "" : "s") . " Returned </h1>"; 
        $row = sqlsrv_fetch_array($result);
        if($row)
        {
            $id = $row["playerID"];
            
            //close the connection
            sqlsrv_close($this->conn);
            
            return $id;
        }
        else
        {
            //close the connection
            sqlsrv_close($this->conn);
            return -1;
        }
        
    }
    
    public function getStats($playerID)
    {
        $stats;
        
        //declare the SQL statement that will query the database
        $query = "SELECT [username] FROM [dbo].[players] WHERE [playerID] = '".$playerID."'";

        //execute the SQL query and return records
        $result = sqlsrv_query($this->conn, $query);

        //$numRows = sqlsrv_num_rows($result); 
        //echo "<h1>" . $numRows . " Row" . ($numRows == 1 ? "" : "s") . " Returned </h1>"; 
        $row = sqlsrv_fetch_array($result);
        if($row)
        {
            $stats['username'] = $row["username"];
        }
        
        //declare the SQL statement that will query the database
        $query = "SELECT * FROM [dbo].[playerStats] WHERE [playerID] = '".$playerID."'";

        //execute the SQL query and return records
        $result = sqlsrv_query($this->conn, $query);

        //$numRows = sqlsrv_num_rows($result); 
        //echo "<h1>" . $numRows . " Row" . ($numRows == 1 ? "" : "s") . " Returned </h1>"; 
        $row = sqlsrv_fetch_array($result);
        if($row)
        {
            $stats['health'] = $row["health"];
            $stats['attack'] = $row["attack"];
            $stats['defence'] = $row["defence"];
            $stats['gold'] = $row["gold"];
            $stats['energy'] = $row["energy"];
            $stats['levelID'] = $row["levelID"];
            $stats['xp'] = $row["xp"];
        }
        
        sqlsrv_close($this->conn);
        return $stats;
    }

    public function getOpponents($level, $id)
    {
        $opponents = array();
        //declare the SQL statement that will query the database
        $query = "SELECT [players].[playerID], [username], [levelID], "
                . "[health]+(SELECT [healthBonus] FROM [gladiator_db].[dbo].[level] WHERE [levelID] = [playerStats].[levelID]) AS health,"
                . "[attack]+(SELECT [attackBonus] FROM [gladiator_db].[dbo].[level] WHERE [levelID] = [playerStats].[levelID]) AS attack,"
                . "[defence]+(SELECT [defenceBonus] FROM [gladiator_db].[dbo].[level] WHERE [levelID] = [playerStats].[levelID]) AS defence "
                . "FROM [gladiator_db].[dbo].[players] "
                . "INNER JOIN [gladiator_db].[dbo].[playerStats] "
                . "ON [players].[playerID]=[playerStats].[playerID] "
                . "AND [levelID] > (".$level."-5) "
                . "AND [levelID] < (".$level."+5) "
                . "AND [health] > 0 "
                . "AND [players].[playerID] != ".$id." "
                . "ORDER BY [players].[playerID];";

        //execute the SQL query and return records
        $result = sqlsrv_query($this->conn, $query);

        //$numRows = sqlsrv_num_rows($result); 
        //echo "<h1>" . $numRows . " Row" . ($numRows == 1 ? "" : "s") . " Returned </h1>"; 
        $i = 0;
        while($row = sqlsrv_fetch_object($result))
        {
            $g = new Gladiator($row->playerID, $row->username, $row->health, $row->attack, $row->defence, $row->levelID);
            $opponents[$i] = $g;
            $i++;
        }
        
        return $opponents;
    }
    
    public function saveBattleResults($winnerID,$loserID,$XPReward,$goldReward) 
    {
        //put loser in hospital and set life to zero
        $query = "UPDATE [dbo].[playerStats] SET [health] = 0 WHERE [playerID] = ".$loserID.";";
        sqlsrv_query($this->conn, $query);
        
        $date = date('Y-m-d H:i:s', strtotime('+30 seconds'));
        $query = "INSERT INTO [dbo].[hospital] ([playerID],[releaseTime]) VALUES (".$loserID.",'".$date."');";
        sqlsrv_query($this->conn, $query);
        
        //giv reward to winner
        $query = "UPDATE [dbo].[playerStats] SET [gold] = [gold]+".$goldReward.", [xp] = [xp]+".$XPReward." WHERE [playerID] = ".$winnerID.";";
        sqlsrv_query($this->conn, $query);
    }
    
    public function getSecondsToRelease($playerID)
    {
        $currentDate = date('Y-m-d H:i:s');
        $releaseDate;
        
        $query = "SELECT [releaseTime] FROM [dbo].[hospital] WHERE [playerID] = '".$playerID."'";

        $result = sqlsrv_query($this->conn, $query);
        
        $row = sqlsrv_fetch_object($result);
        if($row)
        {
            $releaseDate = $row->releaseTime;
        }
        
        if($releaseDate == NULL)
        {
            return 99999;
        }
        else if($currentDate > $releaseDate->format('Y-m-d H:i:s'))
        {
            return 0;
        }
        
        /*$date1 = new DateTime($currentDate);
        $date2 = new DateTime($releaseDate->format('Y-m-d H:i:s'));
        
        $interval = 22222;
        $interval = $date1->diff($date2);
        return $interval->s;
        */
        $datetime1 = date_create("".$currentDate);
        $datetime2 = date_create("".$releaseDate->format('Y-m-d H:i:s'));

        $interval = date_diff($datetime1, $datetime2);

        $hours = $interval->format("%h");
        $mins = $interval->format("%i") + ($hours*60);
        $secs = $interval->format("%s") + ($mins*60);
        return $secs;
    }
    
    public function refillHealth($playerID)
    {
        $query = "DELETE FROM [dbo].[hospital] WHERE [playerID] = ".$playerID.";";
        sqlsrv_query($this->conn, $query);
        
        $query = "SELECT [health] FROM [dbo].[playerStats] WHERE [playerID] = '".$playerID."'";

        $result = sqlsrv_query($this->conn, $query);
        
        $row = sqlsrv_fetch_object($result);
        if($row)
        {
            return $row->health;
        }
    }
    
    public function register($username,$pass, $mail)
    {
        try{
            $query = "INSERT INTO [dbo].[players] ([username],[password],[email]) VALUES ('".$username."','".$pass."','".$mail."');";
            sqlsrv_query($this->conn, $query);
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
}
?>