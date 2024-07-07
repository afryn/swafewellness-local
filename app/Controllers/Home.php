<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Home extends BaseController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->db = \Config\Database::connect();
        $session = \Config\Services::session();

    }

    public function index()
    {
        $data['packages'] = _getWhere('sw_packages', ['status' => 1, 'trash' => 0], 'yes');
        $data['specialization'] = _getWhere('sw_packages', ['status' => 1, 'trash' => 0, 'specialization' => 'Yes'], 'yes');
        $data['centers'] = _getWhere('sw_centers', ['status' => '1', 'trash' => '0'], 'yes');
        $data['testimonials'] = _getWhere('sw_testimonials', ['status' => '1', 'trash' => '0'], 'yes');
        $data['trainers'] = _getWhere('sw_trainers', ['status' => '1', 'trash' => '0'], 'yes');
        $data['weekDays'] = [
            'Mon',
            'Tue',
            'Wed',
            'Thu',
            'Fri',
            'Sat',
            'Sun'
        ];
        return view('front/homepage', $data);
    }
    
    public function resort_details()
    {
        return view('front/moana-island-dubai');
    }

    public function aboutUs()
    {
        // echo 'fdk';
        $data['testimonials'] = _getWhere('sw_testimonials', ['status' => '1', 'trash' => '0'], 'yes');
        return view('front/about-us', $data);

    }

    public function contact()
    {
        $data['info'] = _getWhere('sw_website_info', ['id' => '1']);
        return view('front/contact-us', $data);

    }

    public function services()
    {
        $data['services'] = _getWhere('sw_packages', ['status' => '1', 'trash' => '0'], 'yes');
        return view('front/services', $data);

    }

    public function gallery()
    {
        $data['gallery'] = _getWhere('sw_gallery', ['status' => '1', 'trash' => '0'], 'yes');
        $allTags = [];
        foreach ($data['gallery'] as $gallery) {
            $tags = explode(',', $gallery->tags);
            foreach ($tags as $tag) {
                if (!in_array($tag, $allTags)) {
                    array_push($allTags, $tag);
                }
            }
        }
        $data['allTags'] = $allTags;
        return view('front/gallery', $data);

    }

    public function programmeDetail($pId)
    {

        $data['programmeDet'] = _getWhere('sw_packages', ['slug' => $pId]);

        $data['testimonials'] = _getWhere('sw_testimonials', ['status' => '1', 'trash' => '0'], 'yes');
        return view('front/programme-detail', $data);
    }

    public function fetchStates()
    {
        $cId = $this->request->getGet('cId');
        $states = $this->db->query('select s.* from states s, cities c where c.state_id = s.id and s.country_id = ' . $cId . ' group by s.id ')->getResult();
        // $states = _getWhere('states', ['country_id' => $cId], 'yes');

        echo json_encode(array('states' => $states));
    }
    public function fetchCities()
    {
        $sId = $this->request->getGet('sId');
        $cities = _getWhere('cities', ['state_id' => $sId], 'yes');

        echo json_encode(array('cities' => $cities));
    }

    public function privacyPolicy()
    {
        return view('front/privacy-policy');
    }

    public function termsNConditions()
    {
        return view('front/terms-and-conditions');
    }

    public function checkBasketStatus()
    {
        if (!empty(basketItems())) {
            echo true;
        } else {
            echo false;
        }
    }
    public function addQuery()
    {
        $postData = $this->request->getPost();

        $rules = [
            "name" => [
                "label" => "Name",
                "rules" => "required|trim"
            ],
            "email" => [
                "label" => "Email",
                "rules" => "required|valid_email|trim"
            ],
            "phone" => [
                "label" => "Mobile",
                "rules" => "required|trim|max_length[15]|min_length[7]"
            ],
        ];



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

        (isset($postData['service'])) ? $service = $postData['service'] : $service = '';
        $msg = $this->db->escapeString($postData['message']);
        $ins = $this->db->query('insert into sw_appointment_query(`user_name`,`email`, `phone`, `message`, `service`) values("' . $postData['name'] . '","' . $postData['email'] . '","' . $postData['phone'] . '","' . $msg . '", "' . $service . '")');

        // $isInsert = _insert('sw_appointment_query', [
        //     'user_name' => $postData['name'],
        //     'email' => $postData['email'],
        //     'phone' => $postData['phone'],
        //     'message' => $this->db->escapeString($postData['message']),
        //     'service' => $service,
        // ]);

        if ($ins) {
            return $this->response->setJSON(['success' => true, 'data' => '', 'msg' => 'Inquiry sent successfully.']);
        } else {
            return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Could not send inquiry.']);
        }
    }

    public function galleryList()
    {
        // print_r($this->db->query('select * from sw_centers order by id desc')->getResult());
        // die();
        $data['galleries'] = _getWhere('sw_gallery', ['trash' => '0'], 'yes');
        return view('dashboard/gallery/gallery-list', $data);
    }

    public function addGallery()
    {

        _registerFunction(['function_name' => 'gallery_add', 'alias' => 'Add Gallery', 'category' => 'Gallery']);
        if (
            !authChecker('admin', [
                'gallery_edit',
                'gallery_add'
            ])
        ) {
            return redirect()->route('dashboard.index')->withInput()->with('flash_array', ['access_denied' => 'access_denied']);
        }

        if ($this->request->getMethod() === 'post') {

            $postData = $this->request->getPost();
            $rules = [
                "gllry_tags" => [
                    "label" => "Tag",
                    "rules" => "required"
                ],
                "image" => [
                    "label" => "Image",
                    "rules" => "uploaded[image]"
                ],
            ];

            if (!$this->validate($rules)) {
                $errors = $this->validator->getErrors();
                return $this->response->setJSON(['success' => false, 'msg' => reset($errors), 'errors' => $errors, 'data' => null]);
            }

            if (!empty($_FILES["image"]["name"])) {
                foreach ($_FILES["image"]["tmp_name"] as $key => $tmp_name) {

                    $temp = explode(".", $_FILES["image"]["name"][$key]);
                    $newfilename = round(microtime(true)) . $key . '.' . end($temp);
                    move_uploaded_file($_FILES["image"]["tmp_name"][$key], "uploads/gallery/" . $newfilename);

                    $tags = implode(',', $postData['gllry_tags']);

                    $isInsert = _insert('sw_gallery', [
                        'tags' => $tags,
                        'image' => $newfilename,
                    ]);
                }
            } else {
                $newfilename = null;
                $tags = implode(',', $postData['gllry_tags']);
                $isInsert = _insert('sw_gallery', [
                    'tags' => $tags,
                    'image' => $newfilename,
                ]);
            }
            if ($isInsert) {
                return $this->response->setJSON(['success' => true, 'data' => '', 'msg' => 'Gallery added successfully.']);
            } else {
                return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Gallery not added.']);
            }

        } else {

            return view('dashboard/gallery/add-gallery');
        }


    }

    public function changeGalleryStatus()
    {
        _registerFunction(['function_name' => 'gallery_status_toggle', 'alias' => 'Gallery Status Toggle', 'category' => 'Gallery']);
        _registerFunction(['function_name' => 'gallery_remove', 'alias' => 'Gallery Remove', 'category' => 'Gallery']);

        if (
            !authChecker('admin', [
                'gallery_status_toggle',
                'gallery_remove',
            ])
        ) {
            return $this->response->setJSON(['success' => 401, 'msg' => ACCESS_DENIED_MESSAGE]);
        }

        $trnrId = lock($this->request->getPost('id'), 'decrypt');

        if ($this->request->getPost('action') == 'trash') {

            $query = _updateWhere('sw_gallery', ['id' => $trnrId], ['trash' => 1]);

            if ($query) {
                return $this->response->setJSON(['success' => true, 'data' => '', 'msg' => 'Trashed successfully.']);
            } else {
                return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Could not trash.']);

            }
        } elseif ($this->request->getPost('action') == 'chngeStts') {


            $status = _getWhere('sw_gallery', ['id' => $trnrId])->status;
            ($status == 1) ? $status = 0 : $status = 1;

            $query = _updateWhere('sw_gallery', ['id' => $trnrId], ['status' => $status]);

            if ($query) {
                return $this->response->setJSON(['success' => true, 'data' => '', 'msg' => 'Status changed successfully.']);
            } else {
                return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Could not change status.']);

            }
        }
    }

    public function websiteInfoUpdate()
    {

        _registerFunction(['function_name' => 'web_content_manage', 'alias' => 'Add / Edit Content', 'category' => 'Website Content Management']);

        if (
            !authChecker('admin', [
                'web_content_manage'
            ])
        ) {
            return $this->response->setJSON(['success' => 401, 'msg' => ACCESS_DENIED_MESSAGE]);
        }

        if ($this->request->getMethod() === 'post') {

            $postData = $this->request->getPost();
            // print_r( $postData);
            $pkg = lock($postData['id'], 'decrypt');
            $rules = [
                "mobile" => [
                    "label" => "Phone Number",
                    "rules" => "required|trim|numeric"
                ],
                "email" => [
                    "label" => "Email",
                    "rules" => "required|valid_email|trim"
                ],
            ];



            if (!$this->validate($rules)) {
                $errors = $this->validator->getErrors();
                return $this->response->setJSON(['success' => false, 'msg' => reset($errors), 'errors' => $errors, 'data' => null]);
            }

            // validated

            $isUpdate = _updateWhere('sw_website_info', ['id' => $pkg], [
                'mobile' => $postData['mobile'],
                'email' => $postData['email'],
                'address' => $postData['address'],
                'instagram' => $postData['insta'],
                'facebook' => $postData['facebook'],
                'twitter' => $postData['twitter'],
                'linkedin   ' => $postData['linkedin'],
                'updated_at   ' => date('Y-m-d H:i:s'),
            ]);



            if ($isUpdate) {
                return $this->response->setJSON(['success' => true, 'data' => '', 'msg' => 'Information updated successfully.']);
            } else {
                return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Information not updated.']);
            }

        } else {
            $data['info'] = _getWhere('sw_website_info', ['id' => '1']);
            return view('dashboard/website/info', $data);
        }

    }

    public function approveAppointment()
    {
        $id = lock($this->request->getPost('id'), 'decrypt');
        // echo $id; die();
        $update = _updateWhere('sw_appointments', ['id' => $id], ['appntmnt_status' => 'Approved']);

        if ($update) {
            return $this->response->setJSON(['success' => true, 'msg' => "Approved"]);
        } else {
            return $this->response->setJSON(['success' => true, 'msg' => "Could not apprve. Please try again later."]);
        }
    }

    public function inquiriesList()
    {
        _registerFunction(['function_name' => 'inquiries_list', 'alias' => 'Users Inquiries', 'category' => 'Inquiries']);

        if (
            !authChecker('admin', [
                'inquiries_list'
            ])
        ) {
            return $this->response->setJSON(['success' => 401, 'msg' => ACCESS_DENIED_MESSAGE]);
        }
        $data['inquiries'] = _getWhere('sw_appointment_query', ['trash' => '0', 'service !=' => 0], 'yes');
        return view('dashboard/users/inquiries', $data);
    }


    public function trashInquiry()
    {
        _registerFunction(['function_name' => 'trashInquiry', 'alias' => 'Delete Inquiry', 'category' => 'Inquiries']);

        if (
            !authChecker('admin', [
                'trashInquiry',
            ])
        ) {
            return $this->response->setJSON(['success' => 401, 'msg' => ACCESS_DENIED_MESSAGE]);
        }

        $trnrId = lock($this->request->getPost('id'), 'decrypt');

        $query = _updateWhere('sw_appointment_query', ['id' => $trnrId], ['trash' => 1]);
        $trainerData = _getWhere('sw_appointment_query', ['id' => $trnrId]);

        if ($query) {
            return $this->response->setJSON(['success' => true, 'data' => '', 'msg' => 'Trashed successfully.']);
        } else {
            return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Could not trash.']);

        }

    }

    public function checkAvailability()
    {
        // setcookie("bucketItems2", "", time() - 3600, "/");
        $postData = $this->request->getGet();

        $dateObject = \DateTime::createFromFormat('Y-m-d', $postData['dateSelect']);
        $dayOfWeek = $dateObject->format('w');

        if ($dayOfWeek == 7) {
            $dayOfWeek = 0;
        } else {
            $dayOfWeek = $dayOfWeek - 1;
        }

        if (isset($postData['lookingfor'])) {
            if ($postData['lookingfor'] == 'trainer' && $postData['selectedData'] == 'packages') {
                $prId = $postData['selectedId'];


                $data['availableTrainers'] = $this->db->query('SELECT * FROM sw_trainers WHERE status = 1 AND trash = 0 AND FIND_IN_SET(' . $postData['selectedId'] . ', services_offered) > 0 AND FIND_IN_SET(' . $dayOfWeek . ', days_availability) > 0')->getResult();

                $fetchdata = _getWhere('sw_packages', ['id' => $postData['selectedId'], 'status' => '1', 'trash' => '0']);

                $selectedData = 'packages';
                $data['lookingFor'] = 'Trainers';

            } else if ($postData['lookingfor'] == 'center' && $postData['selectedData'] == 'packages') {

                $prId = $postData['selectedId'];
                $fetchdata = _getWhere('sw_packages', ['id' => $postData['selectedId'], 'status' => '1', 'trash' => '0']);

                $data['availableCenters'] = $this->db->query('SELECT * FROM sw_centers WHERE status = 1 AND trash = 0 AND FIND_IN_SET(' . $postData['selectedId'] . ', services_offered) > 0 AND FIND_IN_SET(' . $dayOfWeek . ', days_open) > 0')->getResult();

                $selectedData = 'packages';
                $data['lookingFor'] = 'Centers';
            }

        } else {
            if (isset($postData['trainereId']) && isset($postData['programmeId'])) {
                $prId = $postData['programmeId'];

                $data['availableTrainers'] = $this->db->query('SELECT * FROM sw_trainers WHERE id ="' . $postData['trainereId'] . '" AND FIND_IN_SET(' . $postData['programmeId'] . ', services_offered) > 0 AND FIND_IN_SET(' . $dayOfWeek . ', days_availability) > 0')->getResult();


                $fetchdata = _getWhere('sw_packages', ['id' => $postData['programmeId'], 'status' => '1', 'trash' => '0']);

                $data['lookingFor'] = 'Trainers';
                $selectedData = 'packages';

            } else if (isset($postData['centerId']) && isset($postData['programmeId'])) {
                $prId = $postData['programmeId'];

                $data['availableCenters'] = $this->db->query('SELECT * FROM sw_centers WHERE status = 1 AND trash = 0 AND FIND_IN_SET(' . $postData['programmeId'] . ', services_offered) > 0 AND FIND_IN_SET(' . $dayOfWeek . ', days_open) > 0 AND id = ' . $postData['centerId'])->getResult();


                $fetchdata = _getwhere('sw_packages', ['id' => $postData['programmeId'], 'status' => '1', 'trash' => '0']);

                $data['lookingFor'] = 'Centers';
                $selectedData = 'packages';
            }
        }

        $data['weekDays'] = [
            ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        ];
        $dateString = $postData['dateSelect'];
        $date = \DateTime::createFromFormat('Y-m-d', $dateString);

        $formattedDate = $date->format('D, M j, Y');
        $formattedDate2 = $date->format('Y-m-d');

        $data['info'] = [
            'adults' => $postData['adults'],
            'formattedDate' => $formattedDate,
            'formattedDate2' => $formattedDate2,
            'selectedData' => $fetchdata,
            'selectedAttr' => $selectedData,
            'programmeId' => $prId,
        ];

        return view('front/available-data', $data);
    }

    public function storeToBucket()
    {
        // remove previously added items
        //  setcookie("bucketItems2", "", time() - 3600, "/");

        // if (isset($_COOKIE["bucketItems2"])) {
        //     $savedItems = (array) json_decode($_COOKIE["bucketItems2"]);
        // } else {
        $savedItems = [];
        // }
        $newItem = $this->request->getPost();
        
         $p = lock($newItem['prId'], 'decrypt');
         $adults = lock($newItem['adults'], 'decrypt');
        $trainer =   lock(explode('_', $newItem['trainerId'])[1], 'decrypt');
        // echo explode('_', $newItem['trainerId'])[0];
       if(explode('_', $newItem['trainerId'])[0] == 'center'){
           
           $price = $this->db->query('select sp.*FROM sw_pricing sp,sw_centers sc, sw_packages p where p.id="13"and sp.progrm_id=p.id and sp.type_id=sc.token and sc.id="'.$trainer.'"and sp.type="center"')->getRow();
       }else{
           
         $price = $this->db->query('select sp.*FROM sw_pricing sp,sw_trainers st, sw_packages p where p.id="13"and sp.progrm_id=p.id and sp.type_id=st.token and st.id="'.$trainer.'"and sp.type="trainer"')->getResult();
       }
        $totalPrice = $price->amount * $adults;

        array_push($savedItems, $newItem);

        if (setcookie("bucketItems2", json_encode($savedItems), time() + 3600 * 24, "/")) {
            return $this->response->setJSON(['success' => true, 'msg' => 'Added successfully.', 'totalPrice' => $totalPrice ]);
        } else {
            return $this->response->setJSON(['success' => false, 'msg' => 'Could not add. Please try again later.']);
        }

    }

    public function checkout()
    {
        // setcookie("bucketItems2", "", time() - 3600, "/");
        // Decode the JSON string into a PHP array

        $_SESSION['url'] = base_url('checkout');
        if (isset($_COOKIE["bucketItems2"])) {
            $data = json_decode($_COOKIE["bucketItems2"], true);

            // Extract the values from each object
            $values = array_map(function ($item) {
                if (isset($item['trainerId'])) {
                    return $item['trainerId'] . '|' . $item['amount'] . '|' . $item['prId'] . '|' . $item['date'] . '|' . $item['adults'];
                } else {
                    return $item['centerId'] . '|' . $item['amount'] . '|' . $item['prId'] . '|' . $item['date'] . '|' . $item['adults'];
                }

            }, $data);

            // Get the unique values
            $uniqueValues = array_unique($values);


            // Convert the unique values back into an array of objects
            $uniqueObjects = array_map(function ($value) {
                //   echo '<pre>';
                // print_r($value);
                $parts = explode('|', $value);
                $type = explode('_', $parts[0]);
                if ($type[0] == 'center') {
                    return [
                        'centerId' => $type[1],
                        'amount' => $parts[1],
                        'prId' => $parts[2],
                        'date' => $parts[3],
                        'adults' => $parts[4]
                    ];
                } else {
                    return [
                        'trainerId' => $type[1],
                        'amount' => $parts[1],
                        'prId' => $parts[2],
                        'date' => $parts[3],
                        'adults' => $parts[4]
                    ];
                }

            }, $uniqueValues);




            $amount = 0;
            foreach ($uniqueObjects as $pr) {
                //  print_r($pr);
                // die();
                $adults = lock($pr['adults'], 'decrypt');
                if (isset($pr['centerId'])) { // condition not in use
                    $amount += $this->db->query('select sp.amount from sw_pricing sp, sw_centers sc where sp.type = "center" and sp.type_id = sc.token and sc.id = "' . lock($pr['centerId'], 'decrypt') . '" and sp.progrm_id ="' . lock($pr['prId'], 'decrypt') . '"')->getRow()->amount;

                } else if (isset($pr['trainerId'])) {

                    $amount += $this->db->query('select sp.amount from sw_pricing sp, sw_trainers st where sp.type = "trainer" and sp.type_id = st.token and st.id = "' . lock($pr['trainerId'], 'decrypt') . '" and sp.progrm_id ="' . lock($pr['prId'], 'decrypt') . '"')->getRow()->amount;

                }
            }
            $data['userAddr'] = [];
            if (isLoggedIn()) {

                $data['userAddr'] = $this->db->query('select * from sw_user_addresses where user_id =' . $_SESSION['id'])->getRow();
                $data['states'] = _getWhere('states', ['country_id' =>$data['userAddr']->country], 'yes');
                $data['cities'] = _getWhere('cities', ['state_id' =>$data['userAddr']->state], 'yes');
            }
            
            $data['programmes'] = $uniqueObjects;
            $data['totalAmount'] = $amount * $adults;
            $data['countries'] = _get('countries');
         
            $_SESSION['referred_from'] = current_url();
            return view('front/checkout', $data);
        } else {
            return redirect()->back();
        }


    }

    public function checkTrainerAvailibility()
    {
        $postData = $this->request->getPost();

        $trnrDays = explode(',', _getWhere('sw_trainers', ['id' => $postData['trainereId']])->days_availability);

        $dateObject = \DateTime::createFromFormat('m/d/Y', $postData['dateSelect']);

        $dayOfWeek = $dateObject->format('l');
        $week = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $dayindex = array_search($dayOfWeek, $week);

        if (in_array($dayindex, $trnrDays)) {
            echo 'available';
        } else {
            echo 'not available';
        }
        return view('front/availability-check');
    }

    public function changeInqStatus()
    {

        $postData = $this->request->getPost();
        // print_r($postData);

        if ($postData['action'] == 'delete') {
            _registerFunction(['function_name' => 'trashInquiry', 'alias' => 'Delete Inquiry', 'category' => 'Inquiries']);

            if (
                !authChecker('admin', [
                    'trashInquiry',
                ])
            ) {
                return $this->response->setJSON(['success' => 401, 'msg' => ACCESS_DENIED_MESSAGE]);
            }

            $trnrIds = $postData['inqIds'];

            //  _updateWhere('sw_appointment_query', ['id' => $trnrIds], ['trash' => '1']);

            $query = $this->db->table('sw_appointment_query')
                ->whereIn('id', $trnrIds)
                ->update(['trash' => 1]);

            if ($query) {
                return $this->response->setJSON(['success' => true, 'data' => '', 'msg' => 'Trashed successfully.']);
            } else {
                return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Could not trash.']);

            }
        }

    }

}