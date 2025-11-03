<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface UserInterface
{

    public function login(Request $request);

    public function index();

    public function getdata();

    public function show($id);

    public function create();

    public function store(Request $data);

    public function delete($id);
    public function logout();
    public function login_page();
}
