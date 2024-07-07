<?php

namespace App\Controllers;

class Login extends BaseController
{

    protected $db;
    public $session;

    public function __construct()
    {   
        $this->db = \Config\Database::connect();
        $this->validation = \Config\Services::validation();
        $this->session = session();
    }

    public function index()
    {
        $roles = _getWhere('sw_roles_type', ['status' => 'active'], 'yes');
        return view('dashboard/login', compact('roles'));
        return view('dashboard/login');
    }

    public function login()
    {

        $details = $this->db->table('admin')->orderBy('id', 'desc')->get()->getResult();

        $inputEmail = $this->request->getPost('username');
        $inputPass =  $this->request->getPost('password');
        
        $users_tbl = _getWhere('sw_roles', ['email' => $inputEmail, 'trash' => '0']);
     
    
        if($users_tbl){
             if($users_tbl->status != 'active'){
                $data['msg'] = 'Account is inactive. Please contact admin.';
                $data['status'] = false;
            }
            else if ($users_tbl->trash == '1'){
                $data['msg'] = 'User not exist';
                $data['status'] = false;
            }
            else if(lock($inputPass) == $users_tbl->password){

            $users_tbl->user_type_id = dynamicLock($users_tbl->role_id);
            unset($users_tbl->password);
            unset($users_tbl->role_id);
            $users_tbl->login_platform = 'web';
            $users_tbl->last_login_token = bin2hex( openssl_random_pseudo_bytes( 64 ) );
            $users_tbl->login_ip = $this->request->getIPAddress();

            session()->set( json_decode(json_encode($users_tbl), true) );
            // return redirect()->route('dashboard.index')->withInput()->with( 'flash_array', ['success' => 'Login successful'] );
            $data['msg'] = 'Login successful';
            $data['status'] = true;
            }
            else{
            // return redirect()->back()->withInput()->with( 'flash_array', ['error' => 'These credentials do not match our records.'] );
            $data['msg'] = 'These credentials do not match our records.';
            $data['status'] = false;
            }
        }
        else{
            $data['msg'] = 'These credentials do not match our records.';
            $data['status'] = false;
            // return redirect()->back()->withInput()->with( 'flash_array', ['error' => 'These credentials do not match our records.'] );
        }
        echo json_encode($data);
    }   

    public function logout(){
       
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
     public function userlogout(){
        // print_r($_SESSION);
        // die();
        if(isset($_SESSION['ismobile'])  && $_SESSION['ismobile'] == 'yes'){
            session()->destroy();
        // return redirect()->to(base_url(route_to('user.login')));
        }else{
            session()->destroy();
        return redirect()->to(base_url(route_to('user.login')));
        }
        
    }
    
    public function userLogin(){
        if ($this->request->getMethod() === 'post') {
            $postData = $this->request->getPost();
            // print_r($postData);
            $rules = [
                 "email" => [
                    "label" => "Email",
                    "rules" => "required"
                ],
                 "password" => [
                    "label" => "Password",
                    "rules" => "required"
                ],
            ];
            
             if (!$this->validate($rules)) {
                $errors = $this->validator->getErrors();
                return $this->response->setJSON(['success' => false, 'msg' => reset($errors), 'errors' => $errors, 'data' => null]);
            }
             $userDet = _getWhere('sw_app_userinfo', ['email'=> $postData['email'], 'status' => '1', 'trash' => '0']);
          
             if($userDet == ''){
                return $this->response->setJSON(['success' => false, 'msg' => 'This email is not registered with any account']);
             }
             else if($userDet->password != lock($postData['password'])){
                return $this->response->setJSON(['success' => false, 'msg' => 'Password is not correct.']);
             }
             else{
                 // set session 
                 $userdata = [
                    'login' => true,
                    'id' => $userDet->id,
                    'firstname' => $userDet->firstname,
                    'lastname' => $userDet->lastname,
                    'email' => $userDet->email,
                    'mobile' => $userDet->mobile,
                ];
                session()->set($userdata);
                isset($_SESSION['url']) ? $url = $_SESSION['url']: $url = '';
                return $this->response->setJSON(['success' => true, 'msg' => 'Logged in successfully.', 'url' => $url]);

             }
            
            
        }
        return view('front/login');
    }
    
    public function userRegister(){
        
        if ($this->request->getMethod() === 'post') {
             $postData = $this->request->getPost();
             
             $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@!%*?&])[A-Za-z\d$@!%*?&]{8,255}$/';
             $rules = [
                 "firstname" => [
                    "label" => "First Name",
                    "rules" => "required|min_length[3]"
                ],
                
                "email" => [
                    "label" => "Email",
                    "rules" => "required|valid_email"
                ],
                "mobile" => [
                    "label" => "Mobile",
                    "rules" => "required|numeric|min_length[7]|max_length[15]"
                ],
                 "password" => [
                    'label' => 'Password',
                    'rules' => [
                        'required',
                        'regex_match[' . $pattern . ']'
                    ],
                    'errors' => [
                        'required' => 'The password field is required',
                        'regex_match' => 'The password field must contain at least <ul><li>one uppercase letter</li> <li>one lowercase letter</li> <li>one special character</li> <li>one number</li> <li>between 8 to 200 characters length</li> </ul>',
                    ],
                ],
                 "cpassword" => [
                    "label" => "Confirm Password",
                    "rules" => "required|matches[password]"
                ],
                
                
            ];

            if (!$this->validate($rules)) {
                $errors = $this->validator->getErrors();
                return $this->response->setJSON(['success' => false, 'msg' => reset($errors), 'errors' => $errors, 'data' => null]);
            }
            
            $checkEmailExist = _getWhere('sw_app_userinfo', ['email'=> $postData['email'], 'status'=> '1', 'trash' => '0']);
            if($checkEmailExist!= ''){
                return $this->response->setJSON(['success' => false, 'msg' => 'Email Already Exists.']);
            }
            
            $mobileExist = _getWhere('sw_app_userinfo', ['mobile'=> $postData['mobile'], 'status'=> '1', 'trash' => '0']);
            if($mobileExist!= ''){
                return $this->response->setJSON(['success' => false, 'msg' => 'Mobile Number Already Exists.']);
            }
            
             $isInsert = _insert('sw_app_userinfo', [
                        'firstname' => $postData['firstname'] ?? null,
                        'lastname' => $postData['lastname'] ?? null,
                        'email' =>$postData['email'] ?? null,
                        'mobile' => $postData['mobile'] ?? null,
                        'password' => lock($postData['password']),
                        'date' => date('Y-m-d'),
                        'time' => date('H:i:s'),
                        'date_time' => date('Y-m-d H:i:s'),
                        
                    ]);

            $userId = _getLastRow('sw_app_userinfo')->id;
                    
            if ($isInsert) {
                //login user
                $userdata = [
                    'login' => true,
                    'id' => $userId,
                    'firstname' => $postData['firstname'],
                    'lastname' => $postData['lastname'],
                    'email' => $postData['email'],
                    'mobile' => $postData['mobile'],
                ];
                session()->set($userdata);
                isset($_SESSION['url']) ? $url = $_SESSION['url']: $url = '';

                return $this->response->setJSON(['success' => true, 'data' => '', 'msg' => 'Account Created Successfully', 'url'=> $url]);
            } else {
                return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Could Not Create Account.', 'url' => '']);
            }
            
        }
        return view('front/register');
    }


}
