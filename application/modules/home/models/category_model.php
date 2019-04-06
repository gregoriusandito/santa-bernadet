<?php
	class Category_model extends CI_Model  {
	function __construct() { 
		parent::__construct(); 
	} 

	function getCategory($id)
	{
		$this->db->select('posts.*, users.first_name AS first_name, users.last_name AS last_name, categories.*');
		$this->db->from('posts');
		$this->db->join('users','users.id = posts.post_author','LEFT');
		$this->db->join('categories','categories.category_id = posts.category_id');
		$this->db->where('categories.category_id', $id);
		$this->db->where('post_status', 1);
		$this->db->order_by('post_created', 'DESC');
        
        return $this->db->get();
	}
	
    public function recordCount( $content = array() ) {
        return count( $content );
    }	
    
    public function fetchCategory($limit, $start, $id = null) {
        $this->db->limit($limit, $start);
		$query = $id == null ? $this->getAllNews() : $this->getCategory($id);
		
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }    


    // fetch all news regardless its category
	function getAllNews()
	{   
		$this->db->select('posts.*, users.first_name AS first_name, users.last_name AS last_name, categories.*');
		$this->db->from('posts');
		$this->db->join('users','users.id = posts.post_author','LEFT');
		$this->db->join('categories','categories.category_id = posts.category_id');
		$this->db->where('categories.category_id NOT IN (4,6,7)');
		$this->db->where('post_status', 1);
		$this->db->order_by('post_created', 'DESC');
        
        return $this->db->get();
	}

//     public function fetchAllNews($limit, $start) {
//         $this->db->limit($limit, $start);
// 		$query = $this->getAllNews();
		
//         if ($query->num_rows() > 0) {
//             foreach ($query->result() as $row) {
//                 $data[] = $row;
//             }
//             return $data;
//         }
//         return false;
//   }    

	
}