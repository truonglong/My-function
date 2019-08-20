<?php
public function insertList($tblName , $data = [])
    {        
        global $CMS;

        if(!$tblName || !$data) return false;

        $dbFields = $this->get_column_names($tblName);

        $sqlValues = "";
        $sqlFields = "";
        $arrayValue = [];

        foreach ($data as $key => $value) {
            foreach ($value as $k => $v) {
                if (in_array($k, $dbFields)) {
                    $sqlValues .= "'{$v}',";
                }
            }
            array_push($arrayValue, trim('('.$sqlValues, ',').')');

            $sqlValues = "";
        }

        foreach ($data as $key => $value) {
            foreach ($value as $k => $v) {
                if (in_array($k, $dbFields)) {
                    $sqlFields .= " {$k},";
                }
            }break;
        }
        $sqlFields = trim($sqlFields, ',');

        
        $sql = "INSERT INTO ".root_table."{$tblName} ({$sqlFields}) VALUES" . implode(',', $arrayValue);

        exit($sql);
        $result = $this->query($sql);

        //Clear cache
        $CMS->class->cache->mdelete($tblName);

        return $result;
    }