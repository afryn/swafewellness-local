<?php

namespace App\Controllers;

class ApiController extends BaseController
{
     public function signUp()
    {

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
                 "country_code" => [
                    "label" => "Country Code",
                    "rules" => "required"
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
                // print_r($errors);
                if(!empty($errors)){
                    $msg = 'Fields are required';
                }else{
                   $msg = '';
                }
                return $this->response->setJSON(['status' => 'failure', 'msg' => $msg]);
            }
            
            $checkEmailExist = _getWhere('sw_app_userinfo', ['email'=> $postData['email'], 'status'=> '1', 'trash' => '0']);
            
            // print_r($checkEmailExist);
            
            if($checkEmailExist!= ''){
                return $this->response->setJSON(['status' => 'failure', 'msg' => 'Email Already Exists.']);
            }
            
            $mobileExist = _getWhere('sw_app_userinfo', ['mobile'=> $postData['mobile'], 'status'=> '1', 'trash' => '0']);
            if($mobileExist!= ''){
                return $this->response->setJSON(['status' => 'failure', 'msg' => 'Mobile Number Already Exists.']);
            }
            
         
                
                $token = rand(9999, 1000);
              $message .= "<h2>You are receiving this message to verify your account.</h2>"
    			. "<p>OTP: " . $token
    				. "
    			<p>If You did not make this request kindly ignore!</p>"
    			. "<P class='pj'>
    			<h2>Kind Regard: Swafe Wellness</h2>
    			</p>"
    			. "";
                // print_r($mailsend);
              if(email_send( $postData['email'], 'Swafe Wellness Account Verification One Time Password', $message )){
                  
                   _insert('sw_otp', [
                    'code' => $token,
                    'email' => $postData['email'],
                    'reason' => 'signup',
                    'created_at' => date('Y-m-d H:i:s')
                ]);
                
                  
                    return $this->response->setJSON(['status' => 'success', 'data' => '', 'msg' => 'Please check your mail to verify account']);
              }else{
                  return $this->response->setJSON(['status' => 'failure', 'data' => '', 'msg' => 'Could not send account verification mail. Please check mail and try again.']);
              }
                
            

    }
    	
	public function loginToken($id){
	    
	        
	        $sess_arr = encrypt_decrypt($id, 'decrypt');
	        if($sess_arr){

	            $sess_arr = json_decode(json_encode($sess_arr), true);
	            $sess_arr['ismobile'] = 'yes';
	            
	            session()->set($sess_arr);
	           
	             return redirect()->to(base_url());

	        }else{
	            
	            //echo 'login page redirect';
	           return redirect()->to(base_url());
	        }
	}
	

    
    public function login(){
        // echo 'here'; 
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
                  if(!empty($errors)){
                       $msg = 'Fields are required';
                    }else{
                       $msg = '';
                    }
                
                return $this->response->setJSON(['status' => 'failure', 'msg' => $msg]);
            }
             $userDet = _getWhere('sw_app_userinfo', ['email'=> $postData['email'], 'status' => '1', 'trash' => '0']);
         
             if($userDet == ''){
                return $this->response->setJSON(['success' => 'failure', 'msg' => 'This email is not registered with any account']);
             }
             else if($userDet->password != lock($postData['password'])){
                return $this->response->setJSON(['status' => 'failure', 'msg' => 'Password is not correct.']);
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
                

                $directLogin = 'https://swafewellness.com/login-token/'.encrypt_decrypt($userdata);
                
                 return $this->response->setJSON(['status' => 'success', 'data' => '', 'msg' => 'Login Successfully', 'url' => $directLogin]);
             }
    }
    
    public function forgotPasswordEmail(){
          $postData = $this->request->getPost();
        //   print_r($postData);
          $rules = [
                 "email" => [
                    "label" => "Email",
                    "rules" => "required"
                ],
            
            ];
            
             if (!$this->validate($rules)) {
                $errors = $this->validator->getErrors();
                  if(!empty($errors)){
                       $msg = 'Please enter email';
                    }else{
                       $msg = '';
                    }
                
                return $this->response->setJSON(['status' => 'failure', 'msg' => $msg]);
            }
    
                $token = rand(9999, 1000);
              $message .= "<h2>You are receiving this message to Change Password.</h2>"
    			. "<p>OTP: " . $token
    				. "
    			<p>If You did not make this request kindly ignore!</p>"
    			. "<P class='pj'>
    			<h2>Kind Regard: Swafe Wellness</h2>
    			</p>"
    			. "";
                // print_r($mailsend);
              if(email_send( $postData['email'], 'Swafe Wellness Password Reset OTP', $message )){
                  
                   _insert('sw_otp', [
                    'code' => $token,
                    'email' => $postData['email'],
                    'reason' => 'reset password',
                    'created_at' => date('Y-m-d H:i:s')
                ]);
                
                  
                    return $this->response->setJSON(['status' => 'success', 'data' => '', 'msg' => 'Please check your mail to change password']);
              }else{
                  return $this->response->setJSON(['status' => 'failure', 'data' => '', 'msg' => 'Could not send mail. Please check mail and try again.']);
              }
    }
    
     public function accountVerEmail(){
          $postData = $this->request->getPost();
          
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
                // print_r($errors);
                if(!empty($errors)){
                    $msg = 'Fields are required';
                }else{
                   $msg = '';
                }
                return $this->response->setJSON(['status' => 'failure', 'msg' => $msg]);
            }
          //   print_r($postData);
          $rules = [
                 "email" => [
                    "label" => "Email",
                    "rules" => "required"
                ],
            
            ];
            
             if (!$this->validate($rules)) {
                $errors = $this->validator->getErrors();
                  if(!empty($errors)){
                       $msg = 'Fields are required';
                    }else{
                       $msg = '';
                    }
                
                return $this->response->setJSON(['status' => 'failure', 'msg' => $msg]);
            }
    
                $token = rand(9999, 1000);
              $message .= "<h2>You are receiving this message to Verify Account.</h2>"
    			. "<p>OTP: " . $token
    				. "
    			<p>If You did not make this request kindly ignore!</p>"
    			. "<P class='pj'>
    			<h2>Kind Regard: Swafe Wellness</h2>
    			</p>"
    			. "";
                // print_r($mailsend);
              if(email_send( $postData['email'], 'Swafe Wellness Account Verification', $message )){
                  
                   _insert('sw_otp', [
                    'code' => $token,
                    'email' => $postData['email'],
                    'reason' => 'signup',
                    'created_at' => date('Y-m-d H:i:s')
                ]);
                
                  
                    return $this->response->setJSON(['status' => 'success', 'data' => '', 'msg' => 'Please check your mail to veriify account']);
              }else{
                  return $this->response->setJSON(['status' => 'failure', 'data' => '', 'msg' => 'Could not send mail. Please check mail and try again.']);
              }
    }
    
    
    public function changePassword(){
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
                 "cpassword" => [
                    "label" => "Confirm Password",
                    "rules" => "required"
                ],
                  "otp" => [
                    "label" => "OTP",
                    "rules" => "required"
                ],
            
            ];
            
             if (!$this->validate($rules)) {
                $errors = $this->validator->getErrors();
                  if(!empty($errors)){
                       $msg = 'Field are required';
                    }else{
                       $msg = '';
                    }
                
                return $this->response->setJSON(['status' => 'failure', 'msg' => $msg]);
            }
        
        
        	$tomail = $postData['email'];
			$reset_otp = $postData['otp'];
			$reset_password = $postData['password'];
			
			
            // $getUserData = $this->Db_model->select_data('*','sw_app_userinfo', $where_data);
            
               $getUserData = _getWhere('sw_app_userinfo', ['email' => $postData['email'], 'trash' => '0']);
            //   print_r($getUserData);
			if($getUserData){
			    
			     //_insert('sw_otp', [
        //             'code' => $reset_otp,
        //             'email' => $postData['email'],
        //             'reason' => 'reset password',
        //             'created_at' => date('Y-m-d H:i:s')
        //         ]);
			  
	            $getTempOtp = _getWhere('sw_otp', ['email' => $tomail, 'code' => $reset_otp, 'reason' =>'reset password']);
	            
                // print_r($getTempOtp);
	            
	            if($getTempOtp){
                
            		_updateWhere( 'sw_app_userinfo', ['email' => $tomail], [
            			'password' => lock($reset_password),
            		] );
	                
	             
				         return $this->response->setJSON(['status' => 'success', 'data' => '', 'msg' => 'Your password has been changed successfully.']);
	                
	            }else{
	                   return $this->response->setJSON(['status' => 'failure', 'data' => '', 'msg' => 'invalid otp']);
	            }
			}else{
			
				    return $this->response->setJSON(['status' => 'failure', 'data' => '', 'msg' => 'Mail not exist']);
			}
			return $this->response->setJSON($message);
    }
    
    public function verification(){
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
                 "country_code" => [
                    "label" => "Country Code",
                    "rules" => "required"
                ],
                 "otp" => [
                    "label" => "OTP",
                    "rules" => "required"
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
                // print_r($errors);
                if(!empty($errors)){
                    $msg = 'Fields are required';
                }else{
                   $msg = '';
                }
                return $this->response->setJSON(['status' => 'failure', 'msg' => $msg]);
            }
            if (isLastOtpValid_v2($postData['email'], 15, $postData['otp'])) {

                _updateWhere( 'sw_otp', ['email' => $postData['email'], 'code' => $postData['otp']], [
                    'is_used' => 'yes'
                ] );
                $isInsert = _insert('sw_app_userinfo', [
                    'firstname' => $postData['firstname'] ?? null,
                    'lastname' => $postData['lastname'] ?? null,
                    'email' =>$postData['email'] ?? null,
                    'mobile' => $postData['mobile'] ?? null,
                    'country_code' => $postData['country_code'] ?? null,
                    'password' => lock($postData['password']),
                    'date' => date('Y-m-d'),
                    'time' => date('H:i:s'),
                    'date_time' => date('Y-m-d H:i:s'),
             ]);
            
               $userId = _getLastRow('sw_app_userinfo')->id;
                    
            if ($isInsert) {
                // login user
                $userdata = [
                    'login' => true,
                    'id' => $userId,
                    'firstname' => $postData['firstname'],
                    'lastname' => $postData['lastname'],
                    'email' => $postData['email'],
                    'mobile' => $postData['mobile'],
                    'country_code' => $postData['country_code'] ?? null,
                ];
            
                    $directLogin = 'https://swafewellness.com/login-token/'.encrypt_decrypt($userdata);
                    

                return $this->response->setJSON(['status' => 'success', 'data' => '', 'msg' => 'Account Created Successfully', 'url' => $directLogin]);
            } else {
                return $this->response->setJSON(['status' => 'failure', 'data' => '', 'msg' => 'Could Not Create Account.', 'url' => '']);
            }

            } else {
                return $this->response->setJSON(['status' => 'failure', 'msg' => 'You entered expired or invalid Email OTP code.', 'errors' => null, 'result' => null]);
            }
          
            
    }
}