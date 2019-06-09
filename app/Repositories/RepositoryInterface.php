<?php

namespace App\Repositories;


interface RepositoryInterface
{

  public function getAll();

  public function create(object $data);

  public function update(array $data, $id);

  public function delete($id);



  public function find($id);
}
