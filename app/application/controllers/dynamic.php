<?php
// 動態增刪修
class Dynamic extends MY_Controller
{
    public $data='';

    public function __construct() //初始化
    {
        parent::__construct();

        //model
        $this->load->model('business_model', 'mod_business');
    }

    // strings add
    public function add()
    {
        // str name
        $str_name    = $this -> input -> post('str_name');
        if($this -> input -> post('select_mode'))
        {
            $select_mode = $this -> input -> post('select_mode');
            $str_category = $this -> mod_business -> select_from('strings_category', array('cid' => $select_mode));
        }

        // type check
        switch ($this->input->post('type')) {
            case 0:
                $update_item = 'ytb_link';
                $str = $this->http_check($this->input->post('str'));
                break;
            case 1:
                $update_item = 'website';
                $str = $this->http_check($this->input->post('str'));
                break;
            case 2:
                $update_item = 'address';
                $str = $this->input->post('str');
                break;
            case 3:
                $update_item = 'titlename';
                $str         = $this->input->post('str');
                $str_name    = '';
                break;
            case 4:
                $update_item = 'mobile_phones';
                $str         = $this -> input -> post('str');
                break;
        }

        // strings
        $insert_data = array(
            'member_id' => $this->input->post('member_id'),
            'str'       => $str,
            'str_name'  => $str_name,
            'cid'       => $select_mode,
            'type'      => $this->input->post('type')
        );
        // useful id
        // $strings = $this->mod_business->select_from_order('strings', 'str_id', 'asc');
        // if(!empty($strings))
        // {
        //     for($i = 1; $i < count($strings); $i++)
        //     {
        //         $a = intval($strings[$i]['str_id']);
        //         $b = intval($strings[($i - 1)]['str_id']);
        //         $c = $a - $b;
        //         if($c >= 2) // 不連續數字
        //         {
        //             $update_str_id = $b + 1;
        //             break;
        //         }
        //     }
        // }
        $str_id = $this->mod_business->insert_into('strings', $insert_data);
        // if($update_str_id == '')
            $update_str_id = $str_id;
        // $this->mod_business->update_set('strings', 'str_id', $str_id, array('str_id'=>$update_str_id));

        // iqr update
        $iqr = $this->mod_business->select_from('iqr', array('member_id' => $this->input->post('member_id')));
        $this->mod_business->update_set('iqr', 'member_id', $this->input->post('member_id'), array($update_item => $iqr[$update_item].'*#'.$update_str_id));

        // exchange update
        if($this->input->post('type') != 3 && $this->input->post('type') != 4)
        {
            // auth
            $member = $this->mod_business->select_from('member', array('member_id' => $this->input->post('member_id')));
            $auth   = intval($member['auth']);

            // web config
            $control_setting = $this->mod_business->select_from('control_setting', array('domain_id' => $member['domain_id']));
            $auth_level_num  = intval($control_setting['auth_level_num']);
            
            if($auth_level_num > $auth) // 擁有共享層級的使用者
            {
                // share update
                $add_share_data  = array(
                    'member_id'  => $this->input->post('member_id'),
                    'iqr_column' => $update_item,
                    'id'         => $update_str_id,
                    'status'     => 1
                );
                $this->mod_business->insert_into('share_data', $add_share_data);

                // quote update
                $this->load->model('exchange_model', 'mod_exchange');
                $member_array = $this->mod_exchange->get_all_member_in_domain($member['domain_id']);
                if(!empty($member_array))
                {
                    foreach($member_array as $key => $value)
                    {
                        $add_quote_data = array(
                            'member_id'  => $value,
                            'parent'     => $this->input->post('member_id'),
                            'iqr_column' => $update_item,
                            'id'         => $update_str_id,
                            'status'     => 0 // 新增資料不用預設引用
                        );
                        $this->mod_business->insert_into('quote_data', $add_quote_data);
                    }
                }
            }
            else
            {
                // 會員層級屬於最低層, 無須update
            }
        }

        echo $str_name.'*#'.$str.'*#'.$update_str_id.'*#'.$str_category['name'].'*#'.$str_category['cid'];
    }

    // strings delete
    public function delete()
    {
        // type check
        switch ($this->input->post('type')) {
            case 0:
                $delete_item = 'ytb_link';
                break;
            case 1:
                $delete_item = 'website';
                break;
            case 2:
                $delete_item = 'address';
                break;
            case 3:
                $delete_item = 'titlename';
                break;
            case 4:
                $delete_item = 'mobile_phones';
                break;
        }

        // iqr
        $iqr = $this->mod_business->select_from('iqr', array('member_id' => $this->input->post('mid')));
        ${$delete_item} = $this->get_serialstr($iqr[$delete_item], '*#');
        foreach(${$delete_item} as $key => $value)
        {
            if($value == $this->input->post('id'))
            {
                echo ${$delete_item}[$key].' = '.$this->input->post('id').'<BR>';
                unset(${$delete_item}[$key]);
                break;
            }
        }
        $iqr_item = $this->set_serialstr(${$delete_item}, '*#');
        $this->mod_business->update_set('iqr', 'member_id', $this->input->post('mid'), array($delete_item => $iqr_item));

        // delete
        $delete_where = array(
            'str_id'    => $this->input->post('id'),
            'member_id' => $this->input->post('mid'),
            'type'      => $this->input->post('type')
        );
        $this->mod_business->delete_where('strings', $delete_where);

        // exchange update
        if($this->input->post('type') != 3 && $this->input->post('type') != 4)
        {
            // auth
            $member = $this->mod_business->select_from('member', array('member_id' => $this->input->post('mid')));
            $auth   = intval($member['auth']);

            // web config
            $control_setting = $this->mod_business->select_from('control_setting', array('domain_id' => $member['domain_id']));
            $auth_level_num  = intval($control_setting['auth_level_num']);
            
            if($auth_level_num > $auth) // 擁有共享層級的使用者
            {
                $del_share_data = array(
                    'member_id'  => $this->input->post('mid'),
                    'iqr_column' => $delete_item,
                    'id'         => $this->input->post('id')
                );
                $del_quote_data = array(
                    'parent'     => $this->input->post('mid'),
                    'iqr_column' => $delete_item,
                    'id'         => $this->input->post('id')
                );
                $this->mod_business->delete_where('share_data', $del_share_data);
                $this->mod_business->delete_where('quote_data', $del_quote_data);
            }
            else
            {
                // 會員層級屬於最低層, 無須update
            }
        }
    }
}