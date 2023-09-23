<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
class Register extends BaseController
{
    use ResponseTrait;
    public function index()
    {
        try{
                $rules = [
                    'email' => ['rules' => 'required|min_length[4]|max_length[255]|valid_email|is_unique[users.email]'],
                    'password' => ['rules' => 'required|min_length[8]|max_length[255]'],
                    'confirm_password'  => [ 'label' => 'confirm password', 'rules' => 'matches[password]']
                ];
                    
  
            if($this->validate($rules)){
                $model = new UserModel();
                    $data = [
                    'name'    => $this->request->getPost('name'),
                    'email'    => $this->request->getPost('email'),
                    'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
                    ];
                    $id = $model->insert($data);
                    $result = $model->where('id',$id)->findAll();
                    $data='';
                    foreach($result as $val){
                    $data=[
                        'id'=>$val['id'],
                        'name' => $val['name'],
                        'email' => $val['email']
                    ];
                    }

                    $response = [
                        'status' => true,
                        'message' =>'Registered successfully',
                        'content' =>['key' => $data]
                    ];
                return $this->response->setJSON($response, 200);
                    
        }else{
                $response = [
                    'errors' => $this->validator->getErrors(),
                    'message' => 'Invalid Inputs'
                ];
                return $this->fail($response , 409);
        }
    }catch(\Exception $e){ 
        die($e->getMessage());
        } 
    }
}
