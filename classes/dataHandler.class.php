<?php

class dataHandler {
    protected $hasFile = false;
    protected $tableName = null;
    protected $data = null;
    protected $header = null;
    protected $footer = null;


    public function __construct($table) {
        $this->tableName = $table;
        $filename = $this->tableName.".dat";
        if (file_exists(DATADIR.$filename)) {
            $file = explode(DELIMITER,file_get_contents(DATADIR.$filename));
            $this->data = $file[0];
            if (count($file) > 1) $this->header = $file[1];
            if (count($file) > 2) $this->footer = $file[2];
            $this->hasFile = true;
        }
    }

    // Getters
    public function hasFile() {
        return $this->hasFile;
    }
    public function getData() {
        return $this->data;
    }
    public function hasHeader() {
        return !empty($this->header);
    }
    public function getHeader() {
        return $this->header;
    }
    public function hasFooter() {
        return !empty($this->footer);
    }
    public function getFooter() {
        return $this->footer;
    }
    // Setters
    public function setData($data) {
        $this->data = $data;
    }
    public function setHeader($header) {
        $this->header = $header;
    }
    public function setFooter($footer) {
        $this->footer = $footer;
    }

    public function save($tableName) {
        $tableName = strtolower(str_replace(" ","_",$tableName));
        $tableName = preg_replace('/[^a-z0-9_-]/','',$tableName);

        if (empty($tableName) || !file_put_contents(DATADIR.$tableName.".dat",implode(DELIMITER,array($this->data,$this->header,$this->footer)))) {
            return false;
        }

        if ($this->tableName != $tableName) {  // Name changed, delete old table
            return $this->delete();
        }
        return true;
    }

    public function delete() {
        if ($this->hasFile) {
            if (unlink(DATADIR.$this->tableName.".dat")) {
                return true;
            }
        }
        return false;
    }
}
