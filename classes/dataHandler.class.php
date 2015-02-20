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


    public function tabName($tableName) {
        $tableName = strtolower(str_replace(" ","_",$tableName));
        $tableName = preg_replace('/[^a-z0-9_-]/','',$tableName);
        return $tableName;
    }

    public function save($tableName) {
        $tableName = $this->tabName($tableName);
        if (empty($tableName)) return false;
        if (file_put_contents(DATADIR.$tableName.".dat",implode(DELIMITER,array($this->data,$this->header,$this->footer)))) {
            if ($this->tableName != $tableName) {  // Name changed, delete old table
                if ($this->delete()) {
                    $this->tableName = $tableName;
                } else {
                    return false;
                }
            }
            $this->hasFile = true;
        } else {
            return false;
        }

        return true;
    }

    public function delete() {
        if (!$this->hasFile) return true;
        if (unlink(DATADIR.$this->tableName.".dat")) {
            $this->hasFile = false;
            return true;
        }
        return false;
    }
}
