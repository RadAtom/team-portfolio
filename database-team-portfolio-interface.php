<?php
/*
This file is responsible for handling all of the following:
1. wordpress hooks for custom database
2. initizlizer functions for custom database
3. a class to handle any database interaction
*/
class DatabaseInterface {
    private var $tableName;
    private var $datapoints;
    private var $ID;

    public function __construct()
    {
        $this->tableName = "";
        $this->datapoints = array();
        $this->ID = 0;
    }

    public function setTableName($newTableName)
    {
        $this->tableName = $newTableName;
    }

    public function setIdKey($newId)
    {
        $this->ID = 0;
    }

    public function syncKeyValuefromDatabase($newTableName = NULL)
    {
        if(!is_null($newTableName)){
            $this->setTableName($newTableName);
        }
        if(is_null($this->tableName))
        {
            return false;
        }else{
            //ok now we are actually doing stuff
            global $wpdb;
            $prefixTableName = $wpdb->prefix . $this->tableName;
            foreach ( $wpdb->get_col( "DESC " . $prefixTableName, 0 ) as $column_name ) {
                $this->setKeyValue($column_name, null);
            }
        }
    }
    public function setKeyValue($key, $value)
    {
        if(is_null($key)){
            return false;
        }else if(is_null($value)){
            return false;
        }else{
            $this->datapoints[$key] = $value;
        }
        return false;
    }

    public function readFromDatabase()
    {
    	
    }
    
    public function insetIntoDatabase()
    {

    }

    public function updateToDatabase()
    {

    }

    public function deleteFromDatabase()
    {

    }
?>