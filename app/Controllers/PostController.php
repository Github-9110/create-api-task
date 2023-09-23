<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PostModel;

class PostController extends BaseController
{
    public function addpost()
    {
        try{ 

            $session = session();
            $usr = $session->get('user');
           
            $rules = [
            'title' => 'required|max_length[30]',
            'description' => 'required|max_length[255]',
            'file' => [
                'uploaded[file]',
                'mime_in[file,image/jpg,image/jpeg,image/png,image/gif]',
                'max_size[file,4096]',
            ]
            ];
            if($this->validate($rules)){
                
                $title = $this->request->getPost('title');
                $desc = $this->request->getPost('description');
                $file = $this->request->getFile('file');
                $fname = str_replace(' ', '_',$file->getName());
            
                $file->move("../public/assets/uploads",$fname);
                chmod("../public/assets/uploads/".$fname,0777);
                
                $data = array(
                    'title' => $title,
                    'description' => $desc,
                    'users_id' => $usr,
                    'image' => $fname
                );
            
                $model = new PostModel();
                $model->insert($data);
                return $this->response->setJSON(['message' => 'Post Inserted Successfully'], 200);
            }else{
                $response = [
                    'errors' => $this->validator->getErrors(),
                    'message' => 'Invalid Inputs'
                ];
                return $this->response->setJSON($response , 409);
              }
          }catch(\Exception $e){ 
          die($e->getMessage());
      } 
      }

      public function editpost($id=null){
        try { 
            $session = session();
            $usr = $session->get('user');
            $users = new PostModel;
            $result = $users->where('id',$id)->where('users_id',$usr)->findAll();
            
            foreach($result as $val){
                $data =[
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
        } catch (\Exception $e) {
            die($e->getMessage());
        }
      }


      public function updatepost()
      {
          try{ 
              $session = session();
              $usr = $session->get('user');
              $rules = [
                  'title' => 'required|max_length[30]',
                  'description' => 'required|max_length[255]',
                  'file' => [
                    'uploaded[file]',
                    'mime_in[file,image/jpg,image/jpeg,image/png,image/gif]',
                    'max_size[file,4096]',
                  ]
              ];
            if($this->validate($rules)){
                $post_id = $this->request->getPost('post_id');
                $title = $this->request->getPost('title');
                $desc = $this->request->getPost('description');
                $file = $this->request->getFile('file');
                $fname = str_replace(' ', '_',$file->getName());
                
                $file->move("../public/assets/uploads",$fname);
                chmod("../public/assets/uploads/".$fname,0777);
                
                $data = array(
                    'id' =>$post_id,
                    'title' => $title,
                    'description' => $desc,
                    'users_id' => $usr,
                    'image' => $fname
                );
            
              $model = new PostModel();
              $model->update($post_id,$data);
              $result = $model->where('id',$post_id)->find();
              foreach($result as $val){
                $data =[
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
             }else{
              $response = [
                  'errors' => $this->validator->getErrors(),
                  'message' => 'Invalid Inputs'
              ];
              return $this->response->setJSON($response , 409);
           }
            }catch(\Exception $e){ 
            die($e->getMessage());
        } 
        }

        public function removepost($id=null)
        {
            
        try { 
            
            $session = session();
            $usr = $session->get('user');
            $users = new PostModel;
            $result = $users->where('id',$id)->where('users_id',$usr)->delete();
            
            if($result){
                $response = [
                    'status' => true,
                    'message' =>'Record has been Removed successfully',
                ];
                return $this->response->setJSON($response, 200);
            }else{
                $response = [
                    'status' => false,
                    'message' =>'Something is wrong',
                ];
                return $this->response->setJSON($response, 401);
            }
            
        } catch (\Exception $e) {
            die($e->getMessage());
        }
        }
    
}
