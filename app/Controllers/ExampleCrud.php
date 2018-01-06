<?php

namespace App\Controllers;
use App\Models\CrudModel as CRUD;
use Respect\Validation\Validator as V;

class ExampleCrud extends Controller{

    public function index ($request, $response){
        echo '<h1><center>Hi welcome, try to get some data?<center></h1></br>';
        echo '<center><a href="example/api/v1/datas">All data</a>'." - ".
                '<a href="example/api/v1/data/1">Data by ID</a><center>';

        //FYI
        //getParam #id or $data or others it's mean that
        //user must give an input
        //while
        //getAtribut #id or others that mean you must add id or other in the link for exampel
        //base_url/api/user/#id
    }

    //get all data
    public function datas($request, $response){
        $data = CRUD::all();
        return $data->toJson();
    }

    //get data by id
    public function data($request, $response){

        $id = $request->getAttribute('id');
        $data = CRUD::where('id', $id)->get();
        return $data->toJson();

    }

    //create data by id
    public function create($request, $response) {

        $validation =  $this->validator->validate($request, [
            'data'          => V::notEmpty()->alpha(),
        ]);

        if($validation->failed()){
            return $response->withJson(array(
                'errors' => $_SESSION['errors']),400
            );
        }

        CRUD::create([
            'data'          => $request->getParam('data'),
        ]);

        return $response->withJson(array(
            'status' => 200,
            'message' => 'data berhasil ditambah'
        ),200);

    }

    //update data
    public function update($request, $response){

        $validation =  $this->validator->validate($request, [
            'id'            => V::notEmpty(),
            'data'          => V::notEmpty()->alpha(),
        ]);

        if($validation->failed()){
            return $response->withJson(array(
                'errors' => $_SESSION['errors']
            ),400);
        }

        $id = $request->getParam('id');
        $data = $request->getParam('data');

        $data = CRUD::where('id', $id)->update(['data' => $data]);

        return $response->withJson(array(
            'status' => 200,
            'message' => 'data dirubah'
        ),200);

    }

    //delete data by id
    public function delete($request, $response) {

        $id = $request->getAttribute('id');
        $data = CRUD::where('id', $id)->delete();
        return $response->withJson(array(
            'status' => 200,
            'message' => 'data ' .$id. ' berhasil di hapus'
        ),200);

    }


}