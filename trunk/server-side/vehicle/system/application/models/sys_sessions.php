<?php
/**
* @property CI_Loader $load
* @property CI_Input $input
* @property CI_DB_active_record $db
* @property CI_DB_forge $dbforge
*/ 

class Sys_sessions extends Model {

      //Type: String
    var $username = '';

	  //Type: String
    var $session_id = '';

	  //Type: String
    var $ip_address = '';

	  //Type: String
    var $user_agent = '';

	  //Type: Long
    var $last_activity = '';

	
    function Sys_sessions()
    {
        parent::Model();
    }

    function read()
    {
        // BEGIN FILTER CRITERIA CHECK
        // If any of the following properties are set before Sys_sessions->get() is called from the controller then we will include
        // a where statement for each of the properties that have been set.

                if ($this->username)
        {
            $this->db->where("username", $this->username);
        }
                if ($this->session_id)
        {
            $this->db->where("session_id", $this->session_id);
        }
                if ($this->ip_address)
        {
            $this->db->where("ip_address", $this->ip_address);
        }
                if ($this->user_agent)
        {
            $this->db->where("user_agent", $this->user_agent);
        }
                if ($this->last_activity)
        {
            $this->db->where("last_activity", $this->last_activity);
        }
        
        // END FILTER CRITERIA CHECK

        // This will execute the query and collect the results and other properties of the query into an object.
        $query = $this->db->get("sys_sessions");

        return $query->result();
    }


    //TODO: check XSS and SQL injection here
    function readByPagination()
    {
        $limit = $this->input->post('rows');
        $page = $this->input->post('page');
        $sidx = $this->input->post('sidx');
        $sord = $this->input->post('sord');

        if(!$sidx) $sidx =1;
        $count = $this->db->count_all('sys_sessions');

        if( $count >0 ) {
            $total_pages = ceil($count/$limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page=$total_pages;
        $start = $limit * $page - $limit;

        $this->db->limit($limit, $start);
        $this->db->order_by("$sidx", "$sord");
        $objects = $this->db->get("sys_sessions")->result();
        $rows =  array();

        foreach($objects as $obj)
        {
            $cell = array();
                            array_push($cell, $obj->username);
                            array_push($cell, $obj->session_id);
                            array_push($cell, $obj->ip_address);
                            array_push($cell, $obj->user_agent);
                            array_push($cell, $obj->last_activity);
                        $row = new stdClass();
            $row->id = $cell[0];
            $row->cell = $cell;
            array_push($rows, $row);
        }

        $jsonObject = new stdClass();
        $jsonObject->page =  $page;
        $jsonObject->total = $total_pages;
        $jsonObject->records = $count;
        $jsonObject->rows = $rows;      



        return $jsonObject;
    }

    function save()
    {
        // When we insert or update a record in CodeIgniter, we pass the results as an array:
        $db_array = array(
                    "session_id" => $this->session_id,
                    "ip_address" => $this->ip_address,
                    "user_agent" => $this->user_agent,
                    "last_activity" => $this->last_activity,
          );

      $saveSuccess = false;

         // If key was set in the controller, then we will update an existing record.
        if ($this->username)
        {
            $this->db->trans_start();
            $this->db->where("username", $this->username);
            $this->db->update("sys_sessions", $db_array);
            if($this->db->affected_rows() > 0) {
                $saveSuccess = true;
            }
            else {
                $saveSuccess = false;
            }
            $this->db->trans_complete();
        }
        // If key was not set in the controller, then we will insert a new record.
        else
        {
            $this->db->trans_start();
            $this->db->insert("sys_sessions", $db_array);
            if($this->db->affected_rows() > 0) {
                $saveSuccess = true;
            }
            else {
                $saveSuccess = false;
            }
            $this->db->trans_complete();
        }
     
        return $saveSuccess;
    }


    function delete()
    {
        $saveSuccess = false;
         // As long as sys_sessions->username was set in the controller, we will delete the record.
        if ($this->username) {
            $this->db->where("username", $this->username);
            $this->db->delete("sys_sessions");
            if($this->db->affected_rows() > 0) {
                $saveSuccess = true;
            }
            else {
                $saveSuccess = false;
            }
        }
             return $saveSuccess;
    }
}

?>