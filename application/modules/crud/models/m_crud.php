<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 class M_crud extends CI_Model {
     
    function get_data($select, $table, $where=null){       
        $where_sql = $where ? $where : null;
        $query = 'SELECT '.$select.' FROM '.$table.' '.$where_sql;
        return $this->db->query($query);
    }

    function save_data($data, $table){
        $return = FALSE;
        if ($this->db->insert($table, $data)){
            $return = TRUE;
        }

        return $return;
    }

    function update_data($id, $field, $data, $table){
        $return = FALSE;
        $this->db->where($field, $id);
        if ($this->db->update($table, $data)){
            $return = TRUE;
        }

        return $return;
    }

    function delete_data($id, $field, $table){
        $return = FALSE;
        $this->db->where($field, $id);
        if ($this->db->delete($table)){
            $return = TRUE;
        }

        return $return;
    }
 }
 ?>