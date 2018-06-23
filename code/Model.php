<?php

class Model {
    
    /**
     * @var type 
     */
    private $dbHandler;

    /**
     * @param mysqli $dbHandler
     */
    public function __construct(mysqli $dbHandler)
    {
        $this->dbHandler = $dbHandler;
    }
    
    /**
     * @return array
     */
    public function getAll():array
    {
        $query = $this->dbHandler->query('SELECT `item`, `priority`, `is_completed` FROM `todo` ORDER BY priority;');
        
        $result = [];
        while ($row = $query->fetch_object()) {
            $result[] = $row;
        }
        
        return $result;
    }
    
    /**
     * @param array $data
     * 
     * @return bool
     */
    public function addItem(array $data):bool
    {
        $this->dbHandler->begin_transaction();
        $sql = "UPDATE todo SET priority = priority + 1 WHERE priority >= ?";
        $query = $this->dbHandler->prepare($sql);
        $query->bind_param('d', $data['priority']);
        if ($query->execute()) {
            $sql = "INSERT INTO todo(item, priority, is_completed) VALUES (?, ?, 0);";
            $query = $this->dbHandler->prepare($sql);
            $query->bind_param('sd', $data['item'], $data['priority']);            
            $this->dbHandler->commit();
            
            return $query->execute();
        }
        
        return false;
    }
    
    /**
     * @param int $priority
     */
    public function setCompleted(int $priority)
    {
        $sql = "UPDATE todo SET is_completed = 1 WHERE priority = ?";
        $query = $this->dbHandler->prepare($sql);
        $query->bind_param('d', $priority);
        return $query->execute();
    }
}
