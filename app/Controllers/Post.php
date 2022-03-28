<?php namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\PostModel;
use CodeIgniter\HTTP\IncomingRequest;

class Post extends ResourceController
{

    public function getRequestInput(IncomingRequest $request){
        $input = $request->getPost();
        if (empty($input)) {
            //convert request body to associative array
            $input = json_decode($request->getBody(), true);
        }
        return $input;
    }

    use ResponseTrait;
    // all users
    public function index(){
      $model = new PostModel();
      $data['users'] = $model->orderBy('post_id', 'DESC')->findAll();
      return $this->respond($data);
    }
    // create
    public function create() {
        $model = new PostModel();
        $error = array();
        $input = $this->request->getRawInput(); // getting raw input, apparently there is some bug in CI4 with getVar()
        $data = [
            'category'   => $input['category'],
            'headtitle' => $input['headtitle'],
            'body'  => $input['body'],
            'image_path'      => $input['image_path'],
            'creator_id'      => $input['creator_id'],
            'date_added'      => $input['date_added'],
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
              'user' => $data,
              'success' => 'Post has been created successfully.'
          ]
      ];
      return $this->respondCreated($response);
    }
    // single user
    public function show($id = null){
        $model = new PostModel();
        $data = $model->where('user_id', $id)->first();
        if($data){
            return $this->respond($data);
        }else{
            return $this->failNotFound('Post is not found.');
        }
    }
    // update
    public function update($id = null){
        $model = new PostModel();
        // $id = $this->request->getVar('user_id');
        $error = array();
        $input = $this->request->getRawInput(); // getting raw input, apparently there is some bug in CI4 with getVar()
        $data = [
            'category'   => $input['category'],
            'headtitle' => $input['headtitle'],
            'body'  => $input['body'],
            'image_path'      => $input['image_path'],
            'creator_id'      => $input['creator_id'],
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
              'user'    => $data,
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
            $data = $model->where('user_id', $id)->delete($id);
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
                'user'    => $id,
                'success' => 'Post has been deleted successfully.'
            ]
        ];
        return $this->respondDeleted($response);
    }
}