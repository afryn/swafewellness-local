<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Admin extends BaseController
{
    public $db;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->db = \Config\Database::connect();
        $session = \Config\Services::session();

    }

    public function index()
    {
        
      $data['totalEarnings'] = $this->db->query("SELECT SUM(amount) as total_amount FROM sw_online_transaction where payment_status = 'Completed'")->getRow()->total_amount;
      
      $data['activeCenters'] = _getWhere('sw_centers', ['status' => '1', 'trash' => '0'], 'yes');
      
      $data['activeTrainers'] = _getWhere('sw_trainers', ['status' => '1', 'trash' => '0'], 'yes');
      
      $data['totalAppointments'] = _getWhere('sw_appointments', ['payment_status' => 'Completed'], 'yes');
      
      $data['activeProgrammes'] = _getWhere('sw_packages', ['status' => '1', 'trash' => '0'], 'yes');
      
      $data['appInquiries'] = _getWhere('sw_appointment_query', ['service !=' => '0', 'trash' => '0'], 'yes');
      
      $data['inquireis'] =  _getWhere('sw_appointment_query', ['service' => '0', 'trash' => '0'], 'yes');
        
        return view('dashboard/dashboard', $data);
    }
      public function fetchChartData(){
          
          $query = $this->db->query("SELECT DATE(date) as transaction_date, SUM(amount) as total_amount 
                           FROM sw_online_transaction where payment_status = 'Completed'
                           GROUP BY DATE(date)");

          $results = $query->getResult();
     
        echo json_encode($results);
    }
    
    public function totalRevenue(){
         $data['totalPayments'] = _getWhere('sw_online_transaction',['id !=' => 0 ], 'yes');
         
           return view('dashboard/total-revenue',$data );
    }
    
    public function totalEarnings(){
         $data['totalPayments'] = _getWhere('sw_online_transaction',['payment_status' => 'Completed'], 'yes');
         return view('dashboard/total-revenue',$data );
    }
    
    public function messages()
    {
        _registerFunction(['function_name' => 'inquiries_list', 'alias' => 'Users Inquiries', 'category' => 'Inquiries']);

        if (
            !authChecker('admin', [
                'inquiries_list'
            ])
        ) {
            return $this->response->setJSON(['success' => 401, 'msg' => ACCESS_DENIED_MESSAGE]);
        }
        $data['inquiries'] = _getWhere('sw_appointment_query', ['trash' => '0', 'service' => 0], 'yes');

        $data['type'] = 'messages';
        return view('dashboard/users/inquiries', $data);
    }

    public function appInquiries(){
        
        _registerFunction(['function_name' => 'inquiries_list', 'alias' => 'Users Inquiries', 'category' => 'Inquiries']);

        if (
            !authChecker('admin', [
                'inquiries_list'
            ])
        ) {
            return $this->response->setJSON(['success' => 401, 'msg' => ACCESS_DENIED_MESSAGE]);
        }
        $data['inquiries'] = _getWhere('sw_appointment_query', ['service !=' => '0', 'trash' => '0'], 'yes');

        $data['type'] = 'appQuwery';
        return view('dashboard/users/inquiries', $data);
    }
  
    public function addPackages() //for edit package too
    {
        _registerFunction(['function_name' => 'addNewPackages', 'alias' => 'Add Programmes', 'category' => 'Programmes']);
        _registerFunction(['function_name' => 'packge_edit', 'alias' => 'Programmes Edit', 'category' => 'Programmes']);

        if (
            !authChecker('admin', [
                'addNewPackages',
                'packge_edit'
            ])
        ) {
            return redirect()->route('dashboard.index')->withInput()->with('flash_array', ['access_denied' => 'access_denied']);
        }

        if ($this->request->getMethod() === 'post') {

            $postData = $this->request->getPost();
            // print_r( $postData);
            $pkg = lock($postData['pkg'], 'decrypt');
            $rules = [
                "package_name" => [
                    "label" => "Programme name",
                    "rules" => "required|trim"
                ],
                "duration_days" => [
                    "label" => "Duration Days",
                    "rules" => "required|trim|numeric"
                ],
                "duration_nights" => [
                    "label" => "Duration Nights",
                    "rules" => "required|trim|numeric"
                ],
                "short_desc" => [
                    "label" => "Description",
                    "rules" => "required|trim"
                ],
            ];

            if ($pkg == '') { // in case of add new pckage
                $rules['image'] = [
                    'label' => 'Image',
                    'rules' => 'uploaded[image]|mime_in[image,image/png,image/jpeg]|max_dims[image,370,400]',
                    'errors' => [
                        'uploaded' => 'Please select an image to upload',
                        'mime_in' => 'The image must be a PNG or JPEG file',
                        // 'max_dims' => 'The profile image dimensions cannot exceed 2048x2048 pixels',
                    ],
                ];
            } else {
                $rules['image'] = [
                    'label' => 'Image',
                    'rules' => 'permit_empty|uploaded[image]|mime_in[image,image/png,image/jpeg]|max_dims[image,370,400]',
                    'errors' => [
                        'uploaded' => 'Please select an image to upload',
                        'mime_in' => 'The image must be a PNG or JPEG file',
                        'max_dims' => 'The image dimensions cannot exceed 370x400 pixels',
                    ],
                ];
            }

            if (!$this->validate($rules)) {
                $errors = $this->validator->getErrors();
                return $this->response->setJSON(['success' => false, 'msg' => reset($errors), 'errors' => $errors, 'data' => null]);
            }

            // validated

            if (!empty($_FILES["image"]["name"])) {

                $temp = explode(".", $_FILES["image"]["name"]);
                $newfilename = round(microtime(true)) . '.' . end($temp);

                move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/packages/" . $newfilename);
            } else {
                $newfilename = null;
            }

            if ($pkg == '') {   
                $existpckg = _getWhere('sw_packages', ['package_name' => $postData['package_name'],'status' => '1', 'trash' => '0']);

                if ($existpckg == '') {
                    $str = strtolower($postData['package_name']); 
                    $slug = preg_replace('/\s+/', '-', $str); 
                      
                      
                    $isInsert = _insert('sw_packages', [
                        'slug' => $slug,
                        'package_name' => $postData['package_name'],
                        'package_duration' => $postData['duration_days'] . ':' . $postData['duration_nights'],
                        'specialization' => (isset($postData['specialize']) && $postData['specialize'] == 'Yes') ? $postData['specialize'] : 'No',
                        'description' => $this->db->escapeString($postData['short_desc']),
                        'image' => $newfilename,
                        'date' => date('Y-m-d'),
                        'time' => date('H:i:s'),
                    ]);
                    if ($isInsert) {
                        return $this->response->setJSON(['success' => true, 'data' => '', 'msg' => 'Package added successfully.']);
                    } else {
                        return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Package not added.']);
                    }
                }
                else{
                    return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Package Name Already Exist.']);
                }



            } else {
                if ($newfilename == '') {
                    $isUpdate = _updateWhere('sw_packages', ['id' => $pkg], [
                        'package_name' => $postData['package_name'],
                        'package_duration' => $postData['duration_days'] . ':' . $postData['duration_nights'],
                         'specialization' => (isset($postData['specialize']) && $postData['specialize'] == 'Yes') ? $postData['specialize'] : 'No',
                        'description' => $postData['short_desc'],
                        'date' => date('Y-m-d'),
                        'time' => date('H:i:s'),
                    ]);
                } else {
                    $isUpdate = _updateWhere('sw_packages', ['id' => $pkg], [
                        'package_name' => $postData['package_name'],
                        'package_duration' => $postData['duration_days'] . ':' . $postData['duration_nights'],
                         'specialization' => (isset($postData['specialize']) && $postData['specialize'] == 'Yes') ? $postData['specialize'] : 'No',
                        'description' => $postData['short_desc'],
                        'image' => $newfilename,
                        'date' => date('Y-m-d'),
                        'time' => date('H:i:s'),
                    ]);
                }


                if ($isUpdate) {
                    return $this->response->setJSON(['success' => true, 'data' => '', 'msg' => 'Package updated successfully.']);
                } else {
                    return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Package not updated.']);
                }
            }



        } else {
            return view('dashboard/products/add-package');
        }
    }

    public function packagesList()
    {
        _registerFunction(['function_name' => 'package_status_toggle', 'alias' => 'Programmes Status Toggle', 'category' => 'Programmes']);
        _registerFunction(['function_name' => 'packge_remove', 'alias' => 'Programmes Remove', 'category' => 'Programmes']);
        _registerFunction(['function_name' => 'packge_edit', 'alias' => 'Programmes Edit', 'category' => 'Programmes']);
        _registerFunction(['function_name' => 'packge_list', 'alias' => 'Programmes List', 'category' => 'Programmes']);

        if (
            !authChecker('admin', [
                'packge_list',
                'addNewPackages'
            ])
        ) {
            return $this->response->setJSON(['success' => 401, 'msg' => ACCESS_DENIED_MESSAGE]);
        }
        $data['packages'] = _getWhere('sw_packages', ['trash' => 0], 'yes');
        // print_r($data['packages']);die();

        return view('dashboard/products/package-list', $data);
    }

    public function changePkgStatus()
    {
        _registerFunction(['function_name' => 'package_status_toggle', 'alias' => 'Programmes Status Toggle', 'category' => 'Programmes']);

        if (
            !authChecker('admin', [
                'package_status_toggle',
            ])
        ) {
            return $this->response->setJSON(['success' => 401, 'msg' => ACCESS_DENIED_MESSAGE]);
        }

        $pkgId = lock($this->request->getPost('id'), 'decrypt');

        $status = _getWhere('sw_packages', ['id' => $pkgId])->status;
        ($status == 1) ? $status = 0 : $status = 1;

        $query = _updateWhere('sw_packages', ['id' => $pkgId], ['status' => $status]);

        if ($query) {
            return $this->response->setJSON(['success' => true, 'data' => '', 'msg' => 'Status changed successfully.', 'updatedStatus' => $status]);
        } else {
            return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Could not change.', 'updatedStatus' => $status]);

        }
    }

    public function packageEdit($pkgId)
    {

        _registerFunction(['function_name' => 'packge_edit', 'alias' => 'Programmes Edit', 'category' => 'Programmes']);

        if (
            !authChecker('admin', [
                'packge_edit',
            ])
        ) {
            return redirect()->route('admin.packages-list');
        }

        $pkgId = lock($pkgId, 'decrypt');

        $data['pkg_data'] = _getWhere('sw_packages', ['id' => $pkgId]);


        return view('dashboard/products/add-package', $data);

    }

    public function trashPackage()
    {

        _registerFunction(['function_name' => 'packge_remove', 'alias' => 'Programmes Remove', 'category' => 'Programmes']);

        if (
            !authChecker('admin', [
                'packge_remove',
            ])
        ) {
            return $this->response->setJSON(['success' => 401, 'msg' => ACCESS_DENIED_MESSAGE]);
        }

        $pkgId = lock($this->request->getPost('id'), 'decrypt');

        $query = _updateWhere('sw_packages', ['id' => $pkgId], ['trash' => 1]);

        if ($query) {
            return $this->response->setJSON(['success' => true, 'data' => '', 'msg' => 'Package trashed successfully.']);
        } else {
            return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Could not trash package.']);

        }
    }

    public function addTrainer()
    {
        //         echo 'ST' . rand(9999999, 1000000) . 'ER' ;
        // die();

        _registerFunction(['function_name' => 'trainer_add', 'alias' => 'Add Trainer', 'category' => 'Trainers']);
        _registerFunction(['function_name' => 'trainer_edit', 'alias' => 'Edit Trainer', 'category' => 'Trainers']);

        if (
            !authChecker('admin', [
                'trainer_add',
                'trainer_edit'
            ])
        ) {
            return redirect()->route('dashboard.index')->withInput()->with('flash_array', ['access_denied' => 'access_denied']);
        }

        $postData = $this->request->getPost();

        // $mailExist = _getWhere('sw_roles' , ['email' => $postData['trainer_email']]);

        if ($this->request->getMethod() === 'post') {

            $trainer = lock($postData['trainer'], 'decrypt');
            $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@!%*?&])[A-Za-z\d$@!%*?&]{8,255}$/';

            $rules = [
                "trainer_name" => [
                    "label" => "Trainer name",
                    "rules" => "required|trim"
                ],
                "trainer_email" => [
                    "label" => "Email",
                    "rules" => "required|valid_email|trim"
                ],
                "mobile" => [
                    "label" => "Mobile",
                    "rules" => "required|trim|min_length[7]|max_length[15]"
                ],
                "services" => [
                    "label" => "Services",
                    "rules" => "required"
                ],
                "days_availability" => [
                    "label" => "Days Availability",
                    "rules" => "required"
                ],
                "avlblty_time_to" => [
                    "label" => "To Time",
                    "rules" => "required|trim"
                ],
                "avlblty_time_from" => [
                    "label" => "From Time",
                    "rules" => "required|trim"
                ],
              

            ];

            if ($trainer == '') { // in case of add new pckage
                $rules['image'] = [
                    'label' => 'Image',
                    'rules' => 'uploaded[image]|mime_in[image,image/jpg,image/jpeg,image/png]|max_dims[image,500,500]',
                    'errors' => [
                        'uploaded' => 'Please select an image to upload',
                        // 'max_size' => 'The profile image file size cannot exceed 5MB',
                        'mime_in' => 'The profile image must be a JPG or PNG file',
                        'max_dims' => 'The profile image dimensions cannot exceed 500x450 pixels',
                    ],
                ];
                $rules['new_password'] = [
                    'label' => 'Password',
                    'rules' => [
                        'required',
                        'regex_match[' . $pattern . ']'
                    ],
                    'errors' => [
                        'required' => 'The password field is required',
                        'regex_match' => 'The password field must contain at least <ul><li>one uppercase letter</li> <li>one lowercase letter</li> <li>one special character</li> <li>one number</li> <li>between 8 to 200 characters length</li> </ul>',
                    ],
                ];
            } else {
                $rules['image'] = [
                    'label' => 'Image',
                    'rules' => 'permit_empty|uploaded[image]|mime_in[image,image/jpg,image/jpeg,image/png]|max_dims[image,500,500]',
                    'errors' => [
                        'uploaded' => 'Please select an image to upload',
                        // 'max_size' => 'The profile image file size cannot exceed 5MB',
                        'mime_in' => 'The profile image must be a JPG or PNG file',
                        'max_dims' => 'The profile image dimensions cannot exceed 500x450 pixels',
                    ],
                ];
            }

            if (!$this->validate($rules)) {
                $errors = $this->validator->getErrors();
                return $this->response->setJSON(['success' => false, 'msg' => reset($errors), 'errors' => $errors, 'data' => null]);
            }

            // validated

            if (!empty($_FILES["image"]["name"])) {

                $temp = explode(".", $_FILES["image"]["name"]);
                $newfilename = round(microtime(true)) . '.' . end($temp);

                move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/trainers/" . $newfilename);
            } else {
                $newfilename = null;
            }

            if ($trainer == '') {

                $mobileExist = _getWhere('sw_roles', ['primary_phone_no' => $postData['mobile'], 'trash' => '0']);
                $emailExist = _getWhere('sw_roles', ['email' => $postData['trainer_email'], 'trash' => '0']);

                if ($mobileExist != '') {
                    return $this->response->setJSON(['success' => false, 'msg' => 'Phone Already Exists', 'errors' => '', 'data' => null]);
                } else if ($emailExist != '') {
                    return $this->response->setJSON(['success' => false, 'msg' => 'Email Already Exists', 'errors' => '', 'data' => null]);
                }

                $isInsert2 = _insert('sw_roles', [
                    'first_name ' => $postData['trainer_name'],
                    'email' => $postData['trainer_email'],
                    'role_id' => '19',
                    'password' => lock($postData['new_password']),
                    'status' => 'active',
                    'profile_photo' => $newfilename,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

                $lastRec = _getDESC('sw_roles');

                $isInsert = _insert('sw_trainers', [
                    'roles_tbl_id' => $lastRec->id,
                    'role_id' => '19',
                    'trainer_name' => $postData['trainer_name'],
                    'token' => 'ST' . rand(9999999, 1000000) . 'ER',
                    'email' => $postData['trainer_email'],
                    'mobile' => $postData['mobile'],
                    'services_offered' => implode(',', $postData['services']),
                    'days_availability' => implode(',', $postData['days_availability']),
                    'description' => $this->db->escapeString($postData['short_desc']),
                    'image' => $newfilename,
                    'from_time' => $postData['avlblty_time_from'],
                    'to_time' => $postData['avlblty_time_to'],
                ]);
                
                $lasAdded = _getLastRow('sw_trainers');
                
                for ($i=0; $i < count($postData['services']); $i++) {
                    
                      $insertPricing = _insert('sw_pricing', [
                            'type' => 'trainer',
                            'type_id' => $lasAdded->token,
                            'progrm_id' => $postData['services'][$i],
                            'amount' => $postData['prices'][$i],
                            'ins_date' => date('Y-m-d'),
                            'ins_time' => date('H:m:i'),
                            'date_time' => date('Y-m-d H:m:i'),
                      ]);
                }



                if ($isInsert && $isInsert2) {
                    return $this->response->setJSON(['success' => true, 'data' => '', 'msg' => 'Trainer added successfully.']);
                } else {
                    return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Trainer not added.']);
                }
            } else {
                
                
                  // PRICING
                $trainerToken = _getWhere('sw_trainers',['id' => $trainer])->token;
                for ($i=0; $i < count($postData['services']); $i++) {
                    
                    $pricingExist = _getWhere('sw_pricing', 
                    ['progrm_id' => $postData['services'][$i],
                    'type_id' =>  $trainerToken, 
                    'type' => 'trainer',
                    'progrm_id' => $postData['services'][$i]
                    ]);
                    
                    if($pricingExist == ''){ //if price does not exist
                        
                        $insertPricing = _insert('sw_pricing', [
                            'type' => 'trainer',
                            'type_id' => $trainerToken,
                            'progrm_id' => $postData['services'][$i],
                            'amount' => $postData['price_' . $postData['services'][$i] ],
                            'ins_date' => date('Y-m-d'),
                            'ins_time' => date('H:m:i'),
                            'date_time' => date('Y-m-d H:m:i'),
                      ]);
                        
                    }
                    else{
                         $insertPricing = _updateWhere('sw_pricing',['id' => $pricingExist->id], [
                            'amount' => $postData['price_' . $postData['services'][$i] ],
                            'updated_at' => date('Y-m-d H:m:i'),
                      ]);
                    }
                    
                }

                
                

                $currentData = _getWhere('sw_trainers', ['id' => $trainer]);

                $mobileExist = _getWhere('sw_roles', ['primary_phone_no' => $postData['mobile'], 'trash' => '0', 'id != ' => $currentData->roles_tbl_id]);
                $emailExist = _getWhere('sw_roles', ['email' => $postData['trainer_email'], 'trash' => '0', 'id != ' => $currentData->roles_tbl_id]);

                if ($mobileExist != '') {
                    return $this->response->setJSON(['success' => false, 'msg' => 'Phone Already Exists', 'errors' => '', 'data' => null]);
                } else if ($emailExist != '') {
                    return $this->response->setJSON(['success' => false, 'msg' => 'Email Already Exists', 'errors' => '', 'data' => null]);
                }

                if ($newfilename == '') {
                    $isUpdate = _updateWhere('sw_trainers', ['id' => $trainer], [
                        'trainer_name' => $postData['trainer_name'],
                        'email' => $postData['trainer_email'],
                        'mobile' => $postData['mobile'],
                        'services_offered' => implode(',', $postData['services']),
                        'days_availability' => implode(',', $postData['days_availability']),
                        'description' => $this->db->escapeString($postData['short_desc']),
                        'from_time' => $postData['avlblty_time_from'],
                        'to_time' => $postData['avlblty_time_to'],
                    ]);


                    $isUpdate2 = _updateWhere('sw_roles', ['id' => $currentData->roles_tbl_id], [
                        'first_name ' => $postData['trainer_name'],
                        'password' => lock($postData['new_password']),
                        'email' => $postData['trainer_email'],
                        'updated_at' => date('Y-m-d'),
                    ]);

                } else {
                    $isUpdate = _updateWhere('sw_trainers', ['id' => $trainer], [
                        'trainer_name' => $postData['trainer_name'],
                        'email' => $postData['trainer_email'],
                        'mobile' => $postData['mobile'],
                        'services_offered' => implode(',', $postData['services']),
                        'days_availability' => implode(',', $postData['days_availability']),
                        'image' => $newfilename,
                        'description' => $this->db->escapeString($postData['short_desc']),
                        'from_time' => $postData['avlblty_time_from'],
                        'to_time' => $postData['avlblty_time_to'],
                    ]);

                    $isUpdate2 = _updateWhere('sw_roles', ['id' => $currentData->roles_tbl_id], [
                        'first_name ' => $postData['trainer_name'],
                        'email' => $postData['trainer_email'],
                        'password' => lock($postData['new_password']),
                        'profile_photo' => $newfilename,
                        'updated_at' => $postData['avlblty_time_from'],
                    ]);

                }


                if ($isUpdate && $isUpdate2) {
                    return $this->response->setJSON(['success' => true, 'datf' => '', 'msg' => 'Trainer updated successfully.']);
                } else {
                    return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Trainer not updated.']);
                }
            }



        } else {
            $data['services'] = _getWhere('sw_packages', ['trash' => 0, 'status' => 1], 'yes');

            $data['weekDays'] = [
                ['id' => 0, 'day' => 'Monday'],
                ['id' => 1, 'day' => 'Tuesday'],
                ['id' => 2, 'day' => 'Wednesday'],
                ['id' => 3, 'day' => 'Thursday'],
                ['id' => 4, 'day' => 'Friday'],
                ['id' => 5, 'day' => 'Saturday'],
                ['id' => 6, 'day' => 'Sunday'],
            ];


            return view('dashboard/trainer/add-trainer', $data);
        }

    }
    public function trainerList()
    {
        
        _registerFunction(['function_name' => 'trainer_list', 'alias' => 'Trainers List', 'category' => 'Trainers']);
        _registerFunction(['function_name' => 'trainer_remove', 'alias' => 'Remove Trainer', 'category' => 'Trainers']);
        _registerFunction(['function_name' => 'trainer_edit', 'alias' => 'Edit Trainer', 'category' => 'Trainers']);
        _registerFunction(['function_name' => 'trainer_status_toggle', 'alias' => 'Toggle Trainer Status', 'category' => 'Trainers']);
        if (
            !authChecker('admin', [
                'trainer_list',
                'trainer_add'
            ])
        ) {
            return $this->response->setJSON(['success' => 401, 'msg' => ACCESS_DENIED_MESSAGE]);
        }
        $data['trainers'] = _getWhere('sw_trainers', ['trash' => 0], 'yes');

        return view('dashboard/trainer/trainers-list', $data);
    }

    public function changeTrainerStatus()
    {
        _registerFunction(['function_name' => 'trainer_status_toggle', 'alias' => 'Toggle Trainer Status', 'category' => 'Trainers']);
        _registerFunction(['function_name' => 'trainer_remove', 'alias' => 'Remove Trainer', 'category' => 'Trainers']);

        if (
            !authChecker('admin', [
                'trainer_status_toggle',
                'trainer_remove',
            ])
        ) {
            return $this->response->setJSON(['success' => 401, 'msg' => ACCESS_DENIED_MESSAGE]);
        }

        $trnrId = lock($this->request->getPost('id'), 'decrypt');

        if ($this->request->getPost('action') == 'trash') {

            $query = _updateWhere('sw_trainers', ['id' => $trnrId], ['trash' => 1]);
            $trainerData = _getWhere('sw_trainers', ['id' => $trnrId]);

            $query = _updateWhere('sw_roles', ['id' => $trainerData->roles_tbl_id], ['trash' => 1, 'status'=>'inactive']);

            if ($query) {
                return $this->response->setJSON(['success' => true, 'data' => '', 'msg' => 'Trashed successfully.']);
            } else {
                return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Could not trash.']);

            }
        } elseif ($this->request->getPost('action') == 'chngeStts') {


            $status = _getWhere('sw_trainers', ['id' => $trnrId])->status;
            ($status == 1) ? $status1 = 0 : $status1 = 1;
            ($status == 1) ? $status2 = 'inactive': $status2 = 'active';

            $query = _updateWhere('sw_trainers', ['id' => $trnrId], ['status' => $status1]);

            $trainerData = _getWhere('sw_trainers', ['id' => $trnrId]);

            $query = _updateWhere('sw_roles', ['id' => $trainerData->roles_tbl_id], ['status'=>$status2]);

            if ($query) {
                return $this->response->setJSON(['success' => true, 'data' => '', 'msg' => 'Status changed successfully.']);
            } else {
                return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Could not change status.']);

            }
        }
    }



    public function editTrainer($trainerId)
    {

        $tId = lock($trainerId, 'decrypt');
        $data['services'] = _getWhere('sw_packages', ['status' => 1, 'trash' => 0], 'yes');
        $data['weekDays'] = [
            ['id' => 0, 'day' => 'Monday'],
            ['id' => 1, 'day' => 'Tuesday'],
            ['id' => 2, 'day' => 'Wednesday'],
            ['id' => 3, 'day' => 'Thursday'],
            ['id' => 4, 'day' => 'Friday'],
            ['id' => 5, 'day' => 'Saturday'],
            ['id' => 6, 'day' => 'Sunday'],
        ];
        // print_r($data['services']);
        $data['trainer_data'] = _getWhere('sw_trainers', ['id' => $tId]);
        $data['role_data'] = _getWhere('sw_roles', ['id' => $data['trainer_data']->roles_tbl_id]);

        return view('dashboard/trainer/add-trainer', $data);
    }
}