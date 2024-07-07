<?php

namespace App\Controllers;

class RolesController extends BaseController
{

    public function roles()
    {
        try {

            if ($this->request->getMethod() === 'post') {

                _registerFunction(['function_name' => 'security_permission_new_role_create', 'alias' => 'New Role Create', 'category' => 'Security Permission']);
                if (
                    !authChecker('admin', [
                        'security_permission_new_role_create',
                    ])
                ) {
                    return $this->response->setJSON(['success' => 401, 'msg' => ACCESS_DENIED_MESSAGE]);
                }

                /* =====[ VALIDATION :: START ]===== */

                $rules = [
                    "name" => [
                        "label" => "Name",
                        "rules" => "required|trim",
                    ],
                    "status" => [
                        "label" => "status",
                        "rules" => "required|trim|alpha"
                    ],
                ];

                if (!$this->validate($rules)) {
                    $errors = $this->validator->getErrors();
                    return $this->response->setJSON(['success' => false, 'msg' => reset($errors), 'errors' => $errors, 'data' => null]);
                }

                /* =====[ VALIDATION :: END ]===== */

                $postData = $this->request->getPost();
                $nameExist = _getWhere('sw_roles_type', ['title' => $postData['name'], 'status' => 'active', 'trash' => '0']);
                if ($nameExist) {
                    return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'This name already exists']);
                } else {
                    $isInsert = _insert('sw_roles_type', [
                        'title' => $postData['name'],
                        'status' => $postData['status'],
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);

                    if ($isInsert) {
                        return $this->response->setJSON(['success' => true, 'data' => '', 'msg' => 'Role inserted successfully.']);
                    } else {
                        return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Role not inserted properly.']);
                    }

                }


            } else {

                return view('dashboard/setting/roles_types');
            }


        } catch (\Exception $e) {

            prx([
                'getMessage' => $e->getMessage() ?? '',
                'getLine' => $e->getLine() ?? '',
            ]);

        }

    }

    public function list()
    {

        _registerFunction(['function_name' => 'roles_capabilities_list_and_edit', 'alias' => 'Roles Capabilities List & Edit', 'category' => 'Security Permission']);
        if (
            !authChecker('admin', [
                'roles_capabilities_list_and_edit',
            ])
        ) {
            session()->set('error', 'access_denied');
            
            return redirect()->to(base_url(route_to('dashboard.index')));
        }

        $roles = _getWhereAsc('sw_roles_type', ['trash' => 0], 'yes');
        return view('dashboard/setting/roles_privileges_list', compact('roles'));
    }

    public function setting()
    {
        _registerFunction(['function_name' => 'settings_management', 'alias' => 'Settings Management', 'category' => 'Settings']);
        if (
            !authChecker('admin', [
                'settings_management',
            ])
        ) {
            return redirect()->to(base_url(route_to('dashboard.index')));
        }

        return view('dashboard/setting/setting');
    }

    public function rolesList()
    {
        helper('dev_helper');
        try {
            _registerFunction(['function_name' => 'security_permission_role_edit', 'alias' => 'Role Edit', 'category' => 'Security Permission']);
            _registerFunction(['function_name' => 'security_permission_role_remove', 'alias' => 'Role Remove', 'category' => 'Security Permission']);
            _registerFunction(['function_name' => 'security_permission_role_list', 'alias' => 'Role List', 'category' => 'Security Permission']);
            if (
                !authChecker('admin', [
                    'security_permission_role_list',
                ])
            ) {
                return $this->response->setJSON(['success' => 401, 'msg' => ACCESS_DENIED_MESSAGE]);
            }

            $html = '';
            $roles = _getWhere('sw_roles_type', ['trash' => 0], 'yes');
            if ($roles) {

                $tableHeader = <<<TABLEHEADER
    <table class="table table-striped table-hover" id="dataTable">
    <thead>
        <tr>
            <th scope="col">SL</th>
            <th scope="col">Role name</th>
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
                foreach ($roles as $role) {
                    $html .= '<tr id="' . lock($role->id) . '">';
                    $html .= '<th scope="row">' . $i . '</th>';
                    $html .= '<td>' . $role->title . '</td>';
                    if ($role->editable == 'no' || $role->id == 19) { // Trainer
                        $html .= '<td>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" checked disabled>
                            </div>
                        </td>';
                    } else {
                        $roleStatus = $role->status == 'active' ? 'checked' : '';
                        $html .= '<td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" onClick="rolesStatusToggle(\'' . lock($role->id) . '\')" role="switch" ' . $roleStatus . '>
                                    </div>
                                </td>';
                    }
                    if ($role->editable == 'no' || $role->id == 19) { //Trainer id 19
                        $html .= '<td><span class="not_editable">Not Editable</span></td>';
                    } else {
                        $html .= '<td>';

                        if (
                            authChecker('admin', [
                                'security_permission_role_edit',
                            ])
                        ) {
                            $html .= '<a href="' . base_url(route_to('roles.edit', lock($role->id))) . '" class="text-primary"><i class="fa fa-edit"></i> </a>  &nbsp;  ';
                        }

                        if (
                            authChecker('admin', [
                                'security_permission_role_remove',
                            ])
                        ) {
                            $html .= '<a href="javascript:void(0)" onClick="removeRoles(\'' . lock($role->id) . '\')" class="text-danger"><i class="fa fa-trash"></i></a>';
                      
                            
                        }

                        $html .= '</td>';
                    }

                    $html .= '</tr>';
                    $i++;
                }

                $html = str_replace('{{TABLE_HTML_BODY}}', $html, $tableHeader);

            } else {

                $emptyImage = base_url('dashboard_assets/media/illustrations/sketchy-1/16.png');
                $html = <<<TABLEEMPTY
    <h2 class="text-center fs-2x fw-bold mb-0">Create your role</h2>
    <p class="text-center text-gray-400 fs-4 fw-semibold py-7">Build a role to bring your service to life.<br>Launch a Freehand to colloborate in real time.</p>
    <div class="text-center pb-15 px-5">
    <img src="{$emptyImage}" alt="" class="mw-100 h-200px h-sm-325px">          
    </div>
    TABLEEMPTY;

            }

            return $this->response->setJSON(['success' => true, 'data' => $html, 'msg' => 'fetch record successfully.']);

        } catch (\Exception $e) {
            //
        }

    }

    public function removeRole()
    {

        _registerFunction(['function_name' => 'security_permission_role_remove', 'alias' => 'Role Remove', 'category' => 'Security Permission']);
        if (
            !authChecker('admin', [
                'security_permission_role_remove',
            ])
        ) {
            return $this->response->setJSON(['success' => 401, 'msg' => ACCESS_DENIED_MESSAGE]);
        }


        $roleId = lock($this->request->getPost()['uuid'], 'decrypt');

        $isUpdate = _updateWhere('sw_roles_type', ['id' => $roleId], [
            'status' => 'inactive',
            'trash' => 1,
        ]);

        if ($isUpdate) {
            return $this->response->setJSON(['success' => true, 'data' => '', 'msg' => 'Role deleted successfully.']);
        } else {
            return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Could not delete.']);
        }

    }

    public function StatusAjax()
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
                $builder = $db->table('sw_roles_type');
                $builder = $builder->where('id', lock($postData['uid'], 'decrypt'));
                $builder->set('status', 'IF(status="active","inactive","active")', FALSE);

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

    public function roleCapabilities($roleid)
    {

        $roleid_get = lock($roleid, 'decrypt');

        $infoGet = _getWhere('sw_roles_type', ['id' => $roleid_get]);

        if ($infoGet) {

            if ($infoGet->editable == 'no') {session()->set('error', 'access_denied');
            
                return redirect()->to(base_url(route_to('dashboard.index')));
            }

        } else {
        session()->set('error', 'access_denied');
        
             return redirect()->to(base_url(route_to('dashboard.index')));
        }

        $datasend['roleid_get'] = $roleid_get;
        $datasend['encrpyt_roldeid'] = $roleid;
        $datasend['role_get_row'] = _fetch_table_row_data($table = 'sw_roles_type', $whereCondition = array('id' => $roleid_get));
        $datasend['front_function_cat_alias'] = _fetch_front_function_cat_alias();

        // print_r($datasend);
        // die();
        if ($this->request->getMethod() === 'post') {

            /* =====[ VALIDATION :: START ]===== */
            $rules = [
                "permission_alias" => [
                    "label" => "Roles Capability",
                    "rules" => "required",
                ],
            ];

            if (!$this->validate($rules)) {
                $errors = $this->validator->getErrors();
                return $this->response->setJSON(['success' => false, 'msg' => reset($errors), 'errors' => $errors, 'data' => null]);
            }
            /* =====[ VALIDATION :: END ]===== */



            /* ====[ Roles & Permission ]==== */
            //if((!authChecker('admin', 'rolesManagement_edit'))) { return redirect()->to(route_to('access.denied')); }

            $roleid_get;
            $postData = $this->request->getPost();
            $permission_alias = $postData['permission_alias'];
            $array_get = array();
            if (!empty($permission_alias)) {
                foreach ($permission_alias as $key => $value) {
                    if (!empty($value)) {
                        $array_get[] = $value;
                    }
                }
            }
            $permission_alias = $array_get;
            if (!empty($permission_alias)) {
                $permission_alias_val = array_values($permission_alias);

                $permission_alias = implode(',', $permission_alias);

                $verify_set_permission_tbl = _fetch_table_row_data($table = 'sw_set_permission', $whereCondition = array('role_id' => $roleid_get));
                if (!empty($verify_set_permission_tbl)) {
                    $update_data = array(
                        'function_id' => $permission_alias
                    );

                    _update_table_common($table = 'sw_set_permission', $update_data, $whereCondition = array('role_id' => $roleid_get));
                    return $this->response->setJSON(['success' => true, 'msg' => 'Permission Updated Successfully.', 'errors' => null, 'data' => null]);

                } else {
                    $insert_data = array(
                        'role_id' => $roleid_get,
                        'function_id' => $permission_alias
                    );
                    $result = _insert($table = 'sw_set_permission', $insert_data);
                    return $this->response->setJSON(['success' => true, 'msg' => 'Permission Added Successfully.', 'errors' => null, 'data' => null]);
                }

            } else {

                return $this->response->setJSON(['success' => false, 'msg' => 'Please Select Permission.', 'errors' => null, 'data' => null]);
            }

        }
        $datasend['permisson_get_row'] = _fetch_table_row_data($table = 'sw_set_permission', $whereCondition = array('role_id' => $roleid_get));
        // print_r($roleid_get);die();
        /* ====[ Roles & Permission ]==== */
        //if((!authChecker('admin', 'rolesManagement_edit'))) { return redirect()->to(route_to('access.denied')); }
        return view('dashboard/setting/roles', $datasend);
    }

    public function edit($uuid)
    {

        _registerFunction(['function_name' => 'security_permission_role_edit', 'alias' => 'Role Edit', 'category' => 'Security Permission']);
        if (
            !authChecker('admin', [
                'security_permission_role_edit',
            ])
        ) {
        session()->set('error', 'access_denied');
        
            return redirect()->to(base_url(route_to('dashboard.index')));
            
            //   return redirect()->route('dashboard.index');
        }


        if ($this->request->getMethod() === 'post') {

            try {

                /* =====[ VALIDATION :: START ]===== */

                $rules = [
                    "name" => [
                        "label" => "Role name",
                        "rules" => "required|trim"
                    ],
                    "status" => [
                        "label" => "Role status",
                        "rules" => "required|trim"
                    ],
                ];

                if (!$this->validate($rules)) {
                    $errors = $this->validator->getErrors();
                    return $this->response->setJSON(['success' => false, 'msg' => reset($errors), 'errors' => $errors, 'data' => null]);
                }

                /* =====[ VALIDATION :: END ]===== */
                $postData = $this->request->getPost();
                $existTitle = _getWhere('sw_roles_type', ['status' => 'active', 'trash' => '0', 'title' => $postData['name'], 'id != ' => lock($uuid, 'decrypt')]);

                if ($existTitle != '') {
                    return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'This name already exists.']);

                } else {
                    $isUpdated = _updateWhere('sw_roles_type', ['id' => lock($uuid, 'decrypt')], [
                        'title' => $postData['name'] ?? NULL,
                        'status' => $postData['status'] ?? NULL,
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);

                    if ($isUpdated) {
                        return $this->response->setJSON(['success' => true, 'data' => '', 'msg' => 'Role updated successfully.']);
                    } else {
                        return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Role not updated properly.']);
                    }
                }


            } catch (\Exception $e) {

                prx([
                    'getMessage' => $e->getMessage() ?? '',
                    'getLine' => $e->getLine() ?? '',
                ]);

            }

        } else {

            $getInfo = _getWhere('sw_roles_type', ['id' => lock($uuid, 'decrypt')]);
            return view('dashboard/setting/roles_types_edit', compact('getInfo', 'uuid'));

        }

    }

    public function remove($uid)
    {

        try {

            _registerFunction(['function_name' => 'security_permission_role_remove', 'alias' => 'Role Remove', 'category' => 'Security Permission']);
            if (
                !authChecker('admin', [
                    'security_permission_role_remove',
                ])
            ) {
                return $this->response->setJSON(['success' => 401, 'msg' => ACCESS_DENIED_MESSAGE]);
            }

            if ($this->request->getMethod() === 'post') {
                $isDeleted = _delete('sw_roles_type', ['id' => lock($uid, 'decrypt')]);
                if ($isDeleted) {
                    return $this->response->setJSON(['success' => true, 'data' => '', 'msg' => 'Role deleted successfully!']);
                } else {
                    return $this->response->setJSON(['success' => false, 'data' => '', 'msg' => 'Role not deleted properly.']);
                }
            }

        } catch (\Exception $e) {
            //
        }

    }

}