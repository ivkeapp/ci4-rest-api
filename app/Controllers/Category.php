<?php namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\CategoryModel;

class Category extends ResourceController
{

    use ResponseTrait;
    // all posts
    public function index(){
      $model = new CategoryModel();
      $data['categories'] = $model->orderBy('category_id', 'DESC')->findAll();
      return $this->respond($data);
    }
    // create
    public function create() {
        $model = new CategoryModel();
        $error = array();
        $input = $this->request->getRawInput(); // getting raw input, apparently there is some bug in CI4 with getVar()
        $data = [
            'name'        => $input['name'],
        ];
        if($model->insert($data)){
            $error['isOk'] = true;
            $error['errorMessage'] = 'No error.';
        } else {
            $error['isOk'] = false;
            $error['errorMessage'] = 'Category has not beed added.';
        }
        $response = [
          'status'   => 201,
          'error'    => $error,
          'messages' => [
              'post' => $data,
              'success' => 'Category has been created successfully.'
          ]
      ];
      return $this->respondCreated($response);
    }
    // single post
    public function show($id = null){
        $model = new CategoryModel();
        $data = $model->where('category_id', $id)->first();
        if($data){
            return $this->respond($data);
        }else{
            return $this->failNotFound('Category is not found.');
        }
    }
    // update
    public function update($id = null){
        $model = new CategoryModel();
        $error = array();
        $input = $this->request->getRawInput(); // getting raw input, apparently there is some bug in CI4 with getVar()
        $data = [
            'name'   => $input['name'],
        ];
        if($model->insert($data)){
            $error['isOk'] = true;
            $error['errorMessage'] = 'No error.';
        } else {
            $error['isOk'] = false;
            $error['errorMessage'] = 'Category has not beed added.';
        }
        $response = [
          'status'   => 200,
          'error'    => $error,
          'messages' => [
              'post'    => $data,
              'success' => 'Category has been updated successfully.'
          ]
      ];
      return $this->respond($response);
    }
    // delete
    public function delete($id = null){
        $model = new CategoryModel();
        $error = array();
        if(isset($id)){
            $data = $model->where('category_id', $id)->delete($id);
            if($data){
                $error['isOk'] = true;
                $error['errorMessage'] = 'No error.';
            } else {
                $error['isOk'] = false;
                $error['errorMessage'] = 'Category has not been deleted.';
            }
        } else {
            $error['isOk'] = false;
            $error['errorMessage'] = 'Please provide post ID.';
        }
        $response = [
            'status'   => 200,
            'error'    => $error,
            'messages' => [
                'post'    => $id,
                'success' => 'Category has been deleted successfully.'
            ]
        ];
        return $this->respondDeleted($response);
    }
}