<?php

namespace App\Repositories;


abstract class BaseRepository implements RepositoryInterface {

  abstract public function getModel();

  public function find($id)
  {

    return $this->getModel()->find($id);

  }

  public function getAll()
  {
    return $this->getModel()->all();
  }

  public function create(array $data){}

  public function update(array $data, $id){}

  public function delete($id){

    $this->getModel()->delete($id);

  }

}
