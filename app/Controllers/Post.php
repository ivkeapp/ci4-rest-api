<?php namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\PostModel;

class Post extends ResourceController
{

    use ResponseTrait;
    // all posts
    public function index(){
      $model = new PostModel();
      $data['posts'] = $model->orderBy('post_id', 'DESC')->findAll();
      return $this->respond($data);
    }
    // create
    public function create() {
        $model = new PostModel();
        $error = array();
        $input = $this->request->getRawInput(); // getting raw input, apparently there is some bug in CI4 with getVar()
        $data = [
            'category'    => $input['category'],
            'headtitle'   => $input['headtitle'],
            'body'        => $input['body'],
            'image_path'  => $input['image_path'],
            'creator_id'  => $input['creator_id'],
        ];
        if($model->insert($data)){
            $error['isOk'] = true;
            $error['errorMessage'] = 'No error.';
        } else {
            $error['isOk'] = false;
            $error['errorMessage'] = 'Post has not beed added.';
        }
        $response = [
          'status'   => 201,
          'error'    => $error,
          'messages' => [
              'post' => $data,
              'success' => 'Post has been created successfully.'
          ]
      ];
      return $this->respondCreated($response);
    }
    // single post
    public function show($id = null){
        $model = new PostModel();
        $data = $model->where('post_id', $id)->first();
        if($data){
            return $this->respond($data);
        }else{
            return $this->failNotFound('Post is not found.');
        }
    }
    // update
    public function update($id = null){
        $model = new PostModel();
        $error = array();
        $input = $this->request->getRawInput(); // getting raw input, apparently there is some bug in CI4 with getVar()
        $data = [
            'post_id'     => $id,
            'category'    => $input['category'],
            'headtitle'   => $input['headtitle'],
            'body'        => $input['body'],
            'image_path'  => $input['image_path'],
            'creator_id'  => $input['creator_id'],
        ];
        if($model->insert($data)){
            $error['isOk'] = true;
            $error['errorMessage'] = 'No error.';
        } else {
            $error['isOk'] = false;
            $error['errorMessage'] = 'Post has not beed added.';
        }
        $response = [
          'status'   => 200,
          'error'    => $error,
          'messages' => [
              'post'    => $data,
              'success' => 'Post has been updated successfully.'
          ]
      ];
      return $this->respond($response);
    }
    // delete
    public function delete($id = null){
        $model = new PostModel();
        $error = array();
        if(isset($id)){
            $data = $model->where('post', $id)->delete($id);
            if($data){
                $error['isOk'] = true;
                $error['errorMessage'] = 'No error.';
            } else {
                $error['isOk'] = false;
                $error['errorMessage'] = 'Post has not been deleted.';
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
                'success' => 'Post has been deleted successfully.'
            ]
        ];
        return $this->respondDeleted($response);
    }
}