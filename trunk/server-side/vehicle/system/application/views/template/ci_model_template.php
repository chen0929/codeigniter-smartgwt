<?php echo "<?php" ?>

/**
* @property CI_Loader $load
* @property CI_Input $input
* @property CI_DB_active_record $db
* @property CI_DB_forge $dbforge
*/ 

class <?=ucwords($object_name)?> extends Model {

    <?php foreach($fields as $field):?>
  //<?php echo "Type: ".$field->type."\n"  ?>
    var $<?=$field->name?> = '';

	<?php endforeach;?>

    function <?=ucwords($object_name)?>()
    {
        parent::Model();
    }

    function read()
    {
        // BEGIN FILTER CRITERIA CHECK
        // If any of the following properties are set before <?=ucwords($object_name)?>->get() is called from the controller then we will include
        // a where statement for each of the properties that have been set.

        <?php foreach($fields as $field):?>
        if ($this-><?=$field->name?>)
        {
            $this->db->where("<?=$field->name?>", $this-><?=$field->name?>);
        }
        <?php endforeach;?>

        // END FILTER CRITERIA CHECK

        // This will execute the query and collect the results and other properties of the query into an object.
        $query = $this->db->get("<?=($object_name)?>");

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
        $count = $this->db->count_all('<?=$object_name?>');

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
        $objects = $this->db->get("<?=($object_name)?>")->result();
        $rows =  array();

        foreach($objects as $obj)
        {
            $cell = array();
            <?php foreach($fields as $field):?>
                array_push($cell, $obj-><?=$field->name?>);
            <?php endforeach;  ?>
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
<?php foreach($fields as $field):?>
    <?php if(!$field->isKey): ?>
            "<?=$field->name?>" => $this-><?=$field->name?>,
    <?php endif;?>
<?php endforeach;?>
      );

      $saveSuccess = false;

<?php foreach($fields as $field):?>
 <?php if($field->isKey): ?>
        // If key was set in the controller, then we will update an existing record.
        if ($this-><?=$field->name?>)
        {
            $this->db->trans_start();
            $this->db->where("<?=$field->name?>", $this-><?=$field->name?>);
            $this->db->update("<?=($object_name)?>", $db_array);
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
            $this->db->insert("<?=($object_name)?>", $db_array);
            if($this->db->affected_rows() > 0) {
                $saveSuccess = true;
            }
            else {
                $saveSuccess = false;
            }
            $this->db->trans_complete();
        }
 <?php endif;?>
<?php endforeach;?>

        return $saveSuccess;
    }


    function delete()
    {
        $saveSuccess = false;
<?php foreach($fields as $field):?>
 <?php if($field->isKey): ?>
        // As long as <?=($object_name)?>-><?=$field->name?> was set in the controller, we will delete the record.
        if ($this-><?=$field->name?>) {
            $this->db->where("<?=$field->name?>", $this-><?=$field->name?>);
            $this->db->delete("<?=($object_name)?>");
            if($this->db->affected_rows() > 0) {
                $saveSuccess = true;
            }
            else {
                $saveSuccess = false;
            }
        }
 <?php endif;?>
<?php endforeach;?>
        return $saveSuccess;
    }
}

<?php echo "?>"?>
