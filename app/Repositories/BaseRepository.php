<?php

namespace App\Repositories;
use App\RepositoryInterface;

abstract class BaseRepository extend RepositoryInterface {

  abstract public funcion getModel();

  public function find($id)
  {

    return this->getModel()->find($id);

  }

  public function getAll()
  {
    return this->getModel()->all();
  }

  public function create($data)
  {
    return $this->getModel()->create($data);

  }

  public function update($objetc, $data)
  {

    $objetc->fill($data);
    $objetc->save();
    return $objetc;

  }

  public function delete($id){

    this->getModel()->delete($id);

  }

}
