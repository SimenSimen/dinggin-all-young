<?php
class Push_model extends MY_Model {

    public function __construct()
    {
        $this->load->database();
    }

    //----------------------------------------------------------------------------------- 
    // 函數名：get_device_token($member_id, $sys = '')
    // 作 用 ：Get Device Token from Database
    // 參 數 ：$member_id 對應會員id的device token
    //         $sys       系統(android, ios)
    //         $member_id 會員編號
    // 返回值：token array
    // 備 注 ：無
    //----------------------------------------------------------------------------------- 
    public function get_device_token($member_id, $sys = '', $domain_id)
    {
        // get table data of device token
        switch ($sys) {
            case 'android':
                $device_token_data = $this -> select_from_order('push_device', 'id', desc, array('member_id' => $member_id, 'domain_id' => $domain_id, 'sys' => 'android'));
                break;
            case 'ios':
                $device_token_data = $this -> select_from_order('push_device', 'id', desc, array('member_id' => $member_id, 'domain_id' => $domain_id, 'sys' => 'ios'));
                
                break;
        }

        
        foreach ($device_token_data as $key => $value)
        {
            $device_tokens[] = $value['device_token'];
        }

        return $device_tokens;
    }

    //----------------------------------------------------------------------------------- 
    // 函數名：get_range_data($table, $order_by, $order_type, $start_id=0, $real_per_num=8)
    // 作 用 ：取得推播文字記錄每頁資料
    //----------------------------------------------------------------------------------- 
    public function get_range_data($table, $order_by, $order_type, $start_id=0, $real_per_num=8, $data_where='')
    {
        $start_id = ($start_id >= 0) ? $start_id : 0;
        $sql = '
            SELECT   * 
            FROM     `'.$table.'`
        ';
        if(!empty($data_where))
        {
            $index = 0;
            foreach($data_where as $key => $value)
            {
                if($index > 0)
                {
                    $sql .= 'AND  `'.$key.'` = "'.$value.'" ';
                }
                else
                {
                    $sql .= 'WHERE  `'.$key.'` = '.$value.' ';
                }
                $index++;
            }
        }
        $sql .= '
            ORDER BY `'.$order_by.'` '.$order_type.'
            Limit    '.$start_id.', '.$real_per_num.'
        ';
        $query=$this->db->query($sql);
        $data=$query->result_array();
        return $data;
    }

    //----------------------------------------------------------------------------------- 
    // 函數名：select_timer_between($table, $member_id, $initial, $deadline, $data_where)
    // 作 用 ：Get Device Token from Database
    // 參 數 ：$table         資料表
    //         $member_id     會員編號
    //         $initial       初始時間
    //         $deadline      截止時間
    //         $data_where    資料限制
    // 返回值：
    // 備 注 ：無
    //----------------------------------------------------------------------------------- 
    public function select_timer_between($table, $member_id, $initial, $deadline, $data_where='')
    {
        $sql = '
            SELECT  *
            FROM    `'.$table.'`
        ';
        $sql .= '
            WHERE   (   
                        `type` = 1
                        AND     `member_id`    = "' .$member_id.'"
                        AND     `send_time` BETWEEN "'.$initial.'" AND "'.$deadline.'"
                    )
            OR      (   
                        CONCAT(`to_member_id`, "*#") LIKE "%*#'.$member_id.'*#%"
                        AND     `send_time` BETWEEN "'.$initial.'" AND "'.$deadline.'"
                    )
            OR      (
                        `delete_time` BETWEEN "'.$initial.'" AND "'.$deadline.'"
                    )
        ';

        if(!empty($data_where))
        {
            foreach($data_where as $key => $value)
            {
                $sql .= 'AND  `'.$key.'` = "'.$value.'" ';
            }
        }
        $query  = $this -> db -> query($sql);
        $data = $query -> result_array();
        return $data;
    }

    //----------------------------------------------------------------------------------- 
    // 函數名：push_log_views($type, $data_where, $views = '')
    // 作 用 ：Get Device Token from Database
    // 參 數 ：$table         資料表
    //         $member_id     會員編號
    //         $initial       初始時間
    //         $deadline      截止時間
    //         $data_where    資料限制
    // 返回值：更新成功 ID
    // 備 注 ：無
    //-----------------------------------------------------------------------------------
    public function push_log_views($type, $data_where, $views = '')
    {
        $push_log = $this -> select_from('push_log', $data_where);
        if(!empty($push_log))
        {
            switch ($type) {
                case 'add':
                    $result = $this -> update_set('push_log', 'p_id', $push_log['p_id'], array('views' => $push_log['views'] + 1));
                    $result = '';
                    break;
                
                case 'update':
                    $result = $this -> update_set('push_log', 'p_id', $push_log['p_id'], array('views' => $views));
                    $result = '';
                    break;
            }
        }
        else
            $result = 'Error';
        
        return $result;
    }

    //----------------------------------------------------------------------------------- 
    // 函數名：encoder($data_array)
    // 作 用 ：推播匣內容
    // 參 數 ：$data_array 內容
    // 返回值：
    // 備 注 ：無
    //-----------------------------------------------------------------------------------
    public function encoder($data_array)
    {
        $sign = "'";
        $double = '"';
    
        $src = '/uploads';
        $src1 = base_url().'uploads';
    
        $html = '<!DOCTYPE html>
                 <html>
                 <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
                  </head>
                  <body>
                    <style>
                        img{ max-width:100% !important; height:auto !important; }
                        iframe{ max-width:100% !important; height:auto !important; }
                    </style>
                ';
                
        $foot = '</body>
                 </html>';

        // <br> 置換 #
        $data_array1 = str_replace("<br />", "#", $data_array);
        
        // " 置換 ' (以防json error)
        $data_array2 = str_replace($double, $sign, $data_array1);
        
        // 絕對圖片路徑
        $data_array3 = str_replace($src, $src1, $data_array2);
        
        $data_array = $html . str_replace($double, $sign, $data_array3) . $foot;

        return $data_array;       
    }

    //----------------------------------------------------------------------------------- 
    // 函數名：timer_decoder($timer)
    // 作 用 ：App 時間轉換
    // 參 數 ：$timer
    // 返回值：
    // 備 注 ：2015-12-18T15:56:47+08:00 <格式>
    //-----------------------------------------------------------------------------------
    public function timer_decoder($time = '')
    {
        if($time != '')
        {
            $up_data = explode("T", $time);
            $sec = strtotime($up_data[0]) - 28800;
            $hours = explode(":", $up_data[1]);
            $sec = ($hours['0'] *60 *60) + $sec;
            $sec = ($hours['1'] *60) + $sec;
            $s = explode(" ", $hours[2]);
            $sec = $sec + $s[0];
            $decoder = $sec;
        }
        return $decoder;
    }

    public function get_member_name($member_array = array())
    {
        if (!empty($member_array))
        {
            $count = 0;
            $array_key = 0;
            $name_array = array();
            foreach ($member_array as $key => $value)
            {
                $iqr = $this -> select_from('iqr', array('member_id' => $value));
                if ($count % 5 == 0)
                {
                    $array_key++;
                    $name_array[$array_key][] = $iqr['l_name'] . $iqr['f_name'];
                }
                else {
                    $name_array[$array_key][] = $iqr['l_name'] . $iqr['f_name'];
                }
                $count++;
            }
        }
        return $name_array;
    }

}