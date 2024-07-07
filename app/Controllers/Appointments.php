<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Appointments extends BaseController
{
    public $db;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->db = \Config\Database::connect();
        $session = \Config\Services::session();

    }

    public function list(){
        $data['centerAppointments'] = $this->db->query('select ap.*, sp.package_name, sc.center_name, su.firstname, su.lastname from sw_appointments ap, sw_packages sp, sw_centers sc, sw_app_userinfo su where ap.payment_status = "Completed" and ap.programme_id = sp.id and ap.type = "center" and sc.id = ap.typeid and su.id = ap.user_id')->getResult();
        
        $data['trainerAppointments'] = $this->db->query('select ap.*, sp.package_name, st.trainer_name from sw_appointments ap, sw_packages sp, sw_trainers st where ap.payment_status = "Pending" and ap.programme_id = sp.id and ap.type = "trainer" and st.id = ap.typeid')->getResult();
        
       return view('dashboard/appointments/list', $data);
        
    }
    
    public function details($appId){
        $id = lock($appId , 'decrypt');
        $type  = _getWhere('sw_appointments', ['id'=> $id])->type;
      
    //   print_r($_COOKIE['bucketItems2']);
    //   die();
        
        if($type=='center'){
            $data['app'] = $this->db->query('select ap.*, sp.package_name, sc.center_name, su.firstname, su.lastname, su.mobile, sp.image as package_image, sc.center_img from sw_appointments ap, sw_packages sp, sw_centers sc, sw_app_userinfo su where  ap.programme_id = sp.id and sc.id = ap.typeid and su.id = ap.user_id and ap.id = ' . $id)->getRow();
        
        }
        else if($type=='trainer'){
            $data['app'] = $this->db->query('select ap.*, sp.package_name, st.trainer_name, su.firstname, su.lastname, sp.image as package_image, st.trainer_img from sw_appointments ap, sw_packages sp, sw_trainers st, sw_app_userinfo su where  ap.programme_id = sp.id and st.id = ap.typeid and su.id = ap.user_id and ap.id = ' . $id)->getRow();
            
        }
        // echo 'select * from sw_user_addresses where appointment_id =' . $id ; die();
         $data['addr'] = $this->db->query('select su.* from sw_user_addresses  su, sw_appointments sa where su.appointment_id = sa.appointment_id  and sa.id =' . $id)->getRow();
        
         return view('dashboard/appointments/details', $data);
    }


  
}