<?php
class Reports extends Model {

	function Reports() {
		parent::Model();
	} 
	
	function getRatingByPosition($pid=0) {
		
		$qry = $this->db->query(
			'SELECT COUNT(verified_2) as rating FROM verify_comment 
				WHERE verified_2="1" AND position_id="'.$pid.'" AND bab_id > 8 '
		);
		
		$veri_count = 0;
		if($qry->num_rows() > 0) {
			
			$rs = $qry->row();
			$veri_count = $rs->rating;
		}
		$rating = ($veri_count/9) * 5;
		
		$rating = round($rating);
		
		return $rating;
	}
	
	function getRatingByDept($dept_id,$limit,$uriseg=0) {
		
		$rstart = ($uriseg==null) ? 0 : $uriseg;
		
		$sql = "select A.post_id as post_id, A.bahagian as bahagian, A.nama_jawatan as nama_jawatan, A.singkatan as singkatan,
				A.status as status, B.fullname as fullname from lkp_position as A 
				left join user as B on A.post_id=B.position where A.bahagian='$dept_id' 
				order by gred desc, singkatan ASC  LIMIT $rstart,$limit";
		
		//echo $sql;
		
		$rs = $this->db->query($sql);
		
		$data = NULL;
		$sub_data = NULL;
		$totalBab = 9; // number of failmeja content
		
		if($rs->num_rows() > 0) {
			
			foreach($rs->result_array() as $row) {
				
				// assign value to sub_data
				$sub_data['post_id'] = $row['post_id'];
				$sub_data['nama_jawatan'] = $row['nama_jawatan'];
				$sub_data['singkatan'] = $row['singkatan'];
				$sub_data['fullname'] = $row['fullname'];
				$sub_data['bahagian'] = $row['bahagian'];
				
				// count verified by 2nd verifier
                $q_complete = "SELECT 
                               COUNT(verify_comment.id) as completed
                               FROM
                               verify_comment
                               WHERE
                               verify_comment.position_id = '".$row['post_id']."' AND
                               verify_comment.verified_2 = 1";
                
                $qry = $this->db->query($q_complete);
                $rs = $qry->row();
                
                $bilComplete = $rs->completed;
                
                //calculating verified bab/total bab to be completed ---> 5 stars
                $counted = $bilComplete/$totalBab*5;
                //change to 1 decimal number
                $star = number_format(round($counted,1),1);	
                $incompleteStar = number_format(5-$star,1);
                
                //get full star
                $completeInt = substr($star,-3,1);
                $sub_data['completeInt'] = $completeInt;
                $incompleteInt = substr($incompleteStar,-3,1);
                $sub_data['incompleteInt'] = $incompleteInt;
                
                //get half star
                $completeDec = substr($star,-1,1);
                $sub_data['completeDec'] = $completeDec;
				
				$data[] = $sub_data;
			}
		}
		return $data;
	}
	
	function getRatingAll($limit, $uriseg) { 

		$this->db->where('aktif','1');
		$qry = $this->db->get('lkp_department',$limit,$uriseg);
		
		$data = NULL;
		$sub_data = NULL;
		
		$totalBab = 9; // total kandungan fail meja

		if($qry->num_rows() > 0) {
			
			foreach($qry->result_array() as $row) {
				
				// 1. set dept_name & dept_id
				$sub_data['dept_name'] = $row['dept_name'];
				$sub_data['dept_id'] = $row['dept_id'];
				
				// count total staff every dept
				$q_totalStaf = "SELECT count(user.id) as totStaf
                                FROM user, lkp_position
                                WHERE user.position = lkp_position.post_id
                                AND lkp_position.bahagian = '".$row['dept_id']."' ";
				
				$qry = $this->db->query($q_totalStaf);				
				$rs = $qry->row();
				$totalStaf = $rs->totStaf;
				if($totalStaf > 0) {
					
					// count completed staff by dept
					$q_complete = "SELECT 
                                   COUNT(verify_comment.id) as completed
                                   FROM
                                   verify_comment,
                                   lkp_position
                                   WHERE
                                   ( verify_comment.position_id = lkp_position.post_id ) AND
                                   ( lkp_position.bahagian = '".$row['dept_id']."' ) AND
                                   ( verify_comment.verified_2 = 1 )";
					
					$qry2 = $this->db->query($q_complete);
					$rs2 = $qry2->row();
					
					$bilComplete = $rs2->completed;
					
					 //calculating verified bab/total bab to be completed ---> 5 stars
                     $counted = $bilComplete/($totalBab*$totalStaf)*5;
                     //change to 1 decimal number
                     $star = number_format(round($counted,1),1);	
                     $incompleteStar = number_format(5-$star,1);
                     
                     //get full star
                     $completeInt = substr($star,-3,1);
                     // 2. set fullstar complete
                     $sub_data['completeInt'] = $completeInt;
                     
                     $incompleteInt = substr($incompleteStar,-3,1);
					 // 3. set fullstar incomplete
					 $sub_data['incompleteInt'] = $incompleteInt;
                     
                     //get half star
                     $completeDec = substr($star,-1,1);
                     $incompleteDec = substr($incompleteStar,-1,1);
                     // 4. set half star
                     $sub_data['completeDec'] = $completeDec;
                               
                     // 5. set percentage
                     $percentage = number_format($bilComplete/($totalBab*$totalStaf)*100,1);
                     $sub_data['percentage'] = $percentage;
                     
				}
				
				$data[] = $sub_data;
			}
		}
		return $data;
	}
	
}
