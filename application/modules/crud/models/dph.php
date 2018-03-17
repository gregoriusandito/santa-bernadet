<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dph extends CI_Model {

	/**
	 * [get_users_dph description]
	 * @param  boolean $id [description]
	 * @return [type]      [description]
	 */
	public function get_users_dph($id=FALSE)
	{

		// if no id was passed use the current users id
		// $id || $id = $this->session->userdata('user_id');

		return $this->db
			->select('dph.dph_id as id, master_dph.dph_title as title')
			->where('dph.user_id' , $id)
			->join('master_dph', 'dph.dph_id = master_dph.dph_id')
			->get('dph');
	}



	/**
	 * [add_to_group description]
	 * @param [type]  $group_ids [description]
	 * @param boolean $user_id   [description]
	 */
	public function add_to_dph($dph_ids, $user_id=false)
	{

		// if no id was passed use the current users id
		$user_id || $user_id = $this->session->userdata('user_id');

		if(!is_array($dph_ids))
		{
			$dph_ids = array($dph_ids);
		}

		$return = 0;

		// Then insert each into the database
		foreach ($dph_ids as $dph_id)
		{
			$data = array(
				'user_id' => $user_id ,
				'dph_id' => (float)$dph_id ,
				);
			if ($this->db->insert('dph', $data))
			{
				$return += 1;
			}
		}

		return $return;
	}

	/**
	 * [remove_from_dph description]
	 * @param  string $value [description]
	 * @return [type]        [description]
	 */
	public function remove_from_dph($dph_ids=false, $user_id=false)
	{
		// user id is required
		if(empty($user_id))
		{
			return FALSE;
		}

		$data = array(
			'user_id' => $user_id ,
			'dph_id' => $dph_ids ,
			);
		if($this->db->delete('dph', $data))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}


	public function remove_from_group($group_ids=false, $user_id=false)
		{
			$this->trigger_events('remove_from_group');

			// user id is required
			if(empty($user_id))
			{
				return FALSE;
			}

			// if group id(s) are passed remove user from the group(s)
			if( ! empty($group_ids))
			{
				if(!is_array($group_ids))
				{
					$group_ids = array($group_ids);
				}

				foreach($group_ids as $group_id)
				{
					$this->db->delete($this->tables['users_groups'], array($this->join['groups'] => (float)$group_id, $this->join['users'] => (float)$user_id));
					if (isset($this->_cache_user_in_group[$user_id]) && isset($this->_cache_user_in_group[$user_id][$group_id]))
					{
						unset($this->_cache_user_in_group[$user_id][$group_id]);
					}
				}

				$return = TRUE;
			}
			// otherwise remove user from all groups
			else
			{
				if ($return = $this->db->delete($this->tables['users_groups'], array($this->join['users'] => (float)$user_id))) {
					$this->_cache_user_in_group[$user_id] = array();
				}
			}
			return $return;
		}



	}

