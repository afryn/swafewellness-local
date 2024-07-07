<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Centers extends BaseController
{
    public $db;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->db = \Config\Database::connect();
        $session = \Config\Services::session();

    }
    public function addCenter() 
    {
        _registerFunction(['function_name' => 'center_add', 'alias' => 'Add Center', 'category' => 'Centers']);
        _registerFunction(['function_name' => 'center_edit', 'alias' => 'Center Edit', 'category' => 'Centers']);

        if (    
            !authChecker('admin', [
                'center_add',
                'center_edit'
            ])
        ) {
            return redirect()->route('dashboard.index');
        }

        if ($this->request->getMethod() === 'post') {

            $postData = $this->request->getPost();
            // print_r( $postData);
            $cId = lock($postData['cId'], 'decrypt');
            $rules = [
                "center_name" => [
                    "label" => "Center name",
                    "rules" => "required|trim"
                ],
                "days_open" => [
                    "label" => "Days Availability",
                    "rules" => "required"
                ],
                "avlblty_time_from" => [
                    "label" => "From Time",
                    "rules" => "required"
                ],
                "avlblty_time_to" => [
                    "label" => "To Time",
                    "rules" => "required"
                ],
                "country" => [
                    "label" => "Country",
                    "rules" => "required|trim|numeric"
                ],
                "state" => [
                    "label" => "State",
                    "rules" => "required|trim|numeric"
                ],
                "city" => [
                    "label" => "City",
                    "rules" => "required|trim|numeric"
                ],
                 "services" => [
                    "label" => "Services",
                    "rules" => "required"
                ],
                "latitude" => [
                    "label" => "Latitude",
                    "rules" => "required|trim"
                ],
                "longitude" => [
                    "label" => "Longitude",
                    "rules" => "required|trim"
                ],
                "short_desc" => [
                    "label" => "Description",
                    "rules" => "required|trim"
                ],
                "address" => [
                    "label" => "Address",
                    "rules" => "required|trim"
                ],
             
            ];

            if ($cId == '') { // in case of add new center
                $rules['image'] = [
                    'label' => 'Image',
                    'rules' => 'uploaded[image]|max_size[image,5120]|mime_in[image,image/png,image/jpeg,image/webp]|max_dims[image,2048,2048]',
                    'errors' => [
                        'uploaded' => 'Please select an image to upload',
                        'max_size' => 'The profile image file size cannot exceed 5MB',
                        'mime_in' => 'The profile image must be a PNG or JPEG file',
                        // 'max_dims' => 'The profile image dimensions cannot exceed 2048x2048 pixels',
                    ],
                ];
            } else {
                $rules['center_img'] = [
                    'label' => 'Image',
                    'rules' => 'permit_empty|uploaded[image]|max_size[image,5120]|mime_in[image,image/png,image/jpeg,image/webp]|max_dims[image,2048,2048]',
                    'errors' => [
                        'uploaded' => 'Please select an image to upload',
                        'max_size' => 'The profile image file size cannot exceed 5MB',
                        'mime_in' => 'The profile image must be a PNG or JPEG file',
                        // 'max_dims' => 'The profile image dimensions cannot exceed 2048x2048 pixels',
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

                move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/centers/" . $newfilename);
            } else {
                $newfilename = null;
            }

            if ($cId == '') {
                $isInsert = _insert('sw_centers', [
                             'center_name' => $postData['center_name'],
                             'token' => 'SP' . rand(9999999, 1000000) . 'ER',
                            'days_open' => implode(',', $postData['days_open']),
                            'from_time' => $postData['avlblty_time_from'],
                            'to_time' => $postData['avlblty_time_to'],
                            'latitude' => $postData['latitude'],
                            'services_offered' => implode(',', $postData['services']),
                            'country' => $postData['country'],
                            'state' => $postData['state'],
                            'city' => $postData['city'],
                            'longitude' => $postData['longitude'],
                            'address' => $postData['address'],
                            'short_desc' => $this->db->escapeString($postData['short_desc']),
                             'center_img' => $newfilename,
                ]);
                
                $lasAdded = _getLastRow('sw_centers');
                
                for ($i=0; $i < count($postData['services']); $i++) {
                    
                      $insertPricing = _insert('sw_pricing', [
                            'type' => 'center',
                            'type_id' => $lasAdded->token,
                            'progrm_id' => $postData['services'][$i],
                            'amount' => $postData['prices'][$i],
                            'ins_date' => date('Y-m-d'),
                            'ins_time' => date('H:m:i'),
                            'date_time' => date('Y-m-d H:m:i'),
                      ]);
                }
                
                
               

                if ($isInsert) {
                    return $this->response->setJSON(['success' => true, 'data' => '', 'msg' => 'Center added successfully.']);
                } else {
                    return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Center not added.']);
                }
            } else {
                
                
                if ($newfilename == '') {
                    $isUpdate = _updateWhere('sw_centers', ['id' => $cId], [
                           'center_name' => $postData['center_name'],
                            'days_open' => implode(',', $postData['days_open']),
                            'from_time' => $postData['avlblty_time_from'],
                            'to_time' => $postData['avlblty_time_to'],
                            'services_offered' => implode(',', $postData['services']),
                            'country' => $postData['country'],
                            'state' => $postData['state'],
                            'city' => $postData['city'],
                            'latitude' => $postData['latitude'],
                            'longitude' => $postData['longitude'],
                            'address' => $postData['address'],
                            'short_desc' => $this->db->escapeString($postData['short_desc']),
                    ]);
                } else {
                    $isUpdate = _updateWhere('sw_centers', ['id' => $cId], [
                          'center_name' => $postData['center_name'],
                            'days_open' => implode(',', $postData['days_open']),
                            'from_time' => $postData['avlblty_time_from'],
                            'to_time' => $postData['avlblty_time_to'],
                            'country' => $postData['country'],
                            'services_offered' => implode(',', $postData['services']),
                            'state' => $postData['state'],
                            'city' => $postData['city'],
                            'latitude' => $postData['latitude'],
                            'longitude' => $postData['longitude'],
                            'address' => $postData['address'],
                            'short_desc' => $this->db->escapeString($postData['short_desc']),
                        'center_img' => $newfilename,
                    ]);
                }
                
                
                // PRICING
                $centerToken = _getWhere('sw_centers',['id' => $cId])->token;
                for ($i=0; $i < count($postData['services']); $i++) {
                    
                    $pricingExist = _getWhere('sw_pricing', 
                    ['progrm_id' => $postData['services'][$i],
                    'type_id' =>  $centerToken, 
                    'type' => 'center',
                    'progrm_id' => $postData['services'][$i]
                    ]);
                    
                    if($pricingExist == ''){ //if price does not exist
                        
                        $insertPricing = _insert('sw_pricing', [
                            'type' => 'center',
                            'type_id' => $centerToken,
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


                if ($isUpdate) {
                    return $this->response->setJSON(['success' => true, 'data' => '', 'msg' => 'Center details updated successfully.']);
                } else {
                    return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Center details not updated.']);
                }
            }

        } else {
            $data['weekDays']= [
                ['id' => 0, 'day'=> 'Monday'],
                ['id' => 1, 'day'=> 'Tuesday'],
                ['id' => 2, 'day'=> 'Wednesday'],
                ['id' => 3, 'day'=> 'Thursday'],
                ['id' => 4, 'day'=> 'Friday'],
                ['id' => 5, 'day'=> 'Saturday'],
                ['id' => 6, 'day'=> 'Sunday'],
            ];
            $data['services'] = _getWhere('sw_packages', ['trash' => 0, 'status' => 1], 'yes');
            $data['countries'] = _get('countries');
            $data['states'] = _get('states');
            $data['cities'] = _get('states');

            return view('dashboard/centers/add-center', $data);
        }

    }
    public function centersList()
    {
        _registerFunction(['function_name' => 'center_add','alias' => 'Add Center','category' => 'Centers']);
_registerFunction(['function_name' => 'center_list', 'alias' => 'Center List', 'category' => 'Centers']);
        
         if (
            !authChecker('admin', [
                'center_add',
                'center_list'
            ])
        ) {
            return redirect()->route('dashboard.index');
        }
        
          $data['weekDays']= [
               [ 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
           ];

        $data['centers'] = _getWhere('sw_centers', ['trash' => 0 ], 'yes');
        return view('dashboard/centers/center-list', $data);
    }

    public function centerStatusToggle()
    {

      
_registerFunction(['function_name' => 'center_status_toggle', 'alias' => 'Center Status Toggle', 'category' => 'Centers']);
_registerFunction(['function_name' => 'center_remove', 'alias' => 'Center Remove', 'category' => 'Centers']);

        if (
            !authChecker('admin', [
                'center_status_toggle',
                'center_remove',
            ])
        ) {
            return $this->response->setJSON(['success' => 401, 'msg' => ACCESS_DENIED_MESSAGE]);
        }

        $cId = lock($this->request->getPost('id'), 'decrypt');

        if($this->request->getPost('action') =='trash') {

            $query = _updateWhere('sw_centers', ['id' => $cId], ['trash' => 1]);

            if ($query) {
                return $this->response->setJSON(['success' => true, 'data' => '', 'msg' => 'Trashed successfully.']);
            } else {
                return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Could not trash.']);

            }
        } elseif($this->request->getPost('action') =='chngeStts') {


            $status = _getWhere('sw_centers', ['id' => $cId])->status;
            ($status == 1) ? $status = 0 : $status = 1;

            $query = _updateWhere('sw_centers', ['id' => $cId], ['status' => $status]);

            if ($query) {
                return $this->response->setJSON(['success' => true, 'data' => '', 'msg' => 'Status changed successfully.', 'updatedStatus' => $status]);
            } else {
                return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Could not change status.', 'updatedStatus' => $status]);

            }
        }

    }
    public function centerEdit($centerId){
                
        $cId = lock($centerId, 'decrypt');

        $data['center_data'] = _getWhere('sw_centers', ['id' => $cId]);
        
        $data['services'] = _getWhere('sw_packages', ['trash' => 0, 'status' => 1], 'yes');

        $data['countries'] = _get('countries');

        $data['states'] = _getWhere('states', ['country_id' => $data['center_data']->country], 'yes');
        
        $data['cities'] =  _getWhere('cities', ['state_id' => $data['center_data']->state], 'yes');

        $data['weekDays']= [
            ['id' => 0, 'day'=> 'Monday'],
            ['id' => 1, 'day'=> 'Tuesday'],
            ['id' => 2, 'day'=> 'Wednesday'],
            ['id' => 3, 'day'=> 'Thursday'],
            ['id' => 4, 'day'=> 'Friday'],
            ['id' => 5, 'day'=> 'Saturday'],
            ['id' => 6, 'day'=> 'Sunday'],
            ];

return view('dashboard/centers/add-center', $data);

    }
}
