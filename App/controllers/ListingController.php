<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;

class ListingController {

    protected $db;

    public function __construct() {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    /**
     * Show all listings
     *
     * @return void
     */

    public function index() {

        inspectAndDie(Validation::match('test', 'test'));

        $listings = $this->db->query('SELECT * FROM listings')->fetchAll();

        loadView('listings/index', [
            'listings' => $listings
        ]);
    }

    /**
     * Show create listings for
     * 
     * @return void
     */

    public function create() {
        loadView('listings/create');
    }

    /**
     * Show single listing
     * 
     * @return void
     */

    public function show($params) {
        $id = $params['id'] ?? '';

        $params = [
            'id' => $id
        ];  

        $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', $params) ->fetch();

        // Check if listing exists
        if(!$listing) {
            ErrorController::notFound('Listing not found');
            return;
        }

        loadView('listings/show', [
            'listing' => $listing
        ]);
    }
}