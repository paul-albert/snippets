<?php

namespace app\models;

use app\db as db;

class treeView
{
	protected $db;
	
	public function __construct () {
		$this->db = db::getInstance();
	} 
    
    public function fetchCompleteTree () {
        $dbResult = $this->db
            ->query("
                SELECT t.*, COALESCE(d.name, e.name) AS name
                FROM tree_entry AS t
                INNER JOIN tree_entry_lang AS e ON (t.entry_id = e.entry_id)
                LEFT JOIN tree_entry_lang AS d ON (e.lang = 'eng' AND d.lang = 'ger' AND e.entry_id = d.entry_id) 
                WHERE d.entry_id IS NULL;
            ")
            ->fetchAll();
        return array_reduce($dbResult, function ($result, $item) {
            $result[$item['entry_id']] = $item;
            return $result;
        });
    }
    
}