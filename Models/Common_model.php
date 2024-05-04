<?php
namespace App\Models;
use CodeIgniter\Model;
class Common_model extends Model {
    public $DBGroup = 'default';
    public $table = "dt_websetting";
    public $primaryKey = 'id';
    public $useAutoIncrement = true;
    public $allowedFields;
    
    public function insertRecords($table, $data) {
        $builder = $this->db->table($table);
        $builder->insert($data);
        return $this->db->insertID();
    }
    
    
    public function insertBatchItems($table, $data) {
        $builder = $this->db->table($table);
        if (!empty($data)) {
            $builder->insertBatch($data);
        }
    }
    
    
    public function getAllData($table = null, $select = null, $where = null, $limit = null, $offset = null, $orderby = null, $key = null, $groupby = null, $jointable = null, $join = null) {
        $builder = $this->db->table($table);
        if (!empty($select)) {
            $builder->select($select);
        }
        if (!empty($where)) {
            $builder->where($where);
        }
        if (!empty($key)) {
            $builder->orderBy($key, $orderby);
        } else if (empty($key) && !empty($orderby)) {
            $builder->orderBy($this->primaryKey, $orderby);
        }
        if (!empty($limit)) {
            if (!empty($offset)) {
                $builder->limit($limit, $offset);
            } else {
                $builder->limit($limit);
            }
        }
        if (!empty($groupby)) {
            $builder->groupBy($groupby);
        }
        if (!empty($jointable) && !empty($join)) {
            $builder->join($jointable, $join);
        }
        $results = $builder->get()->getResultArray();
        return $results;
    }
    
    public function getJoinAllData($table = null, $select = null, $where = null, $limit = null, $offset = null, $orderby = null, $key = null, $groupby = null,$joinArray=null) {
        $builder = $this->db->table($table);
        if (!empty($select)) {
            $builder->select($select);
        }
        if (!empty($where)) {
            $builder->where($where);
        }
        if (!empty($key)) {
            $builder->orderBy($key, $orderby);
        } else if (empty($key) && !empty($orderby)) {
            $builder->orderBy($this->primaryKey, $orderby);
        }
        if (!empty($limit)) {
            if (!empty($offset)) {
                $builder->limit($limit, $offset);
            } else {
                $builder->limit($limit);
            }
        }
        if (!empty($groupby)) {
            $builder->groupBy($groupby);
        }
        if( !empty($joinArray) ){
            foreach ($joinArray as $key => $value) {
                $builder->join( $value['table'], $value['join_on'], $value['join_type'] );
            } 
        }
        $results = $builder->get()->getResultArray();
        return $results;
    }
    
    
    public function countRecords($table = null, $where = null, $selectKey = null) {
        $builder = $this->db->table($table);
        if (!empty($selectKey)) {
            $builder->select($selectKey);
        }
        if (!empty($where)) {
            $builder->where($where);
        }
        $results = $builder->get()->getResultArray();
        return $results;
    }
    
    
    public function getSingle($table = null, $select = null, $where = null, $orderby = null) {
        $builder = $this->db->table($table);
        if (!empty($select)) {
            $builder->select($select);
        }
        if (!empty($where)) {
            $builder->where($where);
        }
        if (!empty($orderby)) {
            $builder->orderBy($this->primaryKey, $orderby);
        }
        return $builder->get()->getRowArray();
    }
    
    
    public function updateRecords($table, $data, $where) {
        $builder = $this->db->table($table);
        $builder->set($data)->where($where)->update();
        return true;
    }
    
    
    public function deleteRecords($table, $where) {
        $builder = $this->db->table($table);
        $builder->where($where);
        $builder->delete();
        return true;
    }
    
    
    public function getfilter($table, $where = false, $limit = false, $start = false, $orderby = false, $orderbykey = false, $getorcount = false, $select = false) {
        $builder = $this->db->table($table);
        if (!empty($select)) {
            $builder->select($select);
        }
        if (!empty($where)) {
            $builder->where($where);
        }
        $builder->limit($limit, $start);
        $builder->orderBy($orderbykey, $orderby);
        if (!empty($getorcount) && $getorcount == "count") {
            $results = $builder->get()->getResultArray();
            return count($results);
        } else if (!empty($getorcount) && $getorcount == "get") {
            $results = $builder->get()->getResultArray();
            return $results;
        }
    }
    
    
    public function updateData($table, $data, $where) {
        $builder = $this->db->table($table);
        $builder->set($data)->where($where);
        if ($builder->update()) {
            return true; // Return true if the update was successful.
            
        } else {
            return false; // Return false if the update failed.
            
        }
    }
    
    
    public function saveupdate($table, $data, $validation = null, $where = null, $id = null) {
        $builder = $this->db->table($table);
        if (!is_null($where)) {
            $status = $builder->set($data)->where($where)->update();
            return !is_null($id) ? $id : $status;
        } else {
            if (!is_null($validation)) {
                $builder->where($validation);
            }
            if (!is_null($validation) && $builder->countAllResults() > 0) {
                return false;
            } else {
                $builder->insert($data);
                return $this->db->insertID();
            }
        }
    }
    
    
    public function getBulkRecords( $tableName, $whereCondition, $columNames = '*', $getOrCount = null, $orderBy = null, $orderByKeys = null, $offset = null, $limit = null, $joinArray = null, $inKey = null, $inValue = null, $inType = null, $likeKey = null,$likeValue = null,$likeAction = null, $groupBy = null ){
        $queryBuilder = $this->db->table( $tableName );
        $queryBuilder->select( $columNames );


         
        if(!empty( $groupBy ) ){
            $queryBuilder->groupBy( $groupBy );
        }

        if(!empty( $whereCondition ) ){
            $queryBuilder->where( $whereCondition );
        }

        if(!empty( $limit ) && !empty($offset) ){
            $queryBuilder->limit( $limit, $offset  );
        }else if(!empty($limit)){
            $queryBuilder->limit( $limit );
        }

        if(!empty( $orderByKeys ) && !empty( $orderBy ) ){
            $queryBuilder->orderBy( $orderByKeys, $orderBy );
        }

        if( !empty($joinArray) ){
            foreach ($joinArray as $key => $value) {
                $queryBuilder->join( $value['table'], $value['join_on'], $value['join_type'] );
            } 
        }

        if( !empty($inKey) && !empty($inValue) && ($inType == 'in') ){
            $queryBuilder->whereIn($inKey,(explode(',',$inValue)));
        }
        else if( !empty($inKey) && !empty($inValue) && ($inType == 'notin') ){
            $queryBuilder->whereNotIn($inKey,(explode(',',$inValue )));
        }

        if(!empty($likeValue) && !empty($likeKey) && !empty($likeAction) ){
            $queryBuilder->like($likeKey,$likeValue,$likeAction);
        } 

        if( $getOrCount == 'count'){
            $resultData = $queryBuilder->get()->getResultArray(); 
            return  !empty($resultData) ? sizeof($resultData) : 0;
        }
        else if( $getOrCount == 'get') {
            $resultData = $queryBuilder->get()->getResultArray(); 
            return  !empty($resultData) ? $resultData : [];
        } 
    }  


    public function db(){
        return $this->db;
    }
}
?>