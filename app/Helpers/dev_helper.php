<?php

if (!function_exists("prx")) {
    function prx($x, $exit = 0)
    {
        echo '<h1 style="top:0;position:fixed;color:white;background:red;text-align:center;width:30%;right:0;">PAGE UNDER CONSTRACTION</h1>';
        echo $res = "<pre>";
        if (is_array($x) || is_object($x)) {
            echo print_r($x);
        } else {
            echo var_dump($x);
        }
        echo "</pre>";
        if ($exit == 0) {
            die();
        }
    }
}
function encrypt_decrypt($string, $action = 'encrypt')
{
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'Rsale_1_8392_KG'; // user define private key
    $secret_iv = 'vAidEerrgf5HJ5g27'; // user define secret key
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16); // sha256 is hash_hmac_algo
    if ($action == 'encrypt') {
        $output = openssl_encrypt(json_encode($string), $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if ($action == 'decrypt') {
        $output = json_decode(openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv));
    }
    return $output;
}
// function isLastOtpValid_v2(string $email, int $minute, int $otp): bool
// {
//     $db = \Config\Database::connect();
//     $builder = $db->table('sw_otp');
//     $builder->select('*');
//     $builder->where('email', $email);
//     // $builder->where('code', $otp);
//     $builder->where('is_used', 'no');
//     $builder->orderBy('id', 'DESC');
//     $builder->limit(1);
//     $lastOtp = $builder->get()->getRow();

//     if (!$lastOtp) {
//         return false;
//     }
    
//     if (isset($lastOtp->code)){
//         if( $lastOtp->code != $otp ){
//             return false;
//         }
//     }

//     $lastOtpTime = strtotime($lastOtp->created_at);
//     $currentTime = time();
//     $timeDiff = $currentTime - $lastOtpTime;
//     $minuteDiff = round($timeDiff / 60);

//     return ($minuteDiff <= $minute);
// }


if (!function_exists("isLoggedIn")) {
    function isLoggedIn()
    {
        if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
            return true;
        } else {
            echo false;
        }
    }
}

if (!function_exists("loginUserDet")) {
    function loginUserDet()
    {
        $arr = [];
        if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
            $arr = _getWhere('sw_app_userinfo', ['id' => $_SESSION['id']]);

        }
        return $arr;
    }
}


if (!function_exists("getDayPart")) {
    function getDayPart()
    {
        date_default_timezone_set("Asia/Kolkata");

        $currentTime = date('H:i:s');

        if ($currentTime >= '04:00:00' && $currentTime < '12:00:00') {
            return 'Good Morning';
        } elseif ($currentTime >= '12:00:00' && $currentTime < '16:00:00') {
            return 'Good Afternoon';
        } else {
            return 'Good Evening';
        }
    }
}

function basketItems()
{
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
        return array_unique($values);

    } else {
        $arr = [];
        return $arr;
    }
}


if (!function_exists("pr")) {
    function pr($x, $exit = 0)
    {
        echo $res = "<pre>";
        if (is_array($x) || is_object($x)) {
            print_r($x);
        } else {
            echo var_dump($x);
        }
        echo "</pre>";
        if ($exit == 0) {
            die();
        }
    }
}


if (!function_exists("safe")) {
    function safe($data)
    {
        return trim(strip_tags($data));
    }
}


if (!function_exists("safe_html")) {
    function safe_html($data)
    {
        return trim(htmlspecialchars($data));
    }
}


function getNameInitials($fullName)
{
    // Remove any non-alphabetic characters and convert to uppercase
    $cleanedName = preg_replace('/[^a-zA-Z ]/', '', $fullName);
    $cleanedName = strtoupper($cleanedName);

    // Split the name into words
    $words = explode(" ", $cleanedName);

    // Get the first letter of each word
    $initials = "";
    foreach ($words as $word) {
        if (!empty($word)) {
            $initials .= $word[0];
        }
    }

    return $initials;
}


if (!function_exists("lock")) {
    function lock($string, $action = 'encrypt')
    {
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'CONSTA_KG_2023'; // user define private key
        $secret_iv = 'oO0o90O0OoO8o0oOo60o10o'; // user define secret key
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16); // sha256 is hash_hmac_algo
        if ($action == 'encrypt') {
            $output = openssl_encrypt(json_encode($string), $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = json_decode(openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv));
        }
        return $output;
    }
}


if (!function_exists("mobile_device_detected")) {
    function mobile_device_detected()
    {
        $user_agent = $_SERVER["HTTP_USER_AGENT"];
        if (preg_match("/(android|webos|avantgo|iphone|ipod|ipad|bolt|boost|cricket|docomo|fone|hiptop|opera mini|mini|kitkat|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $user_agent)) {
            return "true";
        } else {
            return "false";
        }
    }
}


if (!function_exists("email_masking")) {
    function email_masking($email)
    {
        $em = explode("@", $email);
        $name = implode('@', array_slice($em, 0, count($em) - 1));
        $len = floor(strlen($name) / 2);

        return substr($name, 0, $len) . str_repeat('*', $len) . "@" . end($em);
    }
}


// function _exception( $content = '' )
// {
//     date_default_timezone_set( "Asia/Kolkata" );
//     $filename = 'C:\xampp\htdocs\vaid-ci4\public\Project Exception List\Project Exception List [' . date( 'd M Y' ) . ']' . '.txt';

//     $cDate = '';
//     $cDate .= 'Date: ';
//     $cDate .= date( 'jS F Y' );
//     $cDate .= '          Timestamp: ';
//     $cDate .= date( 'Y-m-d h:i:s A' );
//     $data = "\r\n\r\n\r\n\r\n" . $cDate . "\r\n" . print_r( $content, true );
//     $fp = fopen( $filename, 'a' );
//     if ( is_array( $content ) ) {
//         fwrite( $fp, $data );
//     } else {
//         fwrite( $fp, $data );
//     }

// }


// function _log( $content = '', $filename = 'log.txt' )
// {

//     $cDate = '';
//     $cDate .= 'Date: ';
//     $cDate .= date( 'jS F Y' );
//     $cDate .= '          Timestamp: ';
//     $cDate .= date( 'Y-m-d H:i:s' );
//     $data = "\r\n\r\n\r\n\r\n" . $cDate . "\r\n" . print_r($content, true);
//     $fp   = fopen( $filename, 'a' );
//     if ( is_array( $content ) ) {
//         fwrite( $fp, $data );
//     } else {
//         fwrite( $fp, $data );
//     }

// }


function randomMasterPassword()
{

    $alphabet1 = "abcdefghijklmnopqrstuwxyz";
    $alphabet2 = "ABCDEFGHIJKLMNOPQRSTUWXYZ";
    $alphabet3 = "0123456789";
    $alphabet4 = "@$#";

    $masterpass = '';
    $masterpass .= substr(str_shuffle($alphabet1), 0, 2);
    $masterpass .= substr(str_shuffle($alphabet2), 0, 2);
    $masterpass .= substr(str_shuffle($alphabet3), 0, 2);
    $masterpass .= substr(str_shuffle($alphabet4), 0, 1);

    $masterpass = str_shuffle($masterpass);
    return $masterpass;

}

function generateToken($length = 4)
{
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function generateNumericToken($length = 4)
{
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function generate_txn_id($length = 6)
{
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


function file_url_exist($url)
{
    $handle = @fopen($url, 'r');
    if (!$handle) {
        return false;
    } else {
        return true;
    }
}
/*
    if( file_url_exist('https://staging.edqwest.com/documents/video_thumbnail//profile_1676545387download.pdf') ){

        echo 'yes';
    }else{

        echo 'no;
    }
*/



/**
 * Uploads file(s) to the specified directory.
 *
 * @param string $uploadPath The path to upload the files to.
 * @param string $inputName The name of the file input field.
 *
 * @return mixed The uploaded file name(s) if successful, or false otherwise.
 */
function uploadFiles($uploadPath, $inputName)
{
    $uploadedFiles = [];

    // Check if any files were uploaded
    if (isset($_FILES[$inputName])) {
        // If only one file was uploaded, wrap it in an array to simplify handling
        if (!is_array($_FILES[$inputName]['name'])) {
            $_FILES[$inputName] = [
                'name' => [$_FILES[$inputName]['name']],
                'type' => [$_FILES[$inputName]['type']],
                'tmp_name' => [$_FILES[$inputName]['tmp_name']],
                'error' => [$_FILES[$inputName]['error']],
                'size' => [$_FILES[$inputName]['size']]
            ];
        }

        // Get the count of uploaded files
        $fileCount = count($_FILES[$inputName]['name']);

        // Iterate through all uploaded files
        for ($i = 0; $i < $fileCount; $i++) {
            // Check if the file was uploaded successfully
            if ($_FILES[$inputName]['error'][$i] === UPLOAD_ERR_OK) {
                // Generate a unique file name
                $filename = uniqid() . '_' . $_FILES[$inputName]['name'][$i];

                // Move the file to the specified upload directory
                if (move_uploaded_file($_FILES[$inputName]['tmp_name'][$i], $uploadPath . '/' . $filename)) {
                    // Add the uploaded file name to the array
                    $uploadedFiles[] = $filename;
                } else {
                    // Return false if there was an error moving the file
                    return false;
                }
            } else {
                // Return false if there was an error uploading the file
                return false;
            }
        }
    }

    // Return the uploaded file name(s)
    return $uploadedFiles;
}
/*

    // Single or multiple both

    //$_FILE['doc_passport_attachments'];


    $uploadedFiles = uploadFiles(ROOTPATH . 'public/documents/employee_document', 'doc_passport_attachments');
    $passport_attachments_files = '';
    if ($uploadedFiles !== false) {
        if( is_array($uploadedFiles) ) {
            $passport_attachments_files = implode(',', $uploadedFiles);   // successfully uploaded
        }else{
            $passport_attachments_files = $uploadedFiles;
        }
    }



    prx($passport_attachments_files);

*/

if (!function_exists("dynamicLock")) {
    function dynamicLock($string, $action = 'encrypt')
    {
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'The_Private_Key_9698'; // user define private key
        $secret_iv = 'My_Secret_IV_9698'; // user define secret key
        $key = hash('sha256', $secret_key);

        if ($action == 'encrypt') {
            $ivlen = openssl_cipher_iv_length($encrypt_method);
            $iv = openssl_random_pseudo_bytes($ivlen);
            if (strlen($iv) < $ivlen) {
                $iv = str_pad($iv, $ivlen, "\0");
            }
            $output = openssl_encrypt(json_encode($string), $encrypt_method, $key, 0, $iv);
            $output = base64_encode($iv . $output);
        } else if ($action == 'decrypt') {
            $ivlen = openssl_cipher_iv_length($encrypt_method);
            $ciphertext = base64_decode($string);
            $iv = substr($ciphertext, 0, $ivlen);
            if (strlen($iv) < $ivlen) {
                $iv = str_pad($iv, $ivlen, "\0");
            }
            $ciphertext = substr($ciphertext, $ivlen);
            $output = json_decode(openssl_decrypt($ciphertext, $encrypt_method, $key, 0, $iv));
        }
        return $output;
    }
}

function generateRendomPassword($name)
{
    $randomStr = str_shuffle('@#$%^*');
    $specialChar = substr($randomStr, 0, 1);
    $integer = substr(str_shuffle('1234567890'), 0, 3);
    $pass = substr(ucfirst($name), 0, 4) . $specialChar . $integer;
    return $pass;
}


function authChecker($controller = 'admin', $function_name)
{
    try {
        if (is_array($function_name) && !empty($function_name)) {

            $role_id = dynamicLock(session()->get('user_type_id'), 'decrypt');
            if ($role_id) {

                $getRolesInfo = _getWhere('sw_roles_type', ['id' => $role_id]);
                if ($getRolesInfo) {
                    if ($getRolesInfo->vip == 'yes') {
                        return true; // ALL OK || VIP USER or SUPER ADMIN
                    }
                }

                $db = \Config\Database::connect();
                $builder = $db->table('sw_front_functions');
                $builder->where('controller_name', $controller);
                $builder->whereIn('function_name', $function_name);
                $FrontFunctions = $builder->get()->getResult();
                if ($FrontFunctions) {
                    $AccessID = array_column($FrontFunctions, 'function_id');
                    $builder_v2 = $db->table('sw_set_permission');
                    $builder_v2->where('role_id', $role_id);
                    $userPermission = $builder_v2->get()->getRow();
                    if ($userPermission) {
                        $functionStringList = $userPermission->function_id;
                        $function_ARRAY = explode(',', $functionStringList);
                        if (count(array_intersect($AccessID, $function_ARRAY)) > 0) {
                            return true; // ALL OK
                        } else {
                            return false; // false;
                        }
                    } else {
                        return false; // Permission ID Not Found
                    }
                } else {
                    return false; // Function ID Not Found
                }
            } else {
                return false; // Role ID Not Found
            }
        } else {
            return false;
        }
    } catch (\Exception $e) {
        return false;
    }
}

/* ====[ Roles & Permission ]==== */
/*
        // Controller


        // <==[ Accessibility Checker :: START ]==>
        if( !authChecker('admin', [
            'manpower_management_category_create',
        ]) ){
            return redirect()->route('dashboard.index')->withInput()->with( 'flash_array', ['access_denied' => 'access_denied'] );
        }
        // <==[  Accessibility Checker :: END  ]==>
        


        // View
        <?php if(authChecker('admin', [
            'manpower_management_category_create',
            'manpower_management_category_list',
            'manpower_management_category_remove',
            'manpower_management_category_edit'
            ])): ?>

            ...HTML...

        <?php endif; ?>



*/


function emailOTP()
{

    return 123456;

    $min = 100000; // Minimum 6-digit number
    $max = 999999; // Maximum 6-digit number
    return str_shuffle(rand($min, $max));
}

function referralCODE()
{
    $min = 1000; // Minimum 6-digit number
    $max = 9999; // Maximum 6-digit number
    return str_shuffle(rand($min, $max));
}


function isLastOtpValid(string $email, int $minute): bool
{
    $db = \Config\Database::connect();
    $builder = $db->table('sw_otp');
    $builder->select('created_at');
    $builder->where('email', $email);
    $builder->where('is_used', 'no');
    $builder->orderBy('created_at', 'DESC');
    $builder->limit(1);
    $lastOtp = $builder->get()->getRow();

    if (!$lastOtp) {
        return false;
    }

    $lastOtpTime = strtotime($lastOtp->created_at);
    $currentTime = time();
    $timeDiff = $currentTime - $lastOtpTime;
    $minuteDiff = round($timeDiff / 60);

    return ($minuteDiff <= $minute);
}


function isLastOtpValid_v2(string $email, int $minute, int $otp): bool
{
    $db = \Config\Database::connect();
    $builder = $db->table('sw_otp');
    $builder->select('created_at');
    $builder->where('email', $email);
    $builder->where('code', $otp);
    $builder->where('is_used', 'no');
    $builder->orderBy('created_at', 'DESC');
    $builder->limit(1);
    $lastOtp = $builder->get()->getRow();

    if (!$lastOtp) {
        return false;
    }

    $lastOtpTime = strtotime($lastOtp->created_at);
    $currentTime = time();
    $timeDiff = $currentTime - $lastOtpTime;
    $minuteDiff = round($timeDiff / 60);

    return ($minuteDiff <= $minute);
}


if (!function_exists('mask_phone_number')) {
    function mask_phone_number($phone_number)
    {
        $masked_number = substr($phone_number, 0, 4) . '******';
        return $masked_number;
    }
}


if (!function_exists('_getRoleTitleToRoleID')) {
    function _getRoleTitleToRoleID($roleTitle)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('sw_roles_type');
        $builder->where(['title' => 'Manpower']);
        $result = $builder->get()->getRow();
        if ($result) {
            return $result->id;
        } else {
            return null;
        }
    }
}


if (!function_exists('_getDynamicClass')) {
    function _getDynamicClass($status)
    {
        if (strtolower($status) == 'pending') {
            return 'flag_warning';
        } elseif (strtolower($status) == 'completed') {
            return 'flag_green';
        } elseif (strtolower($status) == 'cancelled') {
            return 'flag_danger';
        } elseif (strtolower($status) == 'waiting') {
            return 'flag_warning';
        } else {
            return 'flag_primary';
        }
    }
}


if (!function_exists('_getManpowerProfileStatus')) {
    function _getManpowerProfileStatus($manpower_id)
    {
        $data = [
            'message' => '',
            'profile_status' => 'incomplete_profile',
            'account_created' => 'no',
            'account_status' => 'no',
            'manpower_business_days' => 'no',
            'today_working' => 'no',
            'manpower_id' => $manpower_id
        ];

        $Main = 'no';

        $sw_Employee = _getWhere('sw_employee', ['id' => $manpower_id]);
        if ($sw_Employee) {

            $data['account_created'] = 'yes';

            /*  Account Status  */
            if ($sw_Employee->status == 'active') {
                $data['account_status'] = 'active';
            } else {
                $data['account_status'] = 'inactive';
            }

            /* Business Day */
            $business_day = _getWhere('sw_employee_days', ['employee_id' => $manpower_id]);
            if ($business_day) {

                if (
                    $business_day->monday_start === null && $business_day->monday_end === null &&
                    $business_day->tuesday_start === null && $business_day->tuesday_end === null &&
                    $business_day->wednesday_start === null && $business_day->wednesday_end === null &&
                    $business_day->thursday_start === null && $business_day->thursday_end === null &&
                    $business_day->friday_start === null && $business_day->friday_end === null &&
                    $business_day->saturday_start === null && $business_day->saturday_end === null &&
                    $business_day->sunday_start === null && $business_day->sunday_end === null
                ) {

                    $data['message'] = 'All Business Days is NULL';
                    $data['manpower_business_days'] = 'no';
                    $Main = 'no';

                } elseif (
                    $business_day->monday_start === '00:00:00' && $business_day->monday_end === '00:00:00' &&
                    $business_day->tuesday_start === '00:00:00' && $business_day->tuesday_end === '00:00:00' &&
                    $business_day->wednesday_start === '00:00:00' && $business_day->wednesday_end === '00:00:00' &&
                    $business_day->thursday_start === '00:00:00' && $business_day->thursday_end === '00:00:00' &&
                    $business_day->friday_start === '00:00:00' && $business_day->friday_end === '00:00:00' &&
                    $business_day->saturday_start === '00:00:00' && $business_day->saturday_end === '00:00:00' &&
                    $business_day->sunday_start === '00:00:00' && $business_day->sunday_end === '00:00:00'
                ) {

                    $data['message'] = 'All Business Days is 00:00:00';
                    $data['manpower_business_days'] = 'no';
                    $Main = 'no';

                } else {

                    $Main = 'yes';
                    $data['manpower_business_days'] = 'yes';

                    $CurrentDayStart = strtolower(date('l')) . '_start';
                    $CurrentDayEnd = strtolower(date('l')) . '_end';

                    $CurrentDayStart_TIME = $business_day->$CurrentDayStart ?? NULL;
                    $CurrentDayEnd_TIME = $business_day->$CurrentDayEnd ?? NULL;
                    $CurrentDay_TIME = date('H:i:s');

                    if ($CurrentDay_TIME >= $CurrentDayStart_TIME && $CurrentDay_TIME <= $CurrentDayEnd_TIME) {
                        $data['today_working'] = 'yes';
                    } else {
                        $data['today_working'] = 'no';
                    }

                }

            } else {

                $data['manpower_business_days'] = 'no';
                $Main = 'no';

            }

        } else {

            $Main = 'no';
            $dat['account_created'] = 'no';
            $data['message'] = 'Record not exists in database.';

        }

        if ($Main == 'yes') {
            $data['profile_status'] = 'profile_completed';
        }

        return $data;
    }
}


if (!function_exists("email_send")) {
    function email_send($to, $subject, $message, $attach = null, $cc = null, $bcc = null)
    {
        $email = \Config\Services::email();
        $email->setTo($to);
        $email->setFrom('saurabhsrbjha@gmail.com', 'Swafe Wellness');
        $email->setSubject($subject);
        $email->setMessage($message);

        if (!is_null($cc)) {
            $email->setCC($cc);
        }

        if (!is_null($bcc)) {
            $email->setBCC($bcc);
        }

        if (!is_null($attach)) {
            $email->attach($attach);
        }

        if ($email->send()) {

           return true;

        } else {

            // return [
            //     'status' => 500,
            //     'message' => 'email send failed ' + $email->printDebugger(['headers']),
            // ];
            return false;
        }
    }
}

/*
    $html = view( 'email\reset_password', [
        'useremail' => safe( $username_email['email'] ),
        'resetlink' => $resetURL,
    ] );

    email_send( safe( $username_email['email'] ), 'Reset your Vaid Tutoring password', $html, $attach = null, $cc = null, $bcc = null );
 */