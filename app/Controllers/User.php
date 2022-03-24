<?php namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use CodeIgniter\HTTP\IncomingRequest;

class User extends ResourceController
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
      $model = new UserModel();
      $data['users'] = $model->orderBy('user_id', 'DESC')->findAll();
      return $this->respond($data);
    }
    // create
    public function create() {
        $model = new UserModel();
        $error = array();
        $input = $this->request->getRawInput(); // getting raw input, apparently there is some bug in CI4 with getVar()
        $data = [
            'username'   => $input['username'],
            'first_name' => $input['first_name'],
            'last_name'  => $input['last_name'],
            'phone'      => $input['phone'],
            'email'      => $input['email'],
        ];
        if($model->insert($data)){
            $error['isOk'] = true;
            $error['errorMessage'] = 'No error.';
        } else {
            $error['isOk'] = false;
            $error['errorMessage'] = 'User has not beed added.';
        }
        $response = [
          'status'   => 201,
          'error'    => $error,
          'messages' => [
              'success' => 'User has been created successfully.'
          ]
      ];
      return $this->respondCreated($response);
    }
    // single user
    public function show($id = null){
        $model = new UserModel();
        $data = $model->where('user_id', $id)->first();
        if($data){
            return $this->respond($data);
        }else{
            return $this->failNotFound('No user found.');
        }
    }
    // update
    public function update($id = null){
        $model = new UserModel();
        // $id = $this->request->getVar('user_id');
        $error = array();
        $input = $this->request->getRawInput(); // getting raw input, apparently there is some bug in CI4 with getVar()
        $data = [
            'username'   => $input['username'],
            'first_name' => $input['first_name'],
            'last_name'  => $input['last_name'],
            'phone'      => $input['phone'],
            'email'      => $input['email'],
        ];
        if($model->insert($data)){
            $error['isOk'] = true;
            $error['errorMessage'] = 'No error.';
        } else {
            $error['isOk'] = false;
            $error['errorMessage'] = 'User has not beed added.';
        }
        $response = [
          'status'   => 200,
          'error'    => $error,
          'messages' => [
              'user'    => $data,
              'success' => 'User has been updated successfully.'
          ]
      ];
      return $this->respond($response);
    }
    // delete
    public function delete($id = null){
        $model = new UserModel();
        $data = $model->where('user_id', $id)->delete($id);
        if($data){
            $model->delete($id);
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'User has been deleted successfully.'
                ]
            ];
            return $this->respondDeleted($response);
        }else{
            return $this->failNotFound('No user found.');
        }
    }
}