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

    public function __construct($newTableName)
    {
        $this->tableName = $newTableName;
        $this->datapoints = array();
        $this->ID = 0;
        $this->syncKeyValuefromDatabase();
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
        return true;
    }

    public function readFromDatabase()
    {
        global $wpdb;
        $mylink = $wpdb->get_row($wpdb->prepare( "SELECT * FROM $this->tableName WHERE post_id = %d",$this->ID));

    }
    
    public function readAllFromDatabase()
    {
        global $wpdb;
        $myrows = $wpdb->get_results( "SELECT * FROM mytable" );
        $wpdb->prepare( 
        "DELETE FROM $wpdb->postmeta WHERE post_id = %d",$this->ID)
        $fivesdrafts = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $this->tableName"));

        foreach ( $fivesdrafts as $fivesdraft ) 
        {
            echo $fivesdraft->post_title;
        }
    }
    

    public function insetIntoDatabase()
    {
        global $wpdb;
        $wpdb->insert( $this->tableName, $data, $format );
        $wpdb->insert( 
            'table', 
            array( 
                'column1' => 'value1', 
                'column2' => 123 
            ), 
            array( 
                '%s', 
                '%d' 
            ) 
        );
        $wpdb->insert_id
    }

    public function updateToDatabase()
    {
        global $wpdb;
        $wpdb->update( $table, $data, $where, $format = null, $where_format = null );
        $wpdb->update( 
            'table', 
            array( 
                'column1' => 'value1',  // string
                'column2' => 'value2'   // integer (number) 
            ), 
            array( 'ID' => 1 ), 
            array( 
                '%s',   // value1
                '%d'    // value2
            ), 
            array( '%d' ) 
        );
    }

    public function deleteFromDatabase()
    {
        global $wpdb;
        $myrows = $wpdb->get_results( "SELECT * FROM mytable" );
        $wpdb->prepare( 
        "DELETE FROM $wpdb->postmeta WHERE post_id = %d",$this->ID)
    }
?>