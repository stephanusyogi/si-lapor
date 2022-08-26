<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModelChat extends CI_Model {

    function get_allusers($kode_kesatuan){
        $sql = "SELECT * FROM tb_kesatuan LEFT JOIN tb_chat ON tb_kesatuan.kode_kesatuan = tb_chat.outgoing_msg_id WHERE NOT tb_kesatuan.kode_kesatuan='{$kode_kesatuan}' GROUP BY tb_kesatuan.kode_kesatuan ORDER BY tb_chat.created_at DESC";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        $output = "";
        $srcImage = base_url()."assets/images/user.png";
        if (!empty($res)) {
            foreach($res as $row){
                $incoming_id = $row['kode_kesatuan'];
                $sqllastmsg = "SELECT * FROM tb_chat LEFT JOIN tb_kesatuan ON tb_kesatuan.kode_kesatuan = tb_chat.outgoing_msg_id
                WHERE (outgoing_msg_id = '$incoming_id' AND incoming_msg_id = '{$kode_kesatuan}')
                OR (outgoing_msg_id = '{$kode_kesatuan}' AND incoming_msg_id = '$incoming_id') ORDER BY tb_chat.id DESC LIMIT 1";
                $querymsg = $this->db->query($sqllastmsg);
                $resmsg = $querymsg->result_array();
                $lastmsg = count($resmsg);
                if (!empty($resmsg)) {
                    for ($i=0; $i < count($resmsg); $i++) {
                        if ($resmsg[$i]['outgoing_msg_id'] == $incoming_id) {
                            if ($resmsg[$i]['isRead'] == 1) {
                                $fontWeight = "style=''";
                            } else{
                                $fontWeight = "style='font-weight:800;'";
                            }
                        } else {
                            $fontWeight = "style=''";
                        } 
                        $lastmsg = strlen($resmsg[$i]['msg']) > 25 ? "<small {$fontWeight}>".substr($resmsg[$i]['msg'],0,25)."...</small>" : "<small {$fontWeight}>".$resmsg[$i]['msg']."</small>";
                    }   
                }else{
                    $lastmsg = '<small>No Message</small>';
                }
                $namaUser = strlen($row['nama']) > 15 ? substr($row['nama'],0,15)."..." : $row['nama'];
                $output .= "<li class='clearfix' id='userChat{$row['kode_kesatuan']}' onclick=openMessage('{$row['kode_kesatuan']}')><img src='{$srcImage}' alt='avatar'><div class='about'><div class='name' data-toggle='tooltip' data-placement='top' title='".$row['nama']."'>".$namaUser."</div><div class='kode_kesatuan text-left'>".$lastmsg."</div></div></li>";
            }
        }else{
            $output .= "No users are available to chat";
        }
        echo $output;
    }

    function insert_message($kode_kesatuanFrom ,$kode_kesatuanTo, $message){
        $sql = "INSERT INTO `tb_chat` (incoming_msg_id, outgoing_msg_id, msg) VALUES ('$kode_kesatuanTo', '{$kode_kesatuanFrom}', '$message')";
        $query = $this->db->query($sql);
        return $query;
    }
    
    function updateStatusRead($incoming_id, $kode_kesatuan){
        $sqlUpdateRead = "UPDATE tb_chat SET isRead = 1 WHERE (outgoing_msg_id = '$incoming_id' AND incoming_msg_id = '{$kode_kesatuan}')";
        $queryUpdateRead = $this->db->query($sqlUpdateRead);
        return $queryUpdateRead;
    }

    function get_infouser($incoming_id){
        // Get For Header
        $sql1 = "SELECT * FROM tb_kesatuan WHERE kode_kesatuan = '$incoming_id'";
        $query1 = $this->db->query($sql1);
        $res_user = $query1->result_array();
        
        $srcImage = base_url()."assets/images/user.png";
        $header = "";
        if (!empty($res_user)) {
            $header .= "<div class='row'><div class='col-lg-10'><img class='mt-1' src='".$srcImage."' alt='avatar'><div class='chat-about'><h3 class='mb-0'>".$res_user[0]['nama']."</h3><small>".$res_user[0]['kode_kesatuan']."</small></div></div><div class='col-lg-2 d-flex align-items-center justify-content-end'><button onclick=updateIsRead('{$incoming_id}') class='btn btn-info btn-sm' data-toggle='tooltip' data-placement='top' title='Tandai Sudah Dibaca'><i class='fas fa-check-double'></i></button></div></div>";
        } else {
            $header .= '<h2>Data Error</h2>';
        }
        echo $header;
    }

    function get_message($incoming_id, $kode_kesatuan){
        // Get For Messages
        $sql2 = "SELECT * FROM tb_chat LEFT JOIN tb_kesatuan ON tb_kesatuan.kode_kesatuan = tb_chat.outgoing_msg_id
        WHERE (outgoing_msg_id = '$incoming_id' AND incoming_msg_id = '{$kode_kesatuan}')
        OR (outgoing_msg_id = '{$kode_kesatuan}' AND incoming_msg_id = '$incoming_id') ORDER BY tb_chat.id ASC" ;
        $query2 = $this->db->query($sql2);
        $res_msg = $query2->result_array();
        
        $output = "";
        $srcImage = base_url()."assets/images/user.png";
        if (!empty($res_msg)) {
            foreach($res_msg as $row){
                if($row['outgoing_msg_id'] == $incoming_id){
                    $output .= '<li class="clearfix"><div class="message my-message"> '.$row['msg'].' </div><p class="mb-0 time-left"><small>'.$row['created_at'].'</small></p></li>';
                }else{
                    $output .= '<li class="clearfix"><div class="message-data text-right"><img src="'.$srcImage.'" alt="avatar"></div><div class="message other-message float-right"> '.$row['msg'].' </div><p class="mb-0 time-right"><small>'.$row['created_at'].'</small></p></li>';
                }
            }
        } else {
            $output .= '<div class="text" id="emptyMsg'.$kode_kesatuan.'">No messages are available. Once you send message they will appear here.</div>';
        }

        echo $output;
    }

    function countMessage($kode_kesatuan){
        $sqlCountRead = "SELECT * FROM tb_chat WHERE incoming_msg_id = '{$kode_kesatuan}' AND isRead = 0";
        $queryCountRead = $this->db->query($sqlCountRead)->result_array();
        echo count($queryCountRead);
    }
}
?>