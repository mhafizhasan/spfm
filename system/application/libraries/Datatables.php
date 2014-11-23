<?php if(!defined("BASEPATH")) exit("No direct script access allowed");
  class Datatables
  {
    protected $ci;

    public function __construct()
    {
      $this->ci =& get_instance();
    }

    public function generate($table, $columns, $index, $dept_id='')
    {
      $sLimit = $this->get_paging();
      $sOrder = $this->get_ordering($columns);
      $sWhere = $this->get_filtering($columns, $dept_id);
      $rResult = $this->get_display_data($table, $columns, $sWhere, $sOrder, $sLimit);
      $rResultFilterTotal = $this->get_data_set_length();
      $aResultFilterTotal = $rResultFilterTotal->result_array();
      $iFilteredTotal = $aResultFilterTotal[0]["FOUND_ROWS()"];
      $rResultTotal = $this->get_total_data_set_length($table, $index, $sWhere);
      $aResultTotal = $rResultTotal->result_array();
      $iTotal = $aResultTotal[0]["COUNT($index)"];
      return $this->produce_output($columns, $iTotal, $iFilteredTotal, $rResult);
    }

    protected function get_paging()
    {
      $sLimit = "";

      if($this->ci->input->post("iDisplayStart") && $this->ci->input->post("iDisplayLength") != "-1")
        $sLimit = "LIMIT " . $this->ci->input->post("iDisplayStart") . ", " . $this->ci->input->post("iDisplayLength");
      else
      {
        $iDisplayLength = $this->ci->input->post("iDisplayLength");

        if(empty($iDisplayLength))
          $sLimit = "LIMIT " . "0,10";
        else
          $sLimit = "LIMIT 0," . $iDisplayLength;
      }

      return $sLimit;
    }

    protected function get_ordering($columns)
    {
      $sOrder = "";

      if($this->ci->input->post("iSortCol_0") != null)
      {
        $sOrder = "ORDER BY ";

        for($i = 0; $i < intval($this->ci->input->post("iSortingCols")); $i++)
          $sOrder .= $columns[intval($this->ci->input->post("iSortCol_" . $i))] . " " . $this->ci->input->post("sSortDir_" . $i) . ", ";

        $sOrder = substr_replace($sOrder, "", -2);
      }

      return $sOrder;
    }

    protected function get_filtering($columns, $dept_id)
    {
      $sWhere = "";

      if(strlen($dept_id) > 0 && $dept_id!='') {
      	
	      if($this->ci->input->post("sSearch") != "")
	      {
	        $sWhere = "WHERE ";
	
	        for($i = 0; $i < count($columns); $i++)
	          $sWhere .= $columns[$i] . " LIKE '%" . $this->ci->input->post("sSearch") . "%' OR ";
	
	        $sWhere = substr_replace($sWhere, "", -3);
	      }
	      else {
	      	
	      	$sWhere = "WHERE bahagian='".$dept_id."' ";
	      }
      }
		//echo $sWhere;
      return $sWhere;
    }

    protected function get_display_data($table, $columns, $sWhere, $sOrder, $sLimit)
    {
/*    	
    echo "
    SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $columns) . "
        FROM $table
        $sWhere
        $sOrder
        $sLimit
    ";
 */  	
      return $this->ci->db->query
      ("
        SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $columns) . "
        FROM $table
        $sWhere
        $sOrder
        $sLimit
      ");
    }

    protected function get_data_set_length()
    {
      return $this->ci->db->query("SELECT FOUND_ROWS()");
    }

    protected function get_total_data_set_length($table, $index, $sWhere)
    {
      return $this->ci->db->query
      ("
        SELECT COUNT(" . $index . ")
        FROM $table
        $sWhere
      ");
    }

    protected function produce_output($columns, $iTotal, $iFilteredTotal, $rResult)
    {
      $aaData = array();

      foreach($rResult->result_array() as $row_key => $row_val)
      {
        foreach($row_val as $col_key => $col_val)
        {
          if($row_val[$col_key] == "version")
            $aaData[$row_key][$col_key] = ($aaData[$row_key][$col_key] == 0)? "-" : $col_val;
          else
          {
            /*
              you can manipulate your result data here
              like wrapping your result in additional html tags for example:

              $aaData[$row_key][] = '<span class="additionalTag">' . $col_val . '</span>';

              you can also add further logic based on column specific values
              but by default, I'm leaving it as queried
            */
            $aaData[$row_key][] = $col_val;
          }
        }

        /*
          add additional columns here
          like adding a Delete Row control for example:

          $aaData[$row_key][] = '<a href="#">Delete Button</a>';
        */
      }

      $sOutput = array
      (
        "sEcho"                => intval($this->ci->input->post("sEcho")),
        "iTotalRecords"        => $iTotal,
        "iTotalDisplayRecords" => $iFilteredTotal,
        "aaData"               => $aaData
      );

      return json_encode($sOutput);
    }
  }
?>  