<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	// Constructor
	public function __construct() {
	  parent:: __construct();

	  // Load the inventory model
	  $this->load->model('Inventory_model');
	}

	public function index() {
		$data['categories'] = $this->Inventory_model->get_all_cats();

		$this->load->view('welcome_message', $data);
	}

	public function search_prod_name() {
		$product_data = $this->input->post('');
	}

	public function search() {
		// Get the product info by the product name, upc, and category
		$prod_name = $this->input->post('product'); 
		$upc = $this->input->post('upc');
		$cat = $this->input->post('cat');

		if(isset($prod_name) && !empty($prod_name)) {
			$prod_val = $prod_name;
		} else {
			$prod_val = '';
		}

		if(isset($upc) && !empty($upc)) {
			$upc_val = $upc;
		} else {
			$upc_val = '';
		}

		if(isset($cat) && !empty($cat)) {
			$cat_val = $cat;
		} else {
			$cat_val = '';
		}

		$data['products'] = $this->Inventory_model->prod_id_by_prod_name($prod_val, $upc_val, $cat_val);

		$data['categories'] = $this->Inventory_model->get_all_cats();

		if(!empty($data['products'])) {
			// Create an array of just the product ids
			$prod_ids = array();
			foreach($data['products'] as $prod) {
				$prod_ids[] = $prod->id;
			}

			// Pass the ids back to the model to get the inventory records
			$data['inventory'] = $this->Inventory_model->search_inv($prod_ids);

			// Create an array of just the store ids
			$store_ids = array(); 
			foreach($data['inventory'] as $inv) {
				$store_ids[] = $inv->store;
			}

			// Get the store data based off the inventory ids
			$data['stores'] = $this->Inventory_model->store_data_by_store_id($store_ids);

			$this->load->view('welcome_message', $data);
		} else {
			$no_results['msg'] = "Sorry, we can't find any products matching that search.";

			$no_results['categories'] = $this->Inventory_model->get_all_cats();
			
			$this->load->view('welcome_message', $no_results);
		}

		
	}
}
