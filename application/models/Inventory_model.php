<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Inventory_model extends CI_Model {

		/**
		  * Inventory search functions
		  */

		public function prod_id_by_prod_name($prod_name, $upc, $category) {
			
			if($prod_name != '') {
				$this->db->like('name', $prod_name, 'both');
			}

			if($upc != '') {
				$this->db->like('upc', $upc, 'both');
			}

			if($category != '') {
				$this->db->like('category', $category, 'both');
			}

			$query = $this->db->get('products');

			//print_r($this->db->last_query());
			//print_r($query);

			return $query->result();
		}

		public function store_data_by_store_id($store_ids) {
			$this->db->where_in('id', $store_ids);
			$query = $this->db->get('stores');

			//print_r($this->db->last_query());

			return $query->result();
		}

		/*public function prod_name_by_prod_id($id) {
			$this->db->select('*');
			$this->db->where('id', $id);
			$query = $this->db->get('products');

			return $query->result();
		}*/

		public function search_inv($products) {
			$this->db->where_in('product', $products);
			$this->db->order_by('in_stock', 'DESC');
			$query = $this->db->get('inventory');

			//print_r($this->db->last_query());

			return $query->result();
		}

		public function get_all_cats() {
			$this->db->from('categories');
			$this->db->order_by('name', 'asc');
			$query = $this->db->get();

			return $query->result();
		}

	}

?>