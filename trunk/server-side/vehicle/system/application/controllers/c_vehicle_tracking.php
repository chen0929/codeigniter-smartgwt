<?php
//Controller is generated by MVC Schema Engine

/**
* @property CI_Loader $load
* @property CI_Form_validation $form_validation
* @property CI_Input $input
* @property CI_Email $email
* @property CI_DB_active_record $db
* @property CI_DB_forge $dbforge
* @property VehicleDBUtils $VehicleDBUtils
* @property Xe $xe*/ 

class c_Vehicle_Tracking extends Controller
{
    //message in vietnamese, TODO: add I18N later
    var $messageSuccess = "Thành công";
    var $messageFail    = "Thất bại";

    function c_Vehicle_Tracking()
    {
        parent::Controller();
        $this->load->model('xe');
        $this->load->model('VehicleDBUtils');

        $this->load->helper('form');
        $this->load->helper('object2array');
        $this->load->library('form_validation');
    }

    function index()
    {
        $this->load->view('v_vehicle_tracking');
    }

    function readXe($priKey)
    {
        if(isset($priKey) )
        {
            $this->xe->STT_XE = $priKey;
            $this->xe->SO_DANG_KY_XE = $priKey;

            $rows = $this->xe->read();
            foreach($rows as $row)
            {
                echo $row->STT_XE."<br>";
                echo $row->SO_DANG_KY_XE."<br>";
                echo $row->MS_MODEL_XE."<br>";
                echo $row->MS_THIET_BI."<br>";
                echo $row->THE_TICH_THAT."<br>";
                echo $row->NGAY_CAP_NHAT."<br>";
            }
        }
    }

    function create()
    {
        $this->xe->MS_MODEL_XE = $this->input->xss_clean($this->input->post('MS_MODEL_XE'));
        $this->xe->MS_THIET_BI = $this->input->xss_clean($this->input->post('MS_THIET_BI'));
        $this->xe->THE_TICH_THAT = $this->input->xss_clean($this->input->post('THE_TICH_THAT'));
        $this->xe->NGAY_CAP_NHAT = $this->input->xss_clean($this->input->post('NGAY_CAP_NHAT'));

        if($this->xe->save())
        echo $this->messageSuccess;
        else
        echo $this->messageFail;

    }

    function read()
    {
        //$data['objects'] = $this->xe->read();
        $data['form_view'] = $this->get_form_view();
        $this->load->view('v_xe',$data);
    }

    function read_json_format()
    {
        echo json_encode($this->xe->readByPagination());
    }

    function update()
    {
        $this->xe->STT_XE = $this->input->xss_clean($this->input->post('STT_XE'));
        $this->xe->SO_DANG_KY_XE = $this->input->xss_clean($this->input->post('SO_DANG_KY_XE'));
        $this->xe->MS_MODEL_XE = $this->input->xss_clean($this->input->post('MS_MODEL_XE'));
        $this->xe->MS_THIET_BI = $this->input->xss_clean($this->input->post('MS_THIET_BI'));
        $this->xe->THE_TICH_THAT = $this->input->xss_clean($this->input->post('THE_TICH_THAT'));
        $this->xe->NGAY_CAP_NHAT = $this->input->xss_clean($this->input->post('NGAY_CAP_NHAT'));

        if($this->xe->save())
        echo $this->messageSuccess;
        else
        echo $this->messageFail;

    }

    function delete()
    {
        $this->xe->STT_XE = $this->input->xss_clean($this->input->post('STT_XE'));
        $this->xe->SO_DANG_KY_XE = $this->input->xss_clean($this->input->post('SO_DANG_KY_XE'));

        if($this->xe->delete())
        echo $this->messageSuccess;
        else
        echo $this->messageFail;

    }



}
?>