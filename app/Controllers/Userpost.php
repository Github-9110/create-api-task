<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use App\Models\PostModel;

class Userpost extends BaseController
{
    use ResponseTrait;
    public function index()
    {
        
     try{ 
          $session = session();
          $usr = $session->get('user');
       
          $users = new PostModel;
          $result = $users->where('users_id',$usr)->findAll();
          $data= [];
          foreach($result as $val){
            $data[] =[
            'id'=>$val['id'],
            'title' => $val['title'],
            'description' => $val['description'],
            'users_id' => $val['users_id'],
            'image' => base_url('/assets/uploads/').$val['image'],
            ];
          }
          $response = [
              'status' => true,
              'message' =>'successfully',
              'content' =>['key' => $data]
          ];
          return $this->response->setJSON($response, 200);

    }catch(\Exception $e){ 
     die($e->getMessage());
    } 
    }
}
