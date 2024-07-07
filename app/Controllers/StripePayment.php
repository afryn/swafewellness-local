<?php
namespace App\Controllers;

use CodeIgniter\Controller;

use \Stripe\Checkout\Session;
use \Stripe\Stripe;

class StripePayment extends BaseController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->db = \Config\Database::connect();
        $session = \Config\Services::session();

    }
    
   
    public function create()
    {
         $rules = [
                "firstname" => [
                    "label" => "First Name",
                    "rules" => "required|trim"
                ],
                "lastname" => [
                    "label" => "Last Name",
                    "rules" => "required|trim"
                ],
                "mobile" => [
                    "label" => "Phone Number",
                    "rules" => "required|trim|numeric"
                ],
                "email" => [
                    "label" => "Email",
                    "rules" => "required|valid_email|trim"
                ],
                 "house_num" => [
                    "label" => "House Number",
                    "rules" => "required|trim"
                ],
                 "street" => [
                    "label" => "Street",
                    "rules" => "required|trim"
                ],
                 "country" => [
                    "label" => "Country",
                    "rules" => "required|trim"
                ],
                 "state" => [
                    "label" => "State",
                    "rules" => "required|trim"
                ],
                 "city" => [
                    "label" => "City",
                    "rules" => "required|trim"
                ],
                 "zip_code" => [
                    "label" => "Zip Code",
                    "rules" => "required|trim"
                ],
                
                
                
            ];



            if (!$this->validate($rules)) {
                $errors = $this->validator->getErrors();
                return $this->response->setJSON(['success' => false, 'msg' => reset($errors), 'errors' => $errors, 'data' => null]);
            }
            
        $postData = $this->request->getPost();
        if(isset($_COOKIE["bucketItems2"])){
            
            $data = json_decode($_COOKIE["bucketItems2"], true);
            
            // Extract the values from each object
            $values = array_map(function ($item) {
                if(isset($item['trainerId'])){
                     return $item['trainerId'] . '|' . $item['amount'] . '|'. $item['prId']. '|' . $item['date'] . '|' .  $item['adults'] ;
                }
                else{
                    return $item['centerId'] . '|' . $item['amount'] . '|'. $item['prId']. '|' . $item['date'] . '|' .$item['adults'];
                }
               
            }, $data);
            
            $uniqueValues = array_unique($values);
            
            // Convert the unique values back into an array of objects
            $uniqueObjects = array_map(function ($value) {
                
                $parts = explode('|', $value);
                $type = explode('_', $parts[0]);
                if($type[0] == 'center'){
                    return [
                    'centerId' => $type[1],
                    'amount' => $parts[1],
                    'prId' => $parts[2],
                    'date' => $parts[3],
                    'adults' => $parts[4]
                   ]; 
                }
                else{
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
             $count = 0;
             foreach($uniqueObjects as $pr){
                 $adults = lock($pr['adults'], 'decrypt');

                 if(isset($pr['centerId'])){
                     $amount += $this->db->query('select sp.amount from sw_pricing sp, sw_centers sc where sp.type = "center" and sp.type_id = sc.token and sc.id = "'.lock($pr['centerId'], 'decrypt').'" and sp.progrm_id ="'.lock($pr['prId'], 'decrypt').'"')->getRow()->amount;
                     $type1 = 'center';
                     $typeId = $pr['centerId'];
                     
                 }
                 else if(isset($pr['trainerId'])){
                     
                       $amount += $this->db->query('select sp.amount from sw_pricing sp, sw_trainers st where sp.type = "trainer" and sp.type_id = st.token and st.id = "'.lock($pr['trainerId'], 'decrypt').'" and sp.progrm_id ="'.lock($pr['prId'], 'decrypt').'"')->getRow()->amount;
                        $type1 = 'trainer';
                        $typeId = $pr['trainerId'];
                 }
                 
               $count ++ ;  
             }
             
             $amount = $amount * $adults;
             
             
                // insert if email not exist 
                $checkEmail = _getWhere('sw_app_userinfo', ['email'=> $postData['email'], 'status' => 1, 'trash' => 0]);
                
                if($checkEmail == ''){
                    // insert userinfo in table
                    $data = [
                        'firstname' => $postData['firstname'],
                        'lastname' => $postData['lastname'],
                        'email' => $postData['email'],
                        'mobile' => $postData['mobile'],
                        'date' => date('Y-m-d'),
                        'time' => date('H:i:s'),
                        'date_time' => date('Y-m-d H:i:s'),
                    ];
                    $insertApp = _insert('sw_app_userinfo',$data);
                       $userId = _getLastRow('sw_app_userinfo')->id;
                }
                else{
                    $userId = $checkEmail->id;
                     $data = [
                    // 'appointment_id' => 'SW'. $randomNum,
                    'house_num'=> $postData['house_num'],
                    'street'=> $postData['street'],
                    'locality'=> $postData['locality'],
                    'country'=> $postData['country'],
                    'state'=> $postData['state'],
                    'city'=> $postData['city'],
                    'zip_code'=> $postData['zip_code'],
                    ];
                }
                
                  // insert into transaction table 
               
               $randomNum = generateNumericToken(10);
               $txnId = generate_txn_id();
               $data = [
                    'user_id'=> $userId,
                    'txn_id' => 'txn_' .$txnId ,
                    'appointment_id' => 'SW' .$randomNum,
                    'user_email' => $postData['email'],
                    'payment_status' => 'Pending',
                    'amount' => $amount * $adults,
                    'currency' => 'inr',
                    'method' => 'Online',
                    'date' => date('Y-m-d'),
                    'time' => date('H:i:s'),
                    'date_time' => date('Y-m-d H:i:s'),
                    ];
                    
                $insertTxn = _insert('sw_online_transaction',$data);
                     
                // insert into appointment table
                 $data = [
                     'user_id' => $userId,
                    'appointment_id' => 'SW' .$randomNum,
                    'user_email' => $postData['email'],
                    'payment_status' => 'Pending',
                    'programme_id' => lock($pr['prId'], 'decrypt'),
                    'type' => $type1,
                    'typeid' => lock($typeId, 'decrypt' ),
                    'appntmnt_status' => 'Pending',
                    'appnmnt_date' => $pr['date'],
                    'adults'=> lock($pr['adults'], 'decrypt'),
                    'date' => date('Y-m-d'),
                    'time' => date('H:i:s'),
                    'date_time' => date('Y-m-d H:i:s'),
                ];
                $insertApp = _insert('sw_appointments',$data);
                
                //insert into address table 
                 $data = [
                    'user_id' => $userId,
                    'appointment_id' => 'SW' .$randomNum,
                    'email' => $postData['email'],
                    'mobile' => $postData['mobile'],
                    'house_num' => $postData['house_num'],
                    'street' => $postData['street'],
                    'locality' => $postData['locality'],
                    'country' => $postData['country'],
                    'state' =>$postData['state'],
                    'city'=> $postData['city'],
                    'zip_code' => $postData['zip_code'],
                    'date_time' => date('Y-m-d H:i:s'),
                ];
                $insertApp = _insert('sw_user_addresses',$data);
                
            
                   
                $data['programmes'] = $uniqueObjects;
                $data['totalAmount'] = $amount;
                
            }
            else{
                 return redirect()->back();
            }
            
            //last programme name 
            $prName = _getWhere('sw_packages', ['id' => lock($pr['prId'], 'decrypt')])->package_name;
            // print_r( $prName );
            
            // keys set in App/Config
            Stripe::setApiKey(STRIPE_SECRET_KEY);
            $checkout_session = Session::create([
                "line_items" => [
                    [
                        "price_data" => [
                            "currency" => 'inr',
                            "product_data" => [
                                "name" => ($count > 1)? $prName . ' and more' : $prName .'',
                                "description" => "Test Description",
                            ],
                            "unit_amount" => $amount * 100
                        ],
                        "quantity" => 1
                    ]
                ],
                'payment_method_types' => [
                    'card'
                ],
                'mode' => 'payment',
                'success_url' => base_url(route_to('StripePayment.success')),
                'cancel_url' => base_url(route_to('StripePayment.cancel')),
                'client_reference_id' => 8884
            ]);
            $url = $checkout_session->url;
            return $this->response->setJSON(['success' => true, 'url' => $url]);
            
    }

    public function success()
    {
        setcookie("bucketItems2", "", time() - 3600, "/"); // remove items from cookie
         
        $lastAddedinfo = _getLastRow('sw_online_transaction');
         $lastAdded = $lastAddedinfo->user_id;
        $updateApp = _updateWhere('sw_appointments', ['user_id'=> $lastAdded], ['payment_status' => 'Completed']);
        
        $updateTxn = _updateWhere('sw_online_transaction', ['user_id'=> $lastAdded], ['payment_status' => 'Completed']);
    
        $data['app_id'] = $lastAddedinfo->appointment_id;
    
        $data['app_info'] = $this->db->query('select sa.*,st.amount  from sw_appointments sa, sw_online_transaction st where sa.appointment_id = st.appointment_id and sa.appointment_id = "'.$lastAddedinfo->appointment_id.'"' )->getRow();
        
        return view('front/payment-success', $data);
    }

    public function cancel()
    { 
        $lastAdded = _getLastRow('sw_online_transaction')->user_id;
        
        $updateApp = _updateWhere('sw_appointments', ['user_id'=> $lastAdded], ['payment_status' => 'Failed']);
        
        $updateTxn = _updateWhere('sw_online_transaction', ['user_id'=> $lastAdded], ['payment_status' => 'Failed']);
        
         return view('front/payment-failed');
    }



}