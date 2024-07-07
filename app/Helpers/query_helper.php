<?php

if ( !function_exists( "_get" ) ) {
    function _get( $table )
    {
        $db      = \Config\Database::connect();
        $builder = $db->table( $table );
        return $builder->get()->getResult();
    }
}
/*
		_get('vt_roles');
*/

if (!function_exists('_getOrderBy')) {
    function _getOrderBy($table, $orderBy = 'DESC')
    {
        $db = \Config\Database::connect();
        $builder = $db->table($table);
        $builder->orderBy('id', $orderBy);
        return $builder->get()->getResult();
    }
}
/*
		_getOrderBy('vt_roles');
*/

/*
		_getLastRow('vt_roles');
*/

if (!function_exists('_getLastRow')) {
    function _getLastRow($table, $orderBy = 'DESC')
    {
        $db = \Config\Database::connect();
        $builder = $db->table($table);
        $builder->orderBy('id', $orderBy);
        $builder->limit(1);
        return $builder->get()->getRow();
    }
}
/*
		_getLastRow('vt_roles');
*/




if ( !function_exists( "_getDESC" ) ) {
    function _getDESC( $table,  $multipleRow = 'no' )
    {
        $db = \Config\Database::connect();
        $builder = $db->table( $table );
        $builder = $builder->orderBy( 'id' , 'DESC' );
        $builder = $builder->limit( 1 );

        if ( $multipleRow == 'no' ) {
            return $builder->get()->getRow();
        } else {
            return $builder->get()->getResult();
        }
       
    }
}


if ( !function_exists( "_getWhere" ) ) {
    function _getWhere( $table, $whereCondition, $multipleRow = 'no' )
    {
        $db = \Config\Database::connect();
        $builder = $db->table( $table );
        $builder = $builder->where( $whereCondition );

        if ( $multipleRow == 'no' ) {
            return $builder->get()->getRow();
        } else {
            return $builder->get()->getResult();
        }
       
    }
}
/*
    _getWhere('vt_roles', ['id' => 1]); // Single Data
    _getWhere('vt_roles', ['plan' => 2], 'yes'); // Multiple Data
	_getWhere('vt_roles', ['plan' => 2, 'id != ' => 123], 'yes'); // Multiple Data
*/


if (!function_exists("_getWhereAsc")) {
    function _getWhereAsc($table, $whereCondition, $multipleRow = 'no')
    {
        $db = \Config\Database::connect();
        $builder = $db->table($table);
        $builder = $builder->where($whereCondition);
        $builder = $builder->orderBy('id', 'ASC');

        if ($multipleRow == 'no') {
            return $builder->get()->getRow();
        } else {
            return $builder->get()->getResult();
        }

    }
}
/*
    _getWhereAsc('vt_roles', ['id' => 1]); // Single Data
    _getWhereAsc('vt_roles', ['plan' => 2], 'yes'); // Multiple Data
    _getWhereAsc('vt_roles', ['plan' => 2, 'id != ' => 123], 'yes'); // Multiple Data
*/


if ( !function_exists( "_getWhereCount" ) ) {
    function _getWhereCount( $table, $whereCondition, $multipleRow = 'no' )
    {
        $db = \Config\Database::connect();
        $builder = $db->table( $table );
        $builder = $builder->where( $whereCondition );

        if ( $multipleRow == 'no' ) {
            $resultCount = $builder->get()->getRow();
            return count($resultCount);
        } else {
            $resultCount = $builder->get()->getResult();
            return count($resultCount);
        }
       
    }
}
/*
    _getWhereCount('vt_roles', ['id' => 1]); // Single Data
    _getWhereCount('vt_roles', ['plan' => 2], 'yes'); // Multiple Data
	_getWhereCount('vt_roles', ['plan' => 2, 'id != ' => 123], 'yes'); // Multiple Data
*/



if ( !function_exists( "_getWhereCommaSeprated" ) ) {
    function _getWhereCommaSeprated( $table, $ids, $columnName='id' )
    {
        $db      = \Config\Database::connect();
        $builder = $db->table( $table );
        $builder->whereIn( $columnName, explode( ",", $ids ) );
        return $builder->get()->getResult();
    }
}
/*
    _getWhereCommaSeprated('vt_question_bank', '80,121,83,84,114');
    _getWhereCommaSeprated('vt_question_bank', '80,121,83,84,114', 'question_id');
*/



if ( !function_exists( "_getWhereIn" ) ) {
    function _getWhereIn( $table, $whereCondition, $columnName='id' )
    {
        try {
    
            $db      = \Config\Database::connect();
            $builder = $db->table( $table );
            $builder->whereIn( $columnName, $whereCondition );
            return $builder->get()->getResult();
    
        } catch ( \Exception $e ) {
            return $e->getMessage() ?? '';
        }
    }

}
/*
	_getWhereIn( 'users', [1, 2, 3, 4, 5]);                          // WHERE id IN (1, 2, 3, 4, 5);
    _getWhereIn( 'users', [1, 2, 3, 4, 5], 'UserProfileID' );        // WHERE UserProfileID IN (1, 2, 3, 4, 5);
*/




if ( !function_exists( "_getWhereNotIn" ) ) {
    function _getWhereNotIn( $table, $whereCondition, $columnName='id' )
    {
        try {
    
            $db      = \Config\Database::connect();
            $builder = $db->table( $table );
            $builder->whereNotIn( $columnName, $whereCondition );
            return $builder->get()->getResult();
    
        } catch ( \Exception $e ) {
            return $e->getMessage() ?? '';
        }
    }

}
/*
	_getWhereNotIn( 'users', [1, 2, 3, 4, 5]);                          // WHERE id NOT IN (1, 2, 3, 4, 5);
    _getWhereNotIn( 'users', [1, 2, 3, 4, 5], 'UserProfileID' );        // WHERE UserProfileID NOT IN (1, 2, 3, 4, 5);
*/



if ( !function_exists( "_updateWhere" ) ) {
    function _updateWhere( $table, $whereCondition, $data )
    {
        $db      = \Config\Database::connect();
        $builder = $db->table( $table );
        $builder = $builder->where( $whereCondition );

        if ( $builder->update( $data ) ) {
            return true;
        } else {
            return false;
        }
    }
}
/*
		_updateWhere( 'user_profile', ['id' => $userid], [
			'status' => 'active',
		] );
 */




if ( !function_exists( "_insert" ) ) {
    function _insert( $table, $data )
    {
        $db      = \Config\Database::connect();
        $builder = $db->table( $table );
        
        if ( $builder->insert( $data ) ) {
            return $db->insertID();
        } else {
            return false;
        }
    }
}
/*
		_insert('users', ['fname'=>'abc', 'lname'=>'xyz']);
*/



if ( !function_exists( "_delete" ) ) {
    function _delete( $table, $where )
    {
        $db      = \Config\Database::connect();
        $builder = $db->table( $table );
        $builder->where( $where );
        if($builder->delete()){
            return true;
        }else{
            return false;
        }
    }
}
/*
		_delete('users', ['id' => 1, 'status' => 'inactive'])
*/



if ( !function_exists( "_tableColumn" ) ) {
    function _tableColumn( $table )
    {

        try {

            $db          = \Config\Database::connect();
            $columnArray = [];
            $query       = $db->query( 'SHOW COLUMNS FROM ' . $table );
            $Results     = $query->getResult();
            if ( $Results ) {
                foreach ( $Results as $Result ) {
                    $columnArray += [
                        $Result->Field => ''
                    ];
                }
                return $columnArray;
            } else {
                return $columnArray;
            }

        }
        catch ( \Exception $e ) {
            return $e->getMessage() ?? '';
        }

    }
}
/*
		_tableColumn('users')   // Return users table column name
*/




function remove_attachment($table, $id, $filename) {
    $data = [
        'attachment' => '',
    ];
    
    $db = \Config\Database::connect();
    $builder = $db->table($table);
    $builder->where('id', $id);
    
    $row = $builder->get()->getRow();
    
    if ($row) {
        $attachments = explode(',', $row->attachment);
        $new_attachments = [];
    
        foreach ($attachments as $attachment) {
            if ($attachment != $filename) {
                $new_attachments[] = $attachment;
            }
        }
    
        $data['attachment'] = implode(',', $new_attachments);
    
        $builder->update($data);
        
        if ($db->affectedRows() == 1) {
            return true;
        }
    }
    
    return false;
}



/**
 * Updates a record if it exists, or creates a new record if it doesn't.
 *
 * @param string $table The name of the table to update or create a record in.
 * @param array $data The data to update or create the record with.
 * @param array $where An optional associative array of WHERE clause conditions to match when updating a record.
 *
 * @return mixed The ID of the updated or created record, or false if there was an error.
 */
function updateOrCreate($table, $data, $where = [])
{
    $db = \Config\Database::connect();

    // Check if a record already exists that matches the WHERE clause conditions
    $query = $db->table($table)->select('id')->where($where)->limit(1)->get();
    $row = $query->getRow();
    // If a record exists, update it with the provided data
    if ($row) {
        $db->table($table)->where($where)->update($data);
        return $row->id;
    }else {
        $db->table($table)->insert($data);
        return $db->insertID();
    }

    // Return false if there was an error
    return false;
}
/*

    $isUpdateOrCreate = updateOrCreate('users',
    [
        'employee_id' => lock($uid, 'decrypt'),
        'document_name' => $this->request->getPost('doc_passport_name'),
        'doc_type' => 'passport',
        'attachment' => $passport_attachments_files,
        'document_number' => $this->request->getPost('doc_passport_no'),
        'document_date_of_issue' => $this->request->getPost('doc_passport_date_of_issue'),
        'document_date_of_expiry' => $this->request->getPost('doc_passport_date_of_expiry'),
        'updated_at' => date('Y-m-d H:i:s'),
    ],
    [
        'employee_id' => lock($uid, 'decrypt')          // WHERE CONDITION
    ]);

    if ($isUpdateOrCreate !== false) {
        echo 'Record updated or created successfully. ID: ' . $isUpdateOrCreate;
    } else {
        echo 'Error updating or creating record.';
    }

*/


function recurse_fron_cat_data($cat_name) {
    $db = \Config\Database::connect();
    $builder = $db->table( 'sw_front_functions as f' );
    $builder->select( 'f.*' );
    $builder = $builder->where( ['category' => $cat_name] );      
    return $data = $builder->get()->getResultArray();
}

function _fetch_table_row_data( $table, $whereCondition )
{
    $db = \Config\Database::connect();
    $builder = $db->table( $table );
    if ( !empty( $whereCondition ) ) {
        $builder = $builder->where( $whereCondition );
    }
   // prx($builder->LastQuery());
    return $builder->get()->getRowArray();   // single record
}



function _fetch_front_function_cat_alias(){
    $db = \Config\Database::connect();
    $builder = $db->table( 'sw_front_functions as f' );
    $builder->select( 'f.*' );
    $builder->groupBy( 'f.category' );        
    $data = $builder->get()->getResultArray();

    if(!empty($data)){
        foreach ($data as $key => $value) {            
            $cat_data = recurse_fron_cat_data($value['category']);

            if(!empty($cat_data)){
                $data[$key]['category_data'] = $cat_data;
            }
            else{
                $data[$key]['category_data'] = array();  
            }
        }
        return $data;

    }
    else{
        $data = array();
    }
}


if ( !function_exists( "_update_table_common" ) ) {
    function _update_table_common( $table, $data, $whereCondition )
    {
        $db = \Config\Database::connect();
        $builder = $db->table( $table );
        $builder = $builder->where( $whereCondition );
        if ( $builder->update( $data ) ) {
            return true;
        } else {
            return false;
        }
    }
}



if (!function_exists("_registerFunction")) {
    function _registerFunction($whereCondition)
    {
        try {
            $db = \Config\Database::connect();
            $builder = $db->table('sw_front_functions');
            $builder->where($whereCondition);
            $isExists = $builder->get()->getRow();
            if ($isExists) {
                // Function already exists
            } else {
                $insert = $db->table('sw_front_functions');
                if (!is_array($whereCondition)) {
                    $whereCondition = [];
                }

                $whereCondition += [
                    'controller_name' => 'admin',
                    'status' => 1,
                    'created_on' => date('Y-m-d H:i:s')
                ];

                $insert->insert($whereCondition);
            }
        } catch (\PDOException $e) {
            // Handle the database exception here
            // For example, you can log the error, display a message, or perform other actions.
            // You can access the exception message using $e->getMessage() and other details if needed.
        } catch (\Exception $e) {
            // Handle other types of exceptions here, if necessary
        }
    }
}


/*
    _registerFunction([
        'function_name' => 'test',
        'alias' => 'Testing function',
        'category' => 'dashboard'
    ]);
*/