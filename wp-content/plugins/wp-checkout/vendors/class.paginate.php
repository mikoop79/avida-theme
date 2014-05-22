<?php

class wpcoPaginate extends wpCheckoutPlugin {
	
	/**
	 * DB table name to paginate on
	 *
	 */
	var $table = '';
	
	/**
	 * Fields for SELECT query
	 * Only these fields will be fetched.
	 * Use asterix for all available fields
	 *
	 */
	var $fields = '*';
	
	/**
	 * Current page
	 *
	 */
	var $page = 1;
	
	/**
	 * Records to show per page
	 *
	 */
	var $per_page = 10;
	
	/**
	 * WHERE conditions
	 * This should be an array
	 *
	 */
	var $where = '';
	
	/**
	 * ORDER condition
	 *
	 */
	var $order = array('modified', "DESC");
	
	var $plugin_url;
	var $sub;
	var $parent;
	
	var $allcount = 0;
	var $allRecords = array();
	
	var $pagination = '';
	
	function wpcoPaginate($table = null, $fields = null, $sub = null, $parent = null) {	
		$this -> sub = $sub;
		$this -> parentd = $parent;
	
		if (!empty($table)) {
			$this -> table = $table;
		}
		
		if (!empty($fields)) {
			$this -> fields = $fields;
		}
	}
	
	function start_paging($page = null) {
		global $wpdb, $wpcoHtml;
	
		$page = (empty($page)) ? 1 : $page;
	
		if (!empty($page)) {
			$this -> page = $page;
		}
		
		if (!empty($this -> fields)) {
			if (is_array($this -> fields)) {
				$this -> fields = implode(", ", $this -> fields);
			}
		}
		
		$query = "SELECT " . $this -> fields . " FROM `" . $this -> table . "`";
		$countquery = "SELECT COUNT(*) FROM `" . $this -> table . "`";
		
		switch ($this -> table) {
			case $wpdb -> prefix . $this -> pre . 'products'							:
				global $wpcoContent;
				if (!empty($this -> searchterm) && !is_admin()) {
					$query = "SELECT DISTINCT " . $this -> table . ".* FROM " . $this -> table;
					$query .= " LEFT JOIN " . $wpdb -> prefix . $wpcoContent -> table . " ON " . $wpdb -> prefix . $wpcoContent -> table . ".product_id = " . $this -> table . ".id";
					$countquery .= " LEFT JOIN " . $wpdb -> prefix . $wpcoContent -> table . " ON " . $wpdb -> prefix . $wpcoContent -> table . ".product_id = " . $this -> table . ".id";
				}
				break;
			case $wpdb -> prefix . $this -> pre . 'categoriesproducts'					:
				global $Product;
				$query .= " LEFT JOIN " . $wpdb -> prefix . $Product -> table . " ON " . $this -> table . ".product_id = " . $wpdb -> prefix . $Product -> table . ".id";
				$countquery .= " LEFT JOIN " . $wpdb -> prefix . $Product -> table . " ON " . $this -> table . ".product_id = " . $wpdb -> prefix . $Product -> table . ".id";
				break;
		}
		
		//check if some conditions where passed.
		if (!empty($this -> where)) {
			//append the "WHERE" command to the query
			$query .= " WHERE";
			$countquery .= " WHERE";
			$c = 1;
			$p =1;
			
			foreach ($this -> where as $key => $val) {
				if (!empty($val) && is_array($val)) {
					$k = 1;
				
					foreach ($val as $vkey => $vval) {
						if (eregi("LIKE", $val)) {
							$query .= " " . $key . " " . $vval . "";	
							$countquery .= " " . $key . " " . $vval . "";
						} elseif (preg_match("/SE (.*)/si", $vval, $vmatches)) {
							if (!empty($vmatches[1])) {
								$query .= " " . $key . " <= " . $vmatches[1] . "";
								$countquery .= " " . $key . " <= " . $vmatches[1] . "";;
							}
						} elseif (preg_match("/LE (.*)/si", $vval, $vmatches)) {
							if (!empty($vmatches[1])) {
								$query .= " " . $key . " >= " . $vmatches[1] . "";
								$countquery .= " " . $key . " >= " . $vmatches[1] . "";
							}
						} else {
							$query .= " " . $key . " = '" . $vval . "'";
							$countquery .= " " . $key . " = '" . $vval . "'";
						}
						
						if ($k < count($val)) {
							$query .= " AND";
							$countquery .= " AND";
						}
						
						$k++;
						$vmatches = false;
					}
				} else {
					if (preg_match("/LIKE/i", $val)) {
						$query .= " " . $key . " " . $val . "";	
						$countquery .= " " . $key . " " . $val . "";
					} elseif (preg_match("/SE (.*)/si", $val, $vmatches)) {
						if (!empty($vmatches[1])) {
							$query .= " `" . $key . "` <= " . $vmatches[1] . "";
							$countquery .= " `" . $key . "` <= " . $vmatches[1] . "";
						}
					} elseif (preg_match("/LE (.*)/si", $val, $vmatches)) {
						if (!empty($vmatches[1])) {
							$query .= " `" . $key . "` >= " . $vmatches[1] . "";
							$countquery .= " `" . $key . "` >= " . $vmatches[1] . "";
						}
					} else {
						$query .= " " . $key . " = '" . $val . "'";
						$countquery .= " " . $key . " = '" . $val . "'";
					}
				}
				
				if ($c < count($this -> where)) {
					$query .= " AND";
					$countquery .= " AND";
				}
				
				$c++;
				$vmatches = false;
			}
		}
		
		$r = 1;
		
		$this -> doberecords();
		if ($this -> order != "RAND") {
			list($osortby, $osort) = $this -> order;
			if ($osortby == "order") { $osortby = $this -> table . ".order"; }
			$sortstring = ($osortby == "price") ? "ABS(`" . $osortby . "`) " . $osort : "" . $osortby . " " . $osort;
		} else {
			$sortstring = "RAND()";
		}
			
		$query .= " ORDER BY " . $sortstring . " LIMIT " . $this -> begRecord . " , " . $this -> per_page . ";";
		$records = $wpdb -> get_results($query);
		$records_count = count($records);
		$allRecordsCount = $this -> allcount = $wpdb -> get_var($countquery);
		$totalpagescount = round($records_count / $this -> per_page);
		
		$pageparam = (!empty($this -> sub) && $this -> sub == "N") ? '' : 'page=' . $this -> sub . '&';
		$search = (empty($this -> searchterm)) ? '' : '&' . $this -> pre . 'searchterm=' . urlencode($this -> searchterm);
		
		if (count($records) < $allRecordsCount) {			
			$p = 1;
			$k = 1;
			$n = $this -> page;
			
			$add_prev = $pageparam . $this -> pre . 'page=' . ($this -> page - 1) . $search . '';
			$add_next = $pageparam . $this -> pre . 'page=' . ($this -> page + 1) . $search . '';
			
			$this -> pagination .= '<span class="displaying-num">' . __('Displaying', $this -> plugin_name) . ' ' . ($this -> begRecord + 1) . ' - ' . ($this -> begRecord + count($records)) . ' ' . __('of', $this -> plugin_name) . ' ' . $allRecordsCount . '</span>';
		
			if ($this -> page > 1) {
				$this -> pagination .= '<a class="prev page-numbers" href="' . $wpcoHtml -> retainquery($add_prev) . '" title="' . __('Previous Page', $this -> plugin_name) . '">&laquo;</a>';
			}
			
			while ($p <= $allRecordsCount) {
				$add_numbers = $pageparam . $this -> pre . 'page=' . ($k) . $search . '';
					
				if ($k >= ($this -> page - 3) && $k <= ($this -> page + 3)) {
					if ($k != $this -> page) {
						$this -> pagination .= '<a class="page-numbers" href="' . $wpcoHtml -> retainquery($add_numbers) . '" title="' . __('Page', $this -> plugin_name) . ' ' . $k . '">' . $k . '</a>';
					} else {
						$this -> pagination .= '<span class="page-numbers current">' . $k . '</span>';
					}
				}
				
				$p = $p + $this -> per_page;
				$k++;
			}
			
			if ((count($records) + $this -> begRecord) < $allRecordsCount) {
				$this -> pagination .= '<a class="next page-numbers" href="' . $wpcoHtml -> retainquery($add_next) . '" title="' . __('Next Page', $this -> plugin_name) . '">&raquo;</a>';
			}
		}
		
		return $records;
	}
	
	function doberecords() {
		if ($this -> page > 1) {
			$this -> begRecord = (($this -> page * $this -> per_page) - ($this -> per_page));
		} else {
			$this -> begRecord = 0;
		}
		
		$this -> endRecord = $this -> begRecord + $this -> per_page;
	}
}

?>