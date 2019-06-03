<?php

namespace App\Repositories;


abstract class BaseRepository implements RepositoryInterface {

  abstract public function getModel();

  public function find($id)  {

    return $this->getModel()->find($id);

  }

  public function getAll(){

    return $this->getModel()->all();
  }

  public function create(array $data){

    $this->getModel->create($data);
  }

  public function update(array $data, $id){

    $this->getModel->find($id)->update->all();
  }

  public function delete($id){

   $registro = $this->getModel()->findOrFail($id);
   $registro->delete();

  }

}
