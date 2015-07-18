<?php
/**
 * Created by PhpStorm.
 * User: suraj.jha
 * Date: 17/7/15
 * Time: 12:57 PM
 */
require_once 'databaseConnection.php';
require_once 'BaseLoggerInterface.php';

class ExecutionTimeLogger implements BaseLoggerInterface
{

    public function __construct(){}

    /**
     * @return mysqli
     * creates a database connection
     */
    protected function getDatabaseObject()
    {
        $db = new DatabaseConnection();
        return $db->getConnection();
    }

    /**
     * @param $data - contains function name and its execution time
     * @throws Exception
     * insert the execution time to database else throw exception
     * return bool
     */
    public function logToDatabase($data){
        $db = $this->getDatabaseObject();
        $query = "insert into Execution_Time_Log (function_name, time_taken) VALUES ('{$data['function_name']}', '{$data['time_taken']}')";
        $logged = $db->query($query);
        if($logged)return true;
        else throw new Exception("Insertion failed with the error - " . mysqli_error($db));
    }

    /**
     * @param $startTime
     * @param $endTime
     * @return bool logs the execution time for a function
     */
    public function logExecutionTime($functionName, $startTime, $endTime){
        $time_taken = $this->computeExecutionTime($startTime, $endTime);
        $data = ["function_name" => $functionName, "time_taken" => $time_taken];
        if($this->logToDatabase($data)){
            return true;
        }
        return false;
    }

    /**
     * @param $startTime
     * @param $endTime
     * @return mixed returns the computed execution time
     */
    public function computeExecutionTime($startTime, $endTime){
        return $endTime - $startTime;
    }
}