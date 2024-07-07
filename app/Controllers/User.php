<?php

namespace App\Controllers;

class User extends BaseController
{
    public $db;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->db = \Config\Database::connect();
        $session = \Config\Services::session();

    }
    public function create()
    {

        try {

            _registerFunction(['function_name' => 'new_manpower_create', 'alias' => 'New Manpower Create', 'category' => 'Manpower']);

            if (
                !authChecker('admin', [
                    'new_manpower_create',
                ])
            ) {
                return redirect()->route('dashboard.index')->withInput()->with('flash_array', ['access_denied' => 'access_denied']);
            }

            if ($this->request->getMethod() === 'post') {

                /* =====[ VALIDATION :: START ]===== */

                // Define the regular expression pattern for the password
                /*
                 * At least one uppercase letter
                 * At least one lowercase letter
                 * At least one special character
                 * At least one     
                 * Minimum 8 characters
                 * Maximum 255 characters
                 */
                $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@!%*?&])[A-Za-z\d$@!%*?&]{8,255}$/';

                $rules = [
                    "userRole" => [
                        "label" => "User role",
                        "rules" => "required|trim"
                    ],

                    "name" => [
                        "label" => "Name",
                        "rules" => "required|trim|max_length[100]"
                    ],
                    'image' => [
                        'label' => 'Profile Image',
                        'rules' => 'permit_empty|uploaded[image]|max_size[image,2048]|mime_in[image,image/png,image/jpeg,image/webp]|max_dims[image,2048,2048]',
                        'errors' => [
                            'uploaded' => 'Please select a profile image to upload',
                            'max_size' => 'The profile image file size cannot exceed 2MB',
                            'mime_in' => 'The profile image must be a PNG or JPEG file',
                            'max_dims' => 'The profile image dimensions cannot exceed 2048x2048 pixels',
                        ],
                    ],

                ];

                $getRoles = _getWhere('sw_roles_type', ['id' => dynamicLock($_POST['userRole'], 'decrypt')]);

                $postData = $this->request->getPost();
                $mId = lock($postData['mId'], 'decrypt');

                if ($mId != '') { /// EDIT
                    $currentData = _getWhere('sw_manpower', ['id' => $mId]);

                    $mobileExist = _getWhere('sw_roles', ['primary_phone_no' => $postData['mobile'], 'trash' => '0', 'id != ' => $currentData->roles_tbl_id]);
                    $emailExist = _getWhere('sw_roles', ['email' => $postData['email'], 'trash' => '0', 'id != ' => $currentData->roles_tbl_id]);


                    if ($mobileExist != '') {
                        return $this->response->setJSON(['success' => false, 'msg' => 'Phone Already Exists', 'errors' => '', 'data' => null]);
                    } else if ($emailExist != '') {
                        return $this->response->setJSON(['success' => false, 'msg' => 'Email Already Exists', 'errors' => '', 'data' => null]);
                    }

                } else {

                    $mobileExist = _getWhere('sw_roles', ['primary_phone_no' => $postData['mobile'], 'trash' => '0']);
                    $emailExist = _getWhere('sw_roles', ['email' => $postData['email'], 'trash' => '0']);


                    if ($mobileExist != '') {
                        return $this->response->setJSON(['success' => false, 'msg' => 'Phone Already Exists', 'errors' => '', 'data' => null]);
                    } else if ($emailExist != '') {
                        return $this->response->setJSON(['success' => false, 'msg' => 'Email Already Exists', 'errors' => '', 'data' => null]);
                    }

                    $rules['email'] = [
                        'label' => 'Email Address',
                        'rules' => 'required|valid_email',
                        'errors' => [
                            'required' => 'The email address field is required',
                            'valid_email' => 'Please enter a valid email address',
                        ],
                    ];
                    $rules['mobile'] = [
                        "label" => "Phone number",
                        "rules" => "required|trim|max_length[15]",
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
                }
                if (!$this->validate($rules)) {
                    $errors = $this->validator->getErrors();
                    return $this->response->setJSON(['success' => false, 'msg' => reset($errors), 'errors' => $errors, 'data' => null]);
                }

                $profile_photo_title = null;
                $imageFile = $this->request->getFile('image');
                if ($_FILES['image']['name'] != '') {

                    $temp = explode(".", $_FILES["image"]["name"]);
                    $newName = round(microtime(true)) . '.' . end($temp);

                    if (move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/manpowers/" . $newName)) {
                        // Image uploaded successfully
                        $profile_photo_title = $newName;
                    } else {
                        // Error uploading the image
                        $profile_photo_title = null;
                    }
                } else {
                    $profile_photo_title = null;
                }

                if ($mId != '') {

                    if ($profile_photo_title != null) {


                        //update
                        $update2 = _updateWhere('sw_manpower', ['id' => $mId], [
                            'role_id' => $getRoles->id ?? null,
                            'first_name' => $postData['name'] ?? null,
                            'profile_photo' => $profile_photo_title ?? null,
                            'phone_no' => $postData['mobile'] ?? null,
                            'email' => $postData['email'],
                            'updated_at' => date('Y-m-d H:i:s'),
                        ]);

                        $update = _updateWhere('sw_roles', ['id' => $currentData->roles_tbl_id], [
                            'first_name ' => $postData['name'] ?? null,
                            'email' => $postData['email'],
                            'primary_phone_no' => $postData['mobile'] ?? null,
                            'role_id' => $getRoles->id ?? null,
                            'profile_photo' => $profile_photo_title ?? null,
                            'updated_at' => date('Y-m-d H:i:s'),
                        ]);
                    } else {
                        //update
                        $update2 = _updateWhere('sw_manpower', ['id' => $mId], [
                            'role_id' => $getRoles->id ?? null,
                            'first_name' => $postData['name'] ?? null,
                            'phone_no' => $postData['mobile'] ?? null,
                            'email' => $postData['email'],
                            'updated_at' => date('Y-m-d H:i:s'),
                        ]);

                        $update = _updateWhere('sw_roles', ['id' => $currentData->roles_tbl_id], [
                            'first_name ' => $postData['name'] ?? null,
                            'email' => $postData['email'],
                            'primary_phone_no' => $postData['mobile'] ?? null,
                            'role_id' => $getRoles->id ?? null,
                            'updated_at' => date('Y-m-d H:i:s'),
                        ]);
                    }

                    if ($update && $update2) {
                        return $this->response->setJSON(['success' => true, 'data' => '', 'msg' => 'Manpower updated successfully.']);
                    } else {
                        return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Manpower not updated.']);
                    }

                } else {

                    $isInsert2 = _insert('sw_roles', [
                        'first_name ' => $postData['name'] ?? null,
                        'email' => $postData['email'],
                        'primary_phone_no' => $postData['mobile'] ?? null,
                        'role_id' => $getRoles->id ?? null,
                        'status' => 'active',
                        'password' => lock($postData['new_password']),
                        'profile_photo' => $profile_photo_title ?? null,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);

                    $lastRec = _getDESC('sw_roles');

                    $isInsert = _insert('sw_manpower', [
                        'roles_tbl_id' => $lastRec->id,
                        'role_id' => $getRoles->id ?? null,
                        'first_name' => $postData['name'] ?? null,
                        'profile_photo' => $profile_photo_title ?? null,
                        'phone_no' => $postData['mobile'] ?? null,
                        'email' => $postData['email'],
                        'status' => '1',
                        // 'password' => lock($postData['new_password']),
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);

                    if ($isInsert && $isInsert2) {
                        $ProfileUrl = base_url(route_to('user.edit', lock($isInsert)));
                        return $this->response->setJSON(['success' => true, 'data' => '', 'msg' => 'Manpower created successfully.', 'profile_url' => $ProfileUrl]);
                    } else {
                        return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Manpower not inserted properly.']);
                    }
                }


            } else {

                return view('dashboard/manpower/add-manpower', [
                    'roles' => _getWhere('sw_roles_type', ['status' => 'active', 'vip' => 'no', 'id !=' => '19'], 'yes')
                ]);

            }

        } catch (\Exception $e) {

            prx([
                'getMessage' => $e->getMessage() ?? '',
                'getLine' => $e->getLine() ?? '',
            ]);

        }

    }

    public function manpStatusToggle()
    {
        _registerFunction(['function_name' => 'manpower_remove', 'alias' => 'Manpower Remove', 'category' => 'Manpower']);
        _registerFunction(['function_name' => 'manpower_status_toggle', 'alias' => 'Manpower Status Toggle', 'category' => 'Manpower']);

        if (
            !authChecker('admin', [
                'manpower_status_toggle',
                'manpower_remove',
            ])
        ) {
            return $this->response->setJSON(['success' => 401, 'msg' => ACCESS_DENIED_MESSAGE]);
        }

        $uId = lock($this->request->getPost('id'), 'decrypt');
        $userData = _getWhere('sw_manpower', ['id' => $uId]);

        if ($this->request->getPost('action') == 'trash') {

            $query = _updateWhere('sw_manpower', ['id' => $uId], ['trash' => 1]);

            // roles table 
            $query2 = _updateWhere('sw_roles', ['id' => $userData->roles_tbl_id], ['trash' => 1]);

            if ($query && $query2) {
                return $this->response->setJSON(['success' => true, 'data' => '', 'msg' => 'Trashed successfully.']);
            } else {
                return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Could not trash.']);
            }

        } elseif ($this->request->getPost('action') == 'chngeStts') {


            $status = _getWhere('sw_manpower', ['id' => $uId])->status;
            ($status == 1) ? $status = 0 : $status = 1;

            $query = _updateWhere('sw_manpower', ['id' => $uId], ['status' => $status]);

            // roles table 
            ($status == 1) ? $status2 = 'active' : $status2 = 'inactive';
            $query2 = _updateWhere('sw_roles', ['id' => $userData->roles_tbl_id], ['status' => $status2]);

            if ($query && $query2) {
                return $this->response->setJSON(['success' => true, 'data' => '', 'msg' => 'Status changed successfully.', 'updatedStatus' => $status]);
            } else {
                return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Could not change status.', 'updatedStatus' => $status]);

            }
        }
    }

    public function manpowerList()
    {

        _registerFunction(['function_name' => 'manpower_list', 'alias' => 'Manpower List', 'category' => 'Manpower']);
        _registerFunction(['function_name' => 'manpower_edit', 'alias' => 'Manpower Edit', 'category' => 'Manpower']);
        _registerFunction(['function_name' => 'new_manpower_create', 'alias' => 'New Manpower Create', 'category' => 'Manpower']);
        _registerFunction(['function_name' => 'manpower_remove', 'alias' => 'Manpower Remove', 'category' => 'Manpower']);
        _registerFunction(['function_name' => 'manpower_status_toggle', 'alias' => 'Manpower Status Toggle', 'category' => 'Manpower']);

        if (
            !authChecker('admin', [
                'manpower_list',
                'manpower_edit',
                'new_manpower_create',
                'manpower_status_toggle',
                'manpower_remove',
            ])
        ) {
            return redirect()->route('dashboard.index')->withInput()->with('flash_array', ['access_denied' => 'access_denied']);
        }

        $db = \Config\Database::connect();
        $builder = $db->table("sw_manpower as emp");
        $builder->select('emp.*');
        $builder->whereNotIn('emp.role_id', [1]); // except admin
        $builder->where('emp.trash !=', '1');
        $builder->orderBy('emp.id', 'desc');
        $employeeList = $builder->get()->getResult();
        return view('dashboard/manpower/manpower-list', [
            'employeeList' => $employeeList
        ]);
    }

    public function manpEdit($mId)
    {
        $mId = lock($mId, 'decrypt');

        $data['manp_data'] = _getWhere('sw_manpower', ['id' => $mId]);
        $data['manp_role_data'] = _getWhere('sw_roles', ['id' => $data['manp_data']->roles_tbl_id]);
        $data['roles'] = _getWhere('sw_roles_type', ['status' => 'active', 'vip' => 'no'], 'yes');

        return view('dashboard/manpower/add-manpower', $data);
    }

    public function profile()
    {

        _registerFunction(['function_name' => 'manpower_employee_profile', 'alias' => 'Manpower / Employee Profile', 'category' => 'Manpower Management']);
        if (
            !authChecker('admin', [
                'manpower_employee_profile',
            ])
        ) {
            return redirect()->route('dashboard.index')->withInput()->with('flash_array', ['access_denied' => 'access_denied']);
        }

        return view('dashboard/user/employee-pofile');
    }

    public function listAjax()
    {

        try {

            $html = '';
            $db = \Config\Database::connect();
            $builder = $db->table("sw_manpower as employee");
            $builder->select('employee.*');
            $results = $builder->get()->getResult();
            if ($results) {

                $tableHeader = <<<TABLEHEADER
    <table class="table table-striped table-hover" id="dataTable">
    <thead>
        <tr>
            <th scope="col">SL</th>
            <th scope="col">Profile</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Phone</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
    {{TABLE_HTML_BODY}}
    </tbody>
    </table>
    TABLEHEADER;
                $i = 1;
                foreach ($results as $result) {
                    $html .= '<tr>';
                    $html .= '<th scope="row">' . $i . '</th>';
                    $html .= '<td><a class="popup_gallery_box" href="' . base_url('documents/profile/' . $result->profile_photo) . '"> <img class="w-35 br-5 img-fluid" src="' . base_url('documents/profile/' . $result->profile_photo) . '"></a></td>';
                    $html .= '<td>' . ucwords($result->first_name) . ' ' . ucwords($result->last_name) . '</td>';
                    $html .= '<td>' . $result->email . '</td>';
                    $html .= '<td>' . $result->primary_phone_no . '</td>';
                    $userStatus = $result->status == 'active' ? 'checked' : '';
                    $html .= '<td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" onClick="employeeStatusToggle(\'' . lock($result->id) . '\')" role="switch" ' . $userStatus . '>
                                </div>
                            </td>';
                    $html .= '<td><a href="' . base_url(route_to('user.edit', lock($result->id))) . '" class="text-primary"><i class="fa fa-edit"></i></a>  &nbsp;  <a href="javascript:void(0)" onClick="removeEmployee(\'' . lock($result->id) . '\')" class="text-danger"><i class="fa fa-trash"></i></a></td>';
                    $html .= '</tr>';
                    $i++;
                }

                $html = str_replace('{{TABLE_HTML_BODY}}', $html, $tableHeader);

            } else {

                $emptyImage = base_url('dashboard_assets/media/illustrations/sketchy-1/2.png');
                $createNewSubscription = base_url(route_to('user.create'));
                $html = <<<TABLEEMPTY
<h2 class="text-center fs-2x fw-bold mb-0">Create your first employee</h2>
<p class="text-center text-gray-400 fs-4 fw-semibold py-7">Build a employee to bring your service to life.<br>Launch a Freehand to colloborate in real time. <br><br> <a href="{$createNewSubscription}" class="btn btn-primary border-radius-50"><i class="fa fa-plus" aria-hidden="true"></i> Create New Employee</a> </p>
<div class="text-center pb-15 px-5">
<img src="{$emptyImage}" alt="" class="mw-100 h-200px h-sm-325px">
</div>
TABLEEMPTY;

            }

            return $this->response->setJSON(['success' => true, 'data' => $html, 'msg' => 'fetch record successfully.']);

        } catch (\Exception $e) {

            prx([
                'getMessage' => $e->getMessage() ?? '',
                'getLine' => $e->getLine() ?? '',
            ]);

        }

    }

    public function edit($uid)
    {

        try {

            _registerFunction(['function_name' => 'manpower_edit', 'alias' => 'Manpower Edit', 'category' => 'Manpower Management']);
            if (
                !authChecker('admin', [
                    'manpower_edit',
                ])
            ) {
                return redirect()->route('dashboard.index')->withInput()->with('flash_array', ['access_denied' => 'access_denied']);
            }

            if ($this->request->getMethod() === 'post') {
                /* =====[ VALIDATION :: START ]===== */

                // Define the regular expression pattern for the password
                /*
                 * At least one uppercase letter
                 * At least one lowercase letter
                 * At least one special character
                 * At least one number
                 * Minimum 8 characters
                 * Maximum 255 characters
                 */
                $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@!%*?&])[A-Za-z\d$@!%*?&]{8,255}$/';
                $user_id = lock($uid, 'decrypt');

                $rules = [
                    "monday_start" => [
                        "label" => "Monday Start",
                        "rules" => "permit_empty|required_with[monday_end]",
                        'errors' => [
                            'required_with' => 'Both fields are required.',
                            'less_than' => 'Monday Start must be less than Monday End.'
                        ],
                    ],
                    "monday_end" => [
                        "label" => "Monday End",
                        "rules" => "permit_empty|required_with[monday_start]",
                        'errors' => [
                            'required_with' => 'Both fields are required.',
                            'greater_than' => 'Monday End must be greater than Monday Start.'
                        ],
                    ],
                    "tuesday_start" => [
                        "label" => "Tuesday Start",
                        "rules" => "permit_empty|required_with[tuesday_end]",
                        'errors' => [
                            'required_with' => 'Both fields are required.',
                            'less_than' => 'Tuesday Start must be less than Tuesday End.'
                        ],
                    ],
                    "tuesday_end" => [
                        "label" => "Tuesday End",
                        "rules" => "permit_empty|required_with[tuesday_start]",
                        'errors' => [
                            'required_with' => 'Both fields are required.',
                            'greater_than' => 'Tuesday End must be greater than Tuesday Start.'
                        ],
                    ],
                    "wednesday_start" => [
                        "label" => "Wednesday Start",
                        "rules" => "permit_empty|required_with[wednesday_end]",
                        'errors' => [
                            'required_with' => 'Both fields are required.',
                            'less_than' => 'Wednesday Start must be less than Wednesday End.'
                        ],
                    ],
                    "wednesday_end" => [
                        "label" => "Wednesday End",
                        "rules" => "permit_empty|required_with[wednesday_start]",
                        'errors' => [
                            'required_with' => 'Both fields are required.',
                            'greater_than' => 'Wednesday End must be greater than Wednesday Start.'
                        ],
                    ],
                    "thursday_start" => [
                        "label" => "Thursday Start",
                        "rules" => "permit_empty|required_with[thursday_end]",
                        'errors' => [
                            'required_with' => 'Both fields are required.',
                            'less_than' => 'Thursday Start must be less than Thursday End.'
                        ],
                    ],
                    "thursday_end" => [
                        "label" => "Thursday End",
                        "rules" => "permit_empty|required_with[thursday_start]",
                        'errors' => [
                            'required_with' => 'Both fields are required.',
                            'greater_than' => 'Thursday End must be greater than Thursday Start.'
                        ],
                    ],
                    "friday_start" => [
                        "label" => "Friday Start",
                        "rules" => "permit_empty|required_with[friday_end]",
                        'errors' => [
                            'required_with' => 'Both fields are required.',
                            'less_than' => 'Friday Start must be less than Friday End.'
                        ],
                    ],
                    "friday_end" => [
                        "label" => "Friday End",
                        "rules" => "permit_empty|required_with[friday_start]",
                        'errors' => [
                            'required_with' => 'Both fields are required.',
                            'greater_than' => 'Friday End must be greater than Friday Start.'
                        ],
                    ],
                    "saturday_start" => [
                        "label" => "Saturday Start",
                        "rules" => "permit_empty|required_with[saturday_end]",
                        'errors' => [
                            'required_with' => 'Both fields are required.',
                            'less_than' => 'Saturday Start must be less than Saturday End.'
                        ],
                    ],
                    "saturday_end" => [
                        "label" => "Saturday End",
                        "rules" => "permit_empty|required_with[saturday_start]",
                        'errors' => [
                            'required_with' => 'Both fields are required.',
                            'greater_than' => 'Saturday End must be greater than Saturday Start.'
                        ],
                    ],
                    "sunday_start" => [
                        "label" => "Sunday Start",
                        "rules" => "permit_empty|required_with[sunday_end]",
                        'errors' => [
                            'required_with' => 'Both fields are required.',
                            'less_than' => 'Sunday Start must be less than Sunday End.'
                        ],
                    ],
                    "sunday_end" => [
                        "label" => "Sunday End",
                        "rules" => "permit_empty|required_with[sunday_start]",
                        'errors' => [
                            'required_with' => 'Both fields are required.',
                            'greater_than' => 'Sunday End must be greater than Sunday Start.'
                        ],
                    ],
                    "FirstName" => [
                        "label" => "First name",
                        "rules" => "required|trim|alpha|max_length[100]"
                    ],
                    "LastName" => [
                        "label" => "Last name",
                        "rules" => "required|trim|alpha|max_length[100]"
                    ],
                    "phone_number" => [
                        "label" => "Phone number",
                        "rules" => "required|trim|max_length[15]|is_unique[sw_manpower.primary_phone_no,id,{$user_id}]",
                        'errors' => [
                            'is_unique' => 'The phone number you entered is already registered.',
                        ],
                    ],
                    "alternate_number" => [
                        "label" => "Alternate phone number",
                        "rules" => "permit_empty|trim|max_length[15]"
                    ],
                    "permanentCountryList" => [
                        "label" => "Permanent country",
                        "rules" => "required|trim"
                    ],
                    "date_of_birth" => [
                        "label" => "Date of Birth",
                        "rules" => "required|trim|valid_date",
                        'errors' => [
                            'valid_date' => 'Please enter a valid date in the format yyyy-mm-dd',
                        ],
                    ],
                    'profile_photo' => [
                        'label' => 'Profile Image',
                        'rules' => 'permit_empty|uploaded[profile_photo]|max_size[profile_photo,2048]|mime_in[profile_photo,image/png,image/jpeg,image/webp]|max_dims[profile_photo,2048,2048]',
                        'errors' => [
                            'uploaded' => 'Please select a profile image to upload',
                            'max_size' => 'The profile image file size cannot exceed 2MB',
                            'mime_in' => 'The profile image must be a PNG or JPEG file',
                            'max_dims' => 'The profile image dimensions cannot exceed 2048x2048 pixels',
                        ],
                    ],
                    // 'email_address' => [
                    //     'label' => 'Email Address',
                    //     'rules' => 'required|valid_email|is_unique[sw_employee.email]',
                    //     'errors' => [
                    //         'required' => 'The email address field is required',
                    //         'valid_email' => 'Please enter a valid email address',
                    //         'is_unique' => 'That email address is already registered',
                    //     ],
                    // ],
                    'new_password' => [
                        'label' => 'Password',
                        'rules' => [
                            'permit_empty',
                            'regex_match[' . $pattern . ']'
                        ],
                        'errors' => [
                            'required' => 'The password field is required',
                            'regex_match' => 'The password field must contain at least <ul><li>one uppercase letter</li> <li>one lowercase letter</li> <li>one special character</li> <li>one number</li> <li>between 8 to 200 characters length</li> </ul>',
                        ],
                    ],
                    "manpowerCategories" => [
                        "label" => "Manpower categories",
                        "rules" => 'is_array|required',
                        "errors" => [
                            "is_array" => "Minimum one item selection required",
                            "required" => "The {field} field is required."
                        ]
                    ],
                ];


                /* =====[ Passport Documents Validation Rules ]===== */
                if (!empty($this->request->getPost('doc_passport_name')) || !empty($this->request->getPost('doc_passport_no')) || !empty($this->request->getPost('doc_passport_date_of_issue')) || !empty($this->request->getPost('doc_passport_date_of_expiry')) || (isset($_FILES['doc_passport_attachments']['name'][0]) && !empty($_FILES['doc_passport_attachments']['name'][0]))) {

                    $rules["doc_passport_name"] = [
                        "label" => "Passport name",
                        "rules" => 'required|trim|max_length[200]'
                    ];

                    $rules["doc_passport_no"] = [
                        "label" => "Passport number",
                        "rules" => 'required|trim|max_length[200]'
                    ];

                    $rules["doc_passport_date_of_issue"] = [
                        "label" => "Passport date of issue",
                        "rules" => 'required|trim|valid_date'
                    ];

                    $rules["doc_passport_date_of_expiry"] = [
                        "label" => "Passport date of expiry",
                        "rules" => 'required|trim|valid_date'
                    ];


                    $doc_passport_attachments_isRequired = '';
                    $PassportAttachmentsGetDocuments = _getWhere('sw_documents', ['employee_id' => $user_id, 'doc_type' => 'passport']);
                    if ($PassportAttachmentsGetDocuments) {
                        if (!empty($PassportAttachmentsGetDocuments->attachment)) {
                            $doc_passport_attachments_isRequired = 'permit_empty|';
                        }
                    }


                    /* 15360 = 15 MB */
                    $rules["doc_passport_attachments"] = [
                        'label' => 'Passport Document Attachments',
                        'rules' => $doc_passport_attachments_isRequired . 'uploaded[doc_passport_attachments]|max_size[doc_passport_attachments,15360]|mime_in[doc_passport_attachments,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,image/jpeg,image/png,image/webp]',
                        'errors' => [
                            'uploaded' => 'Please select a file to upload for {field}.',
                            'max_size' => 'The file size for {field} must be less than 15 MB.',
                            'mime_in' => 'The file type for {field} is not allowed. Please select a PDF, Microsoft Word, Image file.',
                        ],
                    ];

                }


                /* =====[ Labour card Documents Validation Rules ]===== */
                if (!empty($this->request->getPost('doc_labour_card_number')) || !empty($this->request->getPost('doc_labour_card_expiry_date'))) {

                    $rules["doc_labour_card_number"] = [
                        "label" => "Labour card number",
                        "rules" => 'required|trim|max_length[200]'
                    ];

                    $rules["doc_labour_card_expiry_date"] = [
                        "label" => "Labour card expiry date",
                        "rules" => 'required|trim|max_length[200]'
                    ];

                }


                /* =====[ Visa Documents Validation Rules ]===== */
                if (!empty($this->request->getPost('doc_visa_number')) || !empty($this->request->getPost('doc_visa_expiry_date')) || (isset($_FILES['doc_visa_attachments']['name'][0]) && !empty($_FILES['doc_visa_attachments']['name'][0]))) {

                    $rules["doc_visa_number"] = [
                        "label" => "Visa number",
                        "rules" => 'required|trim|max_length[200]'
                    ];

                    $rules["doc_visa_expiry_date"] = [
                        "label" => "Visa expiry date",
                        "rules" => 'required|trim|max_length[200]'
                    ];


                    $doc_visa_attachments_isRequired = '';
                    $VisaAttachmentsGetDocuments = _getWhere('sw_documents', ['employee_id' => $user_id, 'doc_type' => 'visa']);
                    if ($VisaAttachmentsGetDocuments) {
                        if (!empty($VisaAttachmentsGetDocuments->attachment)) {
                            $doc_visa_attachments_isRequired = 'permit_empty|';
                        }
                    }


                    /* 15360 = 15 MB */
                    $rules["doc_visa_attachments"] = [
                        'label' => 'Visa document attachments',
                        'rules' => $doc_visa_attachments_isRequired . 'uploaded[doc_visa_attachments]|max_size[doc_visa_attachments,15360]|mime_in[doc_visa_attachments,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,image/jpeg,image/png,image/webp]',
                        'errors' => [
                            'uploaded' => 'Please select a file to upload for {field}.',
                            'max_size' => 'The file size for {field} must be less than 15 MB.',
                            'mime_in' => 'The file type for {field} is not allowed. Please select a PDF, Microsoft Word, Image file.',
                        ],
                    ];

                }


                /* =====[ Emirates Documents Validation Rules ]===== */
                if (!empty($this->request->getPost('doc_emirate_id_number')) || (isset($_FILES['doc_emirates_attachments']['name'][0]) && !empty($_FILES['doc_emirates_attachments']['name'][0]))) {

                    $rules["doc_emirate_id_number"] = [
                        "label" => "doc_emirate_id_number",
                        "rules" => 'required|trim|max_length[200]'
                    ];

                    $emirate_attachments_isRequired = '';
                    $emirateAttachmentsGetDocuments = _getWhere('sw_documents', ['employee_id' => $user_id, 'doc_type' => 'emirates']);
                    if ($emirateAttachmentsGetDocuments) {
                        if (!empty($emirateAttachmentsGetDocuments->attachment)) {
                            $emirate_attachments_isRequired = 'permit_empty|';
                        }
                    }

                    /* 15360 = 15 MB */
                    $rules["doc_emirates_attachments"] = [
                        'label' => 'Emirates document attachments',
                        'rules' => $emirate_attachments_isRequired . 'uploaded[doc_emirates_attachments]|max_size[doc_emirates_attachments,15360]|mime_in[doc_emirates_attachments,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,image/jpeg,image/png,image/webp]',
                        'errors' => [
                            'uploaded' => 'Please select a file to upload for {field}.',
                            'max_size' => 'The file size for {field} must be less than 15 MB.',
                            'mime_in' => 'The file type for {field} is not allowed. Please select a PDF, Microsoft Word, Image file.',
                        ],
                    ];

                }


                /* =====[ Driving License Validation Rules ]===== */
                if (!empty($this->request->getPost('doc_driving_license_number')) || !empty($this->request->getPost('doc_driving_license_expiry_date')) || (isset($_FILES['doc_driving_license_attachments']['name'][0]) && !empty($_FILES['doc_driving_license_attachments']['name'][0]))) {

                    $rules["doc_driving_license_number"] = [
                        "label" => "Driving license number",
                        "rules" => 'required|trim|max_length[200]'
                    ];

                    $rules["doc_driving_license_expiry_date"] = [
                        "label" => "Driving license expiry date",
                        "rules" => 'required|trim|max_length[200]'
                    ];

                    $drivingLicense_attachments_isRequired = '';
                    $DrivingLicAttachmentsGetDocuments = _getWhere('sw_documents', ['employee_id' => $user_id, 'doc_type' => 'driving_license']);
                    if ($DrivingLicAttachmentsGetDocuments) {
                        if (!empty($DrivingLicAttachmentsGetDocuments->attachment)) {
                            $drivingLicense_attachments_isRequired = 'permit_empty|';
                        }
                    }

                    /* 15360 = 15 MB */
                    $rules["doc_driving_license_attachments"] = [
                        'label' => 'Driving license attachments',
                        'rules' => $drivingLicense_attachments_isRequired . 'uploaded[doc_driving_license_attachments]|max_size[doc_driving_license_attachments,15360]|mime_in[doc_driving_license_attachments,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,image/jpeg,image/png,image/webp]',
                        'errors' => [
                            'uploaded' => 'Please select a file to upload for {field}.',
                            'max_size' => 'The file size for {field} must be less than 15 MB.',
                            'mime_in' => 'The file type for {field} is not allowed. Please select a PDF, Microsoft Word, Image file.',
                        ],
                    ];

                }


                /*

                if( !empty($this->request->getPost('monday_start')) && !empty($this->request->getPost('monday_end')) ){

                    $monday_start = $this->request->getPost('monday_start');
                    $monday_end = $this->request->getPost('monday_end');
                    if (($monday_start < $monday_end) && ($monday_end > $monday_start) ) {
                       prx('error');
                    }else {
                       prx('no error');
                    }

                }

                */




                if (!$this->validate($rules)) {
                    $errors = $this->validator->getErrors();
                    return $this->response->setJSON(['success' => false, 'msg' => reset($errors), 'errors' => $errors, 'data' => null]);
                }

                /* =====[ VALIDATION :: END ]===== */

                /* =====[ BUSINESS LOGIC :: START ]===== */

                $postData = $this->request->getPost();

                $empInfo = _getWhere('sw_employee', ['id' => lock($uid, 'decrypt')]);
                if (!$empInfo) {
                    return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Employee not found.']);
                }


                /* =====[ PASSPORT DOCUMENTS UPLOAD :: START ]===== */
                if (!empty($this->request->getPost('doc_passport_name')) || !empty($this->request->getPost('doc_passport_no')) || !empty($this->request->getPost('doc_passport_date_of_issue')) || !empty($this->request->getPost('doc_passport_date_of_expiry')) || (isset($_FILES['doc_passport_attachments']['name'][0]) && !empty($_FILES['doc_passport_attachments']['name'][0]))) {

                    $passport_attachments_files = '';
                    $employeePassportDoc = _getWhere('sw_documents', ['employee_id' => lock($uid, 'decrypt'), 'doc_type' => 'passport']);
                    if ($employeePassportDoc) {
                        if (!empty($employeePassportDoc->attachment)) {
                            $passport_attachments_files .= $employeePassportDoc->attachment ?? '';
                            $passport_attachments_files .= ',';
                        }
                    }

                    $uploadedFiles = uploadFiles(ROOTPATH . 'public/documents/employee_document', 'doc_passport_attachments');

                    if ($uploadedFiles !== false) {
                        if (is_array($uploadedFiles)) {
                            $passport_attachments_files .= implode(',', $uploadedFiles); // successfully uploaded
                        } else {
                            $passport_attachments_files .= $uploadedFiles;
                        }
                    }

                    updateOrCreate(
                        'sw_documents',
                        [
                            'employee_id' => lock($uid, 'decrypt'),
                            'document_name' => $this->request->getPost('doc_passport_name'),
                            'doc_type' => 'passport',
                            'attachment' => trim($passport_attachments_files, ','),
                            'document_number' => $this->request->getPost('doc_passport_no'),
                            'document_date_of_issue' => $this->request->getPost('doc_passport_date_of_issue'),
                            'document_date_of_expiry' => $this->request->getPost('doc_passport_date_of_expiry'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        ],
                        [
                            'employee_id' => lock($uid, 'decrypt'),
                            'doc_type' => 'passport',
                        ]
                    );

                }
                /* =====[ PASSPORT DOCUMENTS UPLOAD :: END ]===== */


                /* =====[ LABOUR CARD DOCUMENTS UPLOAD :: START ]===== */
                if (!empty($this->request->getPost('doc_labour_card_number')) || !empty($this->request->getPost('doc_labour_card_expiry_date'))) {

                    updateOrCreate(
                        'sw_documents',
                        [
                            'employee_id' => lock($uid, 'decrypt'),
                            'doc_type' => 'labour_card',
                            'document_number' => $this->request->getPost('doc_labour_card_number'),
                            'document_date_of_expiry' => $this->request->getPost('doc_labour_card_expiry_date'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        ],
                        [
                            'employee_id' => lock($uid, 'decrypt'),
                            'doc_type' => 'labour_card',
                        ]
                    );

                }
                /* =====[ LABOUR CARD DOCUMENTS UPLOAD :: END ]===== */


                /* =====[ VISA DOCUMENTS UPLOAD :: START ]===== */
                if (!empty($this->request->getPost('doc_visa_number')) || !empty($this->request->getPost('doc_visa_expiry_date')) || (isset($_FILES['doc_visa_attachments']['name'][0]) && !empty($_FILES['doc_visa_attachments']['name'][0]))) {

                    $visa_attachments_files = '';
                    $employeeVisaDoc = _getWhere('sw_documents', ['employee_id' => lock($uid, 'decrypt'), 'doc_type' => 'visa']);
                    if ($employeeVisaDoc) {
                        if (!empty($employeeVisaDoc->attachment)) {
                            $visa_attachments_files .= $employeeVisaDoc->attachment ?? '';
                            $visa_attachments_files .= ',';
                        }
                    }

                    $uploadedFiles_v3 = uploadFiles(ROOTPATH . 'public/documents/employee_document', 'doc_visa_attachments');
                    if ($uploadedFiles_v3 !== false) {
                        if (is_array($uploadedFiles_v3)) {
                            $visa_attachments_files .= implode(',', $uploadedFiles_v3); // successfully uploaded
                        } else {
                            $visa_attachments_files .= $uploadedFiles_v3;
                        }
                    }

                    updateOrCreate(
                        'sw_documents',
                        [
                            'employee_id' => lock($uid, 'decrypt'),
                            'doc_type' => 'visa',
                            'attachment' => trim($visa_attachments_files, ','),
                            'document_number' => $this->request->getPost('doc_visa_number'),
                            'document_date_of_expiry' => $this->request->getPost('doc_visa_expiry_date'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        ],
                        [
                            'employee_id' => lock($uid, 'decrypt'),
                            'doc_type' => 'visa',
                        ]
                    );

                }
                /* =====[ VISA DOCUMENTS UPLOAD :: END ]===== */


                /* =====[ EMIRATES DOCUMENTS UPLOAD :: START ]===== */
                if (!empty($this->request->getPost('doc_emirate_id_number')) || (isset($_FILES['doc_emirates_attachments']['name'][0]) && !empty($_FILES['doc_emirates_attachments']['name'][0]))) {

                    $emirates_attachments_files = '';
                    $employeeEmiratesDoc = _getWhere('sw_documents', ['employee_id' => lock($uid, 'decrypt'), 'doc_type' => 'emirates']);
                    if ($employeeEmiratesDoc) {
                        if (!empty($employeeEmiratesDoc->attachment)) {
                            $emirates_attachments_files .= $employeeEmiratesDoc->attachment ?? '';
                            $emirates_attachments_files .= ',';
                        }
                    }

                    $uploadedFiles_v4 = uploadFiles(ROOTPATH . 'public/documents/employee_document', 'doc_emirates_attachments');
                    if ($uploadedFiles_v4 !== false) {
                        if (is_array($uploadedFiles_v4)) {
                            $emirates_attachments_files .= implode(',', $uploadedFiles_v4); // successfully uploaded
                        } else {
                            $emirates_attachments_files .= $uploadedFiles_v4;
                        }
                    }

                    updateOrCreate(
                        'sw_documents',
                        [
                            'employee_id' => lock($uid, 'decrypt'),
                            'doc_type' => 'emirates',
                            'attachment' => trim($emirates_attachments_files, ','),
                            'document_number' => $this->request->getPost('doc_emirate_id_number'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        ],
                        [
                            'employee_id' => lock($uid, 'decrypt'),
                            'doc_type' => 'emirates',
                        ]
                    );

                }
                /* =====[ EMIRATES DOCUMENTS UPLOAD :: END ]===== */


                /* =====[ DRIVING LICENSE UPLOAD :: START ]===== */
                if (!empty($this->request->getPost('doc_driving_license_number')) || !empty($this->request->getPost('doc_driving_license_expiry_date')) || (isset($_FILES['doc_driving_license_attachments']['name'][0]) && !empty($_FILES['doc_driving_license_attachments']['name'][0]))) {

                    $driving_license_attachments_files = '';
                    $employeeDrivingLicensetDoc = _getWhere('sw_documents', ['employee_id' => lock($uid, 'decrypt'), 'doc_type' => 'driving_license']);
                    if ($employeeDrivingLicensetDoc) {
                        if (!empty($employeeDrivingLicensetDoc->attachment)) {
                            $driving_license_attachments_files .= $employeeDrivingLicensetDoc->attachment ?? '';
                            $driving_license_attachments_files .= ',';
                        }
                    }

                    $uploadedFiles_v5 = uploadFiles(ROOTPATH . 'public/documents/employee_document', 'doc_driving_license_attachments');
                    if ($uploadedFiles_v5 !== false) {
                        if (is_array($uploadedFiles_v5)) {
                            $driving_license_attachments_files .= implode(',', $uploadedFiles_v5); // successfully uploaded
                        } else {
                            $driving_license_attachments_files .= $uploadedFiles_v5;
                        }
                    }

                    updateOrCreate(
                        'sw_documents',
                        [
                            'employee_id' => lock($uid, 'decrypt'),
                            'doc_type' => 'driving_license',
                            'attachment' => trim($driving_license_attachments_files, ','),
                            'document_number' => $this->request->getPost('doc_driving_license_number'),
                            'document_date_of_expiry' => $this->request->getPost('doc_driving_license_expiry_date'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        ],
                        [
                            'employee_id' => lock($uid, 'decrypt'),
                            'doc_type' => 'driving_license',
                        ]
                    );

                }


                $uploadedFiles_v2 = uploadFiles(ROOTPATH . 'public/documents/profile', 'profile_photo');
                $profile_photo_title = '';
                if ($uploadedFiles_v2 !== false) {
                    if (is_array($uploadedFiles_v2)) {
                        $profile_photo_title = implode(',', $uploadedFiles_v2); // successfully uploaded
                    } else {
                        $profile_photo_title = $uploadedFiles_v2;
                    }
                } else {
                    $profile_photo_title = $empInfo->profile_photo;
                }


                $empPassword = '';
                if ($postData['new_password']) {
                    $empPassword = lock($postData['new_password']);
                } else {
                    $empPassword = $empInfo->password;
                }


                $isUpdated = _updateWhere('sw_employee', ['id' => lock($uid, 'decrypt')], [
                    'first_name' => $postData['FirstName'] ?? null,
                    'last_name' => $postData['LastName'] ?? null,
                    'profile_photo' => $profile_photo_title ?? null,
                    'primary_phone_no' => $postData['phone_number'] ?? null,
                    'primary_phone_code' => $postData['primaryPhoneCode'] ?? null,
                    'alternate_phone_no' => $postData['alternate_number'] ?? null,
                    'alternate_phone_code' => $postData['alternatePhoneCode'] ?? null,
                    'date_of_birth' => $postData['date_of_birth'] ?? null,
                    'permanent_country_list' => $postData['permanentCountryList'] ?? null,
                    'permanent_state_list' => $postData['permanentStateList'] ?? null,
                    'permanent_city_list' => $postData['permanentCityList'] ?? null,
                    'permanent_address' => $postData['permanent_address'] ?? null,
                    'residence_country_list' => $postData['residenceCountryList'] ?? null,
                    'residence_state_list' => $postData['residenceStateList'] ?? null,
                    'residence_city_list' => $postData['residenceCityList'] ?? null,
                    'residence_address' => $postData['residenceAddress'] ?? null,
                    'manpower_categories' => implode(',', $postData['manpowerCategories']) ?? null,
                    'timezone' => $postData['system_timezone'] ?? null,
                    'password' => $empPassword,
                    'job_description' => $postData['job_description'] ?? null,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

                try {

                    updateOrCreate(
                        'sw_employee_days',
                        [
                            'employee_id' => lock($uid, 'decrypt'),
                            'monday_start' => date("H:i:s", strtotime($postData['monday_start'])) ?? null,
                            'monday_end' => date("H:i:s", strtotime($postData['monday_end'])) ?? null,
                            'tuesday_start' => date("H:i:s", strtotime($postData['tuesday_start'])) ?? null,
                            'tuesday_end' => date("H:i:s", strtotime($postData['tuesday_end'])) ?? null,
                            'wednesday_start' => date("H:i:s", strtotime($postData['wednesday_start'])) ?? null,
                            'wednesday_end' => date("H:i:s", strtotime($postData['wednesday_end'])) ?? null,
                            'thursday_start' => date("H:i:s", strtotime($postData['thursday_start'])) ?? null,
                            'thursday_end' => date("H:i:s", strtotime($postData['thursday_end'])) ?? null,
                            'friday_start' => date("H:i:s", strtotime($postData['friday_start'])) ?? null,
                            'friday_end' => date("H:i:s", strtotime($postData['friday_end'])) ?? null,
                            'saturday_start' => date("H:i:s", strtotime($postData['saturday_start'])) ?? null,
                            'saturday_end' => date("H:i:s", strtotime($postData['saturday_end'])) ?? null,
                            'sunday_start' => date("H:i:s", strtotime($postData['sunday_start'])) ?? null,
                            'sunday_end' => date("H:i:s", strtotime($postData['sunday_end'])) ?? null,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        ],
                        [
                            'employee_id' => lock($uid, 'decrypt'),
                        ]
                    );

                } catch (\Exception $e) {

                }

                if ($isUpdated) {
                    return $this->response->setJSON(['success' => true, 'data' => '', 'msg' => 'Employee updated successfully.']);
                } else {
                    return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Employee not updated properly.']);
                }

                /* =====[ BUSINESS LOGIC :: END ]===== */


            } else {

                $today = date('Y-m-d');

                $db = \Config\Database::connect();
                $builder = $db->table('sw_schedules_list as schedule');
                $builder->select('schedule.*, customer.first_name as customer_first_name, customer.last_name as customer_last_name, categorie.category_title');
                $builder->join('sw_customers as customer', 'customer.id = schedule.customer_id', 'left');
                $builder->join('sw_categories as categorie', 'categorie.id = schedule.manpower_category_id', 'left');
                $builder->where(['manpower_id' => lock($uid, 'decrypt')]);
                $getScheduleList = $builder->get()->getResult();

                $employeeInfo = _getWhere('sw_employee', ['id' => lock($uid, 'decrypt')]);
                $employeeDays = _getWhere('sw_employee_days', ['employee_id' => lock($uid, 'decrypt')]);

                /* COUNT */
                $UpcomingSchedules = _getWhereCount('sw_schedules_list', ['admin_approval' => 'approval', 'schedule_date > ' => $today], 'yes');
                $TodaySchedules = _getWhereCount('sw_schedules_list', ['admin_approval' => 'approval', 'schedule_date' => $today], 'yes');

                if ($employeeInfo) {
                    $categories = _get('sw_categories');
                    return view('dashboard/user/employee-pofile', compact('employeeInfo', 'uid', 'categories', 'employeeDays', 'getScheduleList', 'UpcomingSchedules', 'TodaySchedules'));
                } else {
                    return redirect()->to(base_url(route_to('user.list')));
                }

            }

        } catch (\Exception $e) {

            //

        }


    }

    public function RemoveAjax()
    {

        try {

            if ($this->request->getMethod() === 'post') {

                /* =====[ VALIDATION :: START ]===== */
                $rules = [
                    "uid" => [
                        "label" => "Employee identity document",
                        "rules" => "required|trim"
                    ]
                ];

                if (!$this->validate($rules)) {
                    $errors = $this->validator->getErrors();
                    return $this->response->setJSON(['success' => false, 'msg' => 'Validation error', 'errors' => $errors, 'data' => null]);
                }

                /* =====[ VALIDATION :: END ]===== */

                /* =====[ BUSINESS LOGIC :: START ]===== */

                $postData = $this->request->getPost();
                $isDeleted = _delete('sw_manpower', ['id' => lock($postData['uid'], 'decrypt')]);
                if ($isDeleted) {
                    return $this->response->setJSON(['success' => true, 'data' => '', 'msg' => 'Employee deleted successfully!']);
                } else {
                    return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Employee not deleted properly.']);
                }

                /* =====[ BUSINESS LOGIC :: END ]===== */

            }

        } catch (\Exception $e) {

            prx([
                'getMessage' => $e->getMessage() ?? '',
                'getLine' => $e->getLine() ?? '',
            ]);

        }

    }

    public function RemoveDocAjax()
    {

        try {

            if ($this->request->getMethod() === 'post') {

                /* =====[ VALIDATION :: START ]===== */
                $rules = [
                    "docID" => [
                        "label" => "Document identity",
                        "rules" => "required|trim"
                    ],
                    "docTitle" => [
                        "label" => "Document title",
                        "rules" => "required|trim"
                    ]
                ];

                if (!$this->validate($rules)) {
                    $errors = $this->validator->getErrors();
                    return $this->response->setJSON(['success' => false, 'msg' => 'Validation error', 'errors' => $errors, 'data' => null]);
                }

                /* =====[ VALIDATION :: END ]===== */

                /* =====[ BUSINESS LOGIC :: START ]===== */

                $postData = $this->request->getPost();

                $docID = lock($postData['docID'], 'decrypt');
                $docTitle = lock($postData['docTitle'], 'decrypt');

                $isUpdated = remove_attachment('sw_documents', $docID, $docTitle);
                if ($isUpdated) {
                    return $this->response->setJSON(['success' => true, 'data' => '', 'msg' => 'Document deleted successfully!']);
                } else {
                    return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Document not deleted properly.']);
                }

                /* =====[ BUSINESS LOGIC :: END ]===== */

            }

        } catch (\Exception $e) {

            prx([
                'getMessage' => $e->getMessage() ?? '',
                'getLine' => $e->getLine() ?? '',
            ]);

        }

    }

    // public function manpStatusToggle()
    // {

    //     _registerFunction(['function_name' => 'manpower_remove', 'alias' => 'Manpower Remove', 'category' => 'Manpower']);
    //     _registerFunction(['function_name' => 'manpower_status_toggle', 'alias' => 'Manpower Status Toggle', 'category' => 'Manpower']);

    //     if (
    //         !authChecker('admin', [
    //             'manpower_remove',
    //             'manpower_status_toggle',
    //         ])
    //     ) {
    //         return $this->response->setJSON(['success' => 401, 'msg' => ACCESS_DENIED_MESSAGE]);
    //     }

    //     $manpId = lock($this->request->getPost('id'), 'decrypt');

    //     if ($this->request->getPost('action') == 'trash') {

    //         $query = _updateWhere('sw_trainers', ['id' => $manpId], ['trash' => 1]);

    //         if ($query) {
    //             return $this->response->setJSON(['success' => true, 'data' => '', 'msg' => 'Trashed successfully.']);
    //         } else {
    //             return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Could not trash.']);

    //         }
    //     } elseif ($this->request->getPost('action') == 'chngeStts') {


    //         $status = _getWhere('sw_trainers', ['id' => $manpId])->status;
    //         ($status == 1) ? $status = 0 : $status = 1;

    //         $query = _updateWhere('sw_trainers', ['id' => $manpId], ['status' => $status]);

    //         if ($query) {
    //             return $this->response->setJSON(['success' => true, 'data' => '', 'msg' => 'Status changed successfully.']);
    //         } else {
    //             return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Could not change status.']);

    //         }
    //     }
    // }

    public function StatusAjax() // not in user
    {

        try {

            if ($this->request->getMethod() === 'post') {

                /* =====[ VALIDATION :: START ]===== */
                $rules = [
                    "uid" => [
                        "label" => "Employee identity document",
                        "rules" => "required|trim"
                    ]
                ];

                if (!$this->validate($rules)) {
                    $errors = $this->validator->getErrors();
                    return $this->response->setJSON(['success' => false, 'msg' => 'Validation error', 'errors' => $errors, 'data' => null]);
                }

                /* =====[ VALIDATION :: END ]===== */

                /* =====[ BUSINESS LOGIC :: START ]===== */

                $postData = $this->request->getPost();

                $db = \Config\Database::connect();
                $builder = $db->table('sw_manpower');
                $builder = $builder->where('id', lock($postData['uid'], 'decrypt'));
                $builder->set('status', 'IF(status="active","inactive","active")', false);

                if ($builder->update()) {
                    return $this->response->setJSON(['success' => true, 'data' => '', 'msg' => 'Changes saved successfully!']);
                } else {
                    return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Changes not saved properly.']);
                }

                /* =====[ BUSINESS LOGIC :: END ]===== */

            }

        } catch (\Exception $e) {

            prx([
                'getMessage' => $e->getMessage() ?? '',
                'getLine' => $e->getLine() ?? '',
            ]);

        }

    }

    public function employeeDocumentAjax()
    {

        if ($this->request->getMethod() === 'post') {

            try {

                /* =====[ VALIDATION :: START ]===== */

                $rules = [
                    "employee" => [
                        "label" => "Employee",
                        "rules" => "required|trim"
                    ],
                    "document" => [
                        "label" => "Document",
                        "rules" => "required|trim"
                    ],
                ];

                if (!$this->validate($rules)) {
                    $errors = $this->validator->getErrors();
                    return $this->response->setJSON(['success' => false, 'msg' => 'Validation error', 'errors' => $errors, 'data' => null]);
                }

                /* =====[ VALIDATION :: END ]===== */
                $documentsResponse = [];
                $htmlImages = '';
                $postData = $this->request->getPost();
                $getDocuments = _getWhere('sw_documents', ['employee_id' => lock($postData['employee'], 'decrypt'), 'doc_type' => $postData['document']]);
                if ($getDocuments) {
                    unset($getDocuments->employee_id);
                    unset($getDocuments->updated_at);
                    if (!empty($getDocuments->attachment)) {
                        $getDocumentsArray = explode(',', $getDocuments->attachment);
                        foreach ($getDocumentsArray as $doc) {

                            $docID = lock($getDocuments->id);
                            $docTitle = lock($doc);
                            $image_path = base_url("documents/employee_document/" . $doc);
                            $htmlImages .= '<div class="image-input image-input-square">';
                            $htmlImages .= '<a href="' . $image_path . '" class="popup_gallery_box">';
                            $htmlImages .= '<div class="image-input-wrapper w-125px h-125px position-relative" style="background-image: url(' . $image_path . ')"></div>';
                            $htmlImages .= '</a>';
                            $htmlImages .= '<span onclick="removeEmployeeDocument(\'' . $docID . '\', \'' . $docTitle . '\')" class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow position-absolute top-0 end-0 bg-danger">';
                            $htmlImages .= '<i class="ki-outline ki-cross fs-3 text-white"></i>';
                            $htmlImages .= '</span>';
                            $htmlImages .= '</div>';

                        }
                    }

                    return $this->response->setJSON(['success' => true, 'msg' => '', 'errors' => null, 'data' => $getDocuments, 'images' => $htmlImages]);

                } else {
                    //echo 'no document found';
                }

            } catch (\Exception $e) {

                prx([
                    'getMessage' => $e->getMessage() ?? '',
                    'getLine' => $e->getLine() ?? '',
                ]);

            }

        } else {

            prx('The requested resource does not support http method.');
        }

    }


    public function addTestimonial()
    {


        _registerFunction(['function_name' => 'add_testimonial', 'alias' => 'Add Testimonials', 'category' => 'Testimonials']);
        _registerFunction(['function_name' => 'testimonial_edit', 'alias' => 'Testimonial Edit', 'category' => 'Testimonials']);


        if (
            !authChecker('admin', [
                'add_testimonial',
                'testimonial_edit'
            ])
        ) {
            return redirect()->route('dashboard.index');
        }

        if ($this->request->getMethod() === 'post') {

            $postData = $this->request->getPost();
            $testId = lock($postData['test'], 'decrypt');
            $rules = [
                "name" => [
                    "label" => "Name",
                    "rules" => "required|trim"
                ],
                "comment" => [
                    "label" => "Comment",
                    "rules" => "required|trim|max_length[500]"
                ],
                "rating" => [
                    "label" => "Rating",
                    "rules" => "required|numeric"
                ],
                "profession" => [
                    "label" => "Services",
                    "rules" => "required"
                ],

            ];

            if ($testId == '') { // in case of add new pckage
                $rules['image'] = [
                    'label' => 'Image',
                    'rules' => 'uploaded[image]|mime_in[image,image/jpeg,image/jpg]|max_dims[image,500,500]',
                    'errors' => [
                        'uploaded' => 'Please select an image to upload',
                        // 'max_size' => 'The profile image file size cannot exceed 5MB',
                        'mime_in' => 'The profile image must be a JPG file',
                        'max_dims' => 'The profile image dimensions cannot exceed 500x500 pixels',
                    ],
                ];
            } else {
                $rules['image'] = [
                    'label' => 'Image',
                    'rules' => 'permit_empty|uploaded[image]|mime_in[image,image/jpeg]|max_dims[image,500,500]',
                    'errors' => [
                        'uploaded' => 'Please select an image to upload',
                        // 'max_size' => 'The profile image file size cannot exceed 5MB',
                        'mime_in' => 'The profile image must be a JPG file',
                        'max_dims' => 'The profile image dimensions cannot exceed 500x500 pixels',
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

                move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/testimonials/" . $newfilename);
            } else {
                $newfilename = null;
            }

            if ($testId == '') {

                $isInsert = _insert('sw_testimonials', [
                    'name' => $postData['name'],
                    'profession' => $postData['profession'],
                    'rating' => $postData['rating'],
                    'comment' => $this->db->escapeString($postData['comment']),
                    'image' => $newfilename,
                ]);

                if ($isInsert) {
                    return $this->response->setJSON(['success' => true, 'data' => '', 'msg' => 'Testimonial added successfully.']);
                } else {
                    return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Testimonial not added.']);
                }
            } else {
                if ($newfilename == '') {

                    $isUpdate = _updateWhere('sw_testimonials', ['id' => $testId], [
                        'name' => $postData['name'],
                        'profession' => $postData['profession'],
                        'rating' => $postData['rating'],
                        'comment' => $this->db->escapeString($postData['comment']),
                    ]);

                } else {

                    $isUpdate = _updateWhere('sw_testimonials', ['id' => $testId], [
                        'name' => $postData['name'],
                        'profession' => $postData['profession'],
                        'rating' => $postData['rating'],
                        'comment' => $this->db->escapeString($postData['comment']),
                        'image' => $newfilename,
                    ]);

                }


                if ($isUpdate) {
                    return $this->response->setJSON(['success' => true, 'data' => '', 'msg' => 'Testimonial updated successfully.']);
                } else {
                    return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Testimonial not updated.']);
                }
            }



        } else {

            return view('dashboard/testimonials/add-testimonial');
        }

    }

    public function testimonialList()
    {
        $data['testimonials'] = _getWhere('sw_testimonials', ['trash' => 0], 'yes');
        return view('dashboard/testimonials/testimonials-list', $data);
    }

    public function testimonialEdit($testId)
    {
        $data['test_data'] = _getWhere('sw_testimonials', ['id' => lock($testId, 'decrypt')]);
        return view('dashboard/testimonials/add-testimonial', $data);
    }

    public function testimonialStatus()
    {

        _registerFunction(['function_name' => 'testimonial_status_toggle', 'alias' => 'Testimonial Status Toggle', 'category' => 'Testimonials']);
        _registerFunction(['function_name' => 'testimonial_remove', 'alias' => 'Testimonial Remove', 'category' => 'Testimonials']);


        if (
            !authChecker('admin', [
                'testimonial_status_toggle',
                'testimonial_remove',
            ])
        ) {
            return $this->response->setJSON(['success' => 401, 'msg' => ACCESS_DENIED_MESSAGE]);
        }

        $trnrId = lock($this->request->getPost('id'), 'decrypt');

        if ($this->request->getPost('action') == 'trash') {

            $query = _updateWhere('sw_testimonials', ['id' => $trnrId], ['trash' => 1]);

            if ($query) {
                return $this->response->setJSON(['success' => true, 'data' => '', 'msg' => 'Trashed successfully.']);
            } else {
                return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Could not change status.']);

            }
        } elseif ($this->request->getPost('action') == 'chngeStts') {


            $status = _getWhere('sw_testimonials', ['id' => $trnrId])->status;
            ($status == 1) ? $status = 0 : $status = 1;

            $query = _updateWhere('sw_testimonials', ['id' => $trnrId], ['status' => $status]);

            if ($query) {
                return $this->response->setJSON(['success' => true, 'data' => '', 'msg' => 'Status changed successfully.']);
            } else {
                return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Could not change status.']);

            }
        }

    }

}