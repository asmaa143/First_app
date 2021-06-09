<?php

namespace App\lib\Storage;

interface IRepository{



    public function index();
    public function create(array $args);
    public function store();
    public function edit(string $id);
    public function update(string $id ,array $args);
    public function destroy(string $id);












}


