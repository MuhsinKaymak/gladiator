<?php 
class Provider{
    private $myServer = "MUHSIN-PC";
    private $myUser = "";
    private $myPass = "";
    private $myDB = "gladiator_db";

    private $conn;
    
    function __construct() {
        
    }
    
    private function connectToDB()
    {
        $connectionInfo = array("Database"=>"gladiator_db");
        //connection to the database
        $this->conn = sqlsrv_connect($this->myServer, $connectionInfo)
          or die("Couldn't connect to SQL Server on $this->myServer"); 
    }


    public function checkLogin($username, $password)
    {
        $this->connectToDB();
        
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
        
        $this->connectToDB();
        
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
}
?>