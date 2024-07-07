<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Service extends BaseController
{
    public $db;


    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->db = \Config\Database::connect();
        $session = \Config\Services::session();

    }
    // public function addService()
    // {
    //     _registerFunction(['function_name' => 'service_add','alias' => 'Add Service','category' => 'Service']);
    //     _registerFunction(['function_name' => 'service_edit','alias' => 'Edit Service','category' => 'Service']);

    //     if (
    //         !authChecker('admin', [
    //             'service_add',
    //             'service_edit'
    //         ])
    //     ) {
    //         return redirect()->route('dashboard.index')->withInput()->with('flash_array', ['access_denied' => 'access_denied']);
    //     }

    //     if ($this->request->getMethod() === 'post') {

    //         $postData = $this->request->getPost();
    //         $service = lock($postData['service'], 'decrypt');
    //         $rules = [
    //             "service_name" => [
    //                 "label" => "Service name",
    //                 "rules" => "required|trim"
    //             ],
    //             "duration_days" => [
    //                 "label" => "Duration Days",
    //                 "rules" => "required|trim|numeric"
    //             ],
    //             "duration_nights" => [
    //                 "label" => "Duration Nights",
    //                 "rules" => "required|trim|numeric"
    //             ],
    //             // "level" => [
    //             //     "label" => "Level",
    //             //     "rules" => "required|trim"
    //             // ],
    //             "short_desc" => [
    //                 "short_desc" => "Description",
    //                 "rules" => "required|trim"
    //             ],
    //         ];

    //         if ($service == '') { // in case of add new pckage
    //             $rules['image'] = [
    //                 'label' => 'Image',
    //                 'rules' => 'uploaded[image]|max_size[image,5120]|mime_in[image,image/png,image/jpeg,image/webp]',
    //                 'errors' => [
    //                     'uploaded' => 'Please select an image to upload',
    //                     'max_size' => 'The profile image file size cannot exceed 5MB',
    //                     'mime_in' => 'The profile image must be a PNG or JPEG file',
    //                     // 'max_dims' => 'The profile image dimensions cannot exceed 2048x2048 pixels',
    //                 ],
    //             ];
    //         } else {
    //             $rules['image'] = [
    //                 'label' => 'Image',
    //                 'rules' => 'permit_empty|uploaded[image]|max_size[image,5120]|mime_in[image,image/png,image/jpeg,image/webp]',
    //                 'errors' => [
    //                     'uploaded' => 'Please select an image to upload',
    //                     'max_size' => 'The profile image file size cannot exceed 5MB',
    //                     'mime_in' => 'The profile image must be a PNG or JPEG file',
    //                     // 'max_dims' => 'The profile image dimensions cannot exceed 2048x2048 pixels',
    //                 ],
    //             ];
    //         }

    //         if (!$this->validate($rules)) {
    //             $errors = $this->validator->getErrors();
    //             return $this->response->setJSON(['success' => false, 'msg' => reset($errors), 'errors' => $errors, 'data' => null]);
    //         }

    //         // validated

    //         if (!empty($_FILES["image"]["name"])) {

    //             $temp = explode(".", $_FILES["image"]["name"]);
    //             $newfilename = round(microtime(true)) . '.' . end($temp);

    //             move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/services/" . $newfilename);
    //         } else {
    //             $newfilename = null;
    //         }

    //         if ($service == '') {
    //             $isInsert = _insert('sw_services', [
    //                 'service_name' => $postData['service_name'],
    //                 'service_duration' => $postData['duration_days'] . ':' . $postData['duration_nights'],
    //                 // 'level' => $postData['level'],
    //                 'description' => $this->db->escapeString($postData['short_desc']),
    //                 'image' => $newfilename,
    //                 'date' => date('Y-m-d'),
    //                 'time' => date('H:i:s'),
    //             ]);

    //             if ($isInsert) {
    //                 return $this->response->setJSON(['success' => true, 'data' => '', 'msg' => 'Service added successfully.']);
    //             } else {
    //                 return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Service not added.']);
    //             }
    //         } else {
    //             if ($newfilename == '') {
    //                 $isUpdate = _updateWhere('sw_services', ['id' => $service], [
    //                     'service_name' => $postData['service_name'],
    //                     'service_duration' => $postData['duration_days'] . ':' . $postData['duration_nights'],
    //                     // 'level' => $postData['level'],
    //                     'description' => $postData['short_desc'],
    //                     'date' => date('Y-m-d'),
    //                     'time' => date('H:i:s'),
    //                 ]);
    //             } else {
    //                 $isUpdate = _updateWhere('sw_services', ['id' => $service], [
    //                     'package_name' => $postData['package_name'],
    //                     'package_duration' => $postData['duration_days'] . ':' . $postData['duration_nights'],
    //                     // 'level' => $postData['level'],
    //                     'description' => $postData['short_desc'],
    //                     'image' => $newfilename,
    //                     'date' => date('Y-m-d'),
    //                     'time' => date('H:i:s'),
    //                 ]);
    //             }


    //             if ($isUpdate) {
    //                 return $this->response->setJSON(['success' => true, 'data' => '', 'msg' => 'Service updated successfully.']);
    //             } else {
    //                 return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Service not updated.']);
    //             }
    //         }



    //     } else {
    //         return view('dashboard/service/add-service');
    //     }

    // }

    public function serviceList()
    {


        _registerFunction(['function_name' => 'service_edit','alias' => 'Edit Service','category' => 'Service']);
        _registerFunction(['function_name' => 'service_remove','alias' => 'Remove Service','category' => 'Service']);
        _registerFunction(['function_name' => 'service_list','alias' => 'Service List','category' => 'Service']);
        _registerFunction(['function_name' => 'service_status_toggle','alias' => 'Service Status Toggle','category' => 'Service']);

        if (
            !authChecker('admin', [
                'service_list',
            ])
        ) {
            return $this->response->setJSON(['success' => 401, 'msg' => ACCESS_DENIED_MESSAGE]);
        }
        $data['services'] = _getWhere('sw_services', ['trash' => 0], 'yes');

        return view('dashboard/service/service-list', $data);
    }

    public function serviceStatusToggle()
    { 
        _registerFunction(['function_name' => 'service_remove','alias' => 'Remove Service','category' => 'Service']);
        _registerFunction(['function_name' => 'service_status_toggle','alias' => 'Service Status Toggle','category' => 'Service']);

        if (
            !authChecker('admin', [
                'service_remove',
                'service_status_toggle',
            ])
        ) {
            return $this->response->setJSON(['success' => 401, 'msg' => ACCESS_DENIED_MESSAGE]);
        }

        $serId = lock($this->request->getPost('id'), 'decrypt');

        if($this->request->getPost('action') =='trash') {

            $query = _updateWhere('sw_services', ['id' => $serId], ['trash' => 1]);

            if ($query) {
                return $this->response->setJSON(['success' => true, 'data' => '', 'msg' => 'Trashed successfully.']);
            } else {
                return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Could not trash.']);

            }
        } elseif($this->request->getPost('action') =='chngeStts') {

            $status = _getWhere('sw_services', ['id' => $serId])->status;
            ($status == 1) ? $status = 0 : $status = 1;

            $query = _updateWhere('sw_services', ['id' => $serId], ['status' => $status]);

            if ($query) {
                return $this->response->setJSON(['success' => true, 'data' => '', 'msg' => 'Status changed successfully.']);
            } else {
                return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Could not change status.']);
            }
        }
    }

    public function serviceEdit($sId){
   $sid  = lock($sId, 'decrypt');
   $data['service_data'] = _getWhere('sw_services' , ['id' => $sid]);
             return view('dashboard/service/add-service' , $data);
    }
}
