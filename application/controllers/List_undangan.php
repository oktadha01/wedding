<?php
defined('BASEPATH') or exit('No direct script access allowed');


class list_undangan extends CI_Controller
{
    public $M_list_undangan;
    public $input;
    public $db;
    public $session;
    public $uri;
    var $template = 'temp_admin/index';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_list_undangan');
    }
    function index()
    {
        $data['tittle']          = 'Data Undangan';
        $data['content']         = 'page_admin/list_undangan/list_undangan';
        $data['script']         = 'page_admin/list_undangan/list_undangan_js';
        $this->load->view($this->template, $data);
    }

    function get_dataundangan()
    {
        $fil_status_send = $this->input->post('fil_status_send');
        // var_dump($fil_status_send);
        // exit;
        $list = $this->M_list_undangan->get_datatablest($fil_status_send);
        $data = array();
        $no = @$_POST['start'];
        $status = '';
        foreach ($list as $und) {
            $no_wa = $und->contact;
            //Terlebih dahulu kita trim dl
            $nomorhp = trim($no_wa);
            //bersihkan dari karakter yang tidak perlu
            $nomorhp = strip_tags($nomorhp);
            // Berishkan dari spasi
            $nomorhp = str_replace(" ", "", $nomorhp);
            // bersihkan dari bentuk seperti  (022) 66677788
            $nomorhp = str_replace("(", "", $nomorhp);
            // bersihkan dari format yang ada titik seperti 0811.222.333.4
            $nomorhp = str_replace(".", "", $nomorhp);
            // bersihkan dari format yang ada min seperti 0811-222-333-4
            $nomorhp = str_replace("-", "", $nomorhp);
            // bersihkan dari format yang ada min seperti +62811-222-333-4
            $nomorhp = str_replace("+", "", $nomorhp);

            //cek apakah mengandung karakter + dan 0-9
            if (!preg_match('/[^+0-9]/', trim($nomorhp))) {
                // cek apakah no hp karakter 1-3 adalah +62
                if (substr(trim($nomorhp), 0, 3) == '+62') {
                    $nomorhp = trim($nomorhp);
                    // echo $nomorhp;
                }
                // cek apakah no hp karakter 1 adalah 0
                elseif (substr($nomorhp, 0, 1) == '0') {
                    $nomorhp = '62' . substr($nomorhp, 1);
                    // $nomorhp1 = str_replace("'", "", $nomorhp);
                }
            }
            $btnSend = '<div class="display">
                            <div class="form-check form-check-success">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input cheklis-send" onclick="cheklis_sent(this)" value="' . $und->id_undangan . '">
                                    <i class="input-helper"></i>
                                    <span class="m-1 btn btn-inverse-secondary btn-send" id="btn-send-' . $und->id_undangan . '" value="' . $und->id_undangan . '" style="margin: 0px !important;">Send</span>
                                </label>
                            </div>
                        </div>';
            $btnResend = '<div class="display">
                            <div class="form-check form-check-success">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input cheklis-send" onclick="cheklis_sent(this)" value="' . $und->id_undangan . '">
                                    <i class="input-helper"></i>
                                    <span class="m-1 btn btn-inverse-secondary btn-send" id="btn-send-' . $und->id_undangan . '" value="' . $und->id_undangan . '" style="margin: 0px !important;">Resending</span>
                                </label>
                            </div>
                        </div>';

            $btnEdit = '<button class="m-1 btn btn-inverse-warning btn-edit-list" onclick="edit_list_undangan(this)" data-id-undangan="' . $und->id_undangan . '" data-name="' . $und->name . '"data-contact="' . $nomorhp . '" data-category="' . $und->category . '">Edit</button>';
            $btnDelete = '<button class="m-1 btn btn-inverse-danger" onclick="delete_list_undangan(this)" value="' . $und->id_undangan . '">delete</button>';
            if ($und->status == 'sent') {
                if ($und->state == 'sent') {

                    $status = '<span class="btn btn-warning mdi mdi-check icon-item"> ' . $und->state . '</span>';
                    $btnwa = $btnResend;
                } elseif ($und->state == 'delivered') {
                    $status = '<span class="btn btn-success mdi mdi-check-all icon-item"> ' . $und->state . '</span>';
                    $btnwa = '';
                } else if ($und->state == 'read') {
                    $status = '<span class="btn btn-primary mdi mdi-check-all icon-item"> ' . $und->state . '</span>';
                    $btnwa = '';
                }
            } else {
                if ($und->status == 'processing' or $und->status == 'pending') {
                    $status = '<span class="btn btn-inverse-warning mdi mdi-clock icon-item"> ' . $und->status . '</span>';
                    $btnwa = $btnResend;
                } else if ($und->status == 'expired') {
                    $status = '<span class="btn btn-inverse-danger"><span class="mdi mdi-clock icon-item"></span>' . $und->status . '</span>';
                    $btnwa = $btnResend;
                } else {
                    $btnwa = $btnSend;
                }
            }
            $name = '<span>' . $und->name . '</span><p class="' . $und->col_category . '">' . $und->category . '</p>';
            $no++;
            $row = array();
            $row[]  = $no . ".";
            $row[] = $name;
            $row[] = $nomorhp;
            $row[] = $btnwa;
            $row[] = $status;
            $row[] = $btnEdit . $btnDelete;
            $data[] = $row;
        }

        $output = array(
            "draw" => @$_POST['draw'],
            "recordsTotal" => $this->M_list_undangan->count_all($fil_status_send),
            "recordsFiltered" => $this->M_list_undangan->count_filtereds($fil_status_send),
            "data" => $data,
        );

        echo json_encode($output);
    }
    function select_category()
    {
        echo '<option value="" data-color="">select category</option>';
        $this->db->select("col_category,category");
        $this->db->Group_by("category");
        $query_ = $this->db->get('undangan');
        if ($query_->num_rows() > 0) {
            foreach ($query_->result() as $row) {
                echo '<option data-color="' . $row->col_category . '" value="' . $row->category . '">' . $row->category . '</option>';
            }
        }
        echo '<option value="add category">add category</option>';
    }

    function count_category_und()
    {
        // Get the total count of rows
        $total_query = $this->db->select('COUNT(*) AS total')->get('undangan');
        $total_row = $total_query->row();
        $total = $total_row->total;

        // Get the count of rows per category
        $this->db->select('category, col_category, COUNT(*) AS count_categ');
        $this->db->group_by('category');
        $category_query = $this->db->get('undangan');
        $categories = $category_query->result();

        // Prepare the final result
        // $result = array();
        foreach ($categories as $category) {
            // $result[] = array(
            //     'total' => $total,
            //     'category' => $category->category,
            //     'count_categ' => $category->count_categ
            // );
            // echo $total;
            echo '<div class="task-progress">
                        <p class="' . $category->col_category . '">' . $category->category . '
                            <span>' . $category->count_categ . '/' . $total . '</span>
                        </p>
                        <progress class="progress bg-' . $category->col_category . '" max="' . $total . '" value="' . $category->count_categ . '"></progress>
                    </div>';
        }
        // print_r($result);
        // foreach ($result as $rows) {
        // }
    }

    function add_undangan()
    {
        $name = $this->input->post('name');
        $contact = $this->input->post('contact');
        $category = $this->input->post('category');

        $category_array = array();
        $this->db->select("col_category,category");
        $this->db->Group_by("col_category");
        $query_ = $this->db->get('undangan');
        if ($query_->num_rows() > 0) {
            foreach ($query_->result() as $row) {
                $category_array[] = $row->col_category;
            }
        }
        $col_category = '';
        $col_category = $this->input->post('col-category');

        $color = array(
            "text-success",
            "text-behance",
            "text-youtube",
            "text-warning",
            "text-dribbble",
            "text-burlywood",
            "text-blueviolet",
            "text-tomato",
            "text-darkcyan",
            "text-powderblue"
        );

        $color = array_diff($color, $category_array);
        // Memastikan array tidak kosong setelah penghapusan elemen
        $action = 'true';
        $resp = 'success';
        $text = 'Data saved successfully';
        if ($col_category == '' or $col_category == 'undefined') {
            if (empty($color)) {
                // echo "Tidak ada elemen yang tersisa untuk dipilih.\n";
                // Memilih satu elemen secara acak dari array yang tersisa
                $resp = 'error';
                $text = 'Cannot add other categories !';
                $action = 'false';
            } else {
                $randomKey = array_rand($color);
                $randomElement = $color[$randomKey];
                // echo "Elemen terpilih secara acak (tidak termasuk 'apel' dan 'pisang'): " . $randomElement . "\n";
                $col_category = $randomElement;
            }
        }
        // echo $col_category;
        echo json_encode(array(
            'resp' => $resp,
            'text' => $text,
        ));
        if ($action == 'true') {
            $data = array(
                'name' => $name,
                'contact' => $contact,
                'category' => $category,
                'col_category' => $col_category,
            );
            $this->M_list_undangan->m_add_undangan($data);
        }
    }
    function edit_data_undangan()
    {
        $category_array = array();
        $this->db->select("col_category,category");
        $this->db->Group_by("col_category");
        $query_ = $this->db->get('undangan');
        if ($query_->num_rows() > 0) {
            foreach ($query_->result() as $row) {
                $category_array[] = $row->col_category;
            }
        }
        $col_category = '';
        $col_category = $this->input->post('col-category');

        $color = array(
            "text-success",
            "text-behance",
            "text-youtube",
            "text-warning",
            "text-dribbble",
            "text-burlywood",
            "text-blueviolet",
            "text-tomato",
            "text-darkcyan",
            "text-powderblue"
        );
        // Elemen yang ingin dikecualikan
        // $category_array = array();
        // Menghapus elemen yang dikecualikan dari array
        $color = array_diff($color, $category_array);
        // Memastikan array tidak kosong setelah penghapusan elemen
        $action = 'true';
        $resp = 'success';
        $text = 'The invitation has been successfully changed';
        if ($col_category == '' or $col_category == 'undefined') {
            if (empty($color)) {
                // echo "Tidak ada elemen yang tersisa untuk dipilih.\n";
                // Memilih satu elemen secara acak dari array yang tersisa
                $resp = 'error';
                $text = 'Cannot add other categories !';
                $action = 'false';
            } else {
                $randomKey = array_rand($color);
                $randomElement = $color[$randomKey];
                // echo "Elemen terpilih secara acak (tidak termasuk 'apel' dan 'pisang'): " . $randomElement . "\n";
                $col_category = $randomElement;
            }
        }
        // echo $col_category;
        echo json_encode(array(
            'resp' => $resp,
            'text' => $text,
        ));
        if ($action == 'true') {

            $id_undangan = $this->input->post('id-undangan');
            $name = $this->input->post('name');
            $contact = $this->input->post('contact');
            $category = $this->input->post('category');
            $result = $this->M_list_undangan->m_edit_undangan($id_undangan, $name, $contact, $category, $col_category);
        }
        // if ($result) {
        //     echo 'success';
        // } else {
        //     echo 'error';
        // }
    }
    function delete_list_undangan()
    {
        $id_undangan = $this->input->post('id-undangan');
        $result = $this->M_list_undangan->m_delete_list_undangan($id_undangan);
        if ($result) {
            $resp = 'success';
            $text = 'Data deleted successfully';
        } else {
            $resp = 'error';
            $text = 'Data failed to delete !';
        }

        echo json_encode(array(
            'resp' => $resp,
            'text' => $text,
        ));
    }

    function chat_wa()
    {
        $postid_undangan = $this->input->post('id-undangan');
        // $id_undangan = explode(',', rtrim($postid_undangan, ','));
        $token = "PPK3+BQuokovN16rcM2R";
        $data_undangan = $this->M_list_undangan->get_list_wa($postid_undangan);

        $success_count = 0;
        $fail_count = 0;
        foreach ($data_undangan as $trx) {
            $no_wa = $trx->contact;
            //Terlebih dahulu kita trim dl
            $nomorhp = trim($no_wa);
            //bersihkan dari karakter yang tidak perlu
            $nomorhp = strip_tags($nomorhp);
            // Berishkan dari spasi
            $nomorhp = str_replace(" ", "", $nomorhp);
            // bersihkan dari bentuk seperti  (022) 66677788
            $nomorhp = str_replace("(", "", $nomorhp);
            // bersihkan dari format yang ada titik seperti 0811.222.333.4
            $nomorhp = str_replace(".", "", $nomorhp);
            // bersihkan dari format yang ada min seperti 0811-222-333-4
            $nomorhp = str_replace("-", "", $nomorhp);

            //cek apakah mengandung karakter + dan 0-9
            if (!preg_match('/[^+0-9]/', trim($nomorhp))) {
                // cek apakah no hp karakter 1-3 adalah +62
                if (substr(trim($nomorhp), 0, 3) == '+62') {
                    $nomorhp = trim($nomorhp);
                    // echo $nomorhp;
                }
                // cek apakah no hp karakter 1 adalah 0
                elseif (substr($nomorhp, 0, 1) == '0') {
                    $nomorhp = '62' . substr($nomorhp, 1);
                    // $nomorhp1 = str_replace("'", "", $nomorhp);
                }
            }
            $target = $nomorhp;
            $name = $trx->name;


            $message = "Assalamu'alaikum Wr. Wb
                Bismillahirahmanirrahim.

                Yth. " . $trx->name . "

                Tanpa mengurangi rasa hormat, perkenankan kami mengundang Bapak/Ibu/Saudara/i, teman sekaligus sahabat, untuk menghadiri acara pernikahan kami :

                Rani & Ivan
                Hari/Tgl: Sabtu, 18 Mei 2024
                Pukul: 11.00-13.00
                Lokasi: Plaza BP Jamsostek

                Berikut link undangan kami untuk info lengkap dari acara bisa kunjungi :

                https://rani-ivan.com/invitation/" . str_replace(" ", "-", $trx->name) . "

                Merupakan suatu kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan untuk hadir dan memberikan doa restu. Atas perhatian nya kami ucapkan terimakasih.

                Wassalamu'alaikum Wr. Wb.";

            // var_dump($name);
            // echo $name;
            // exit;

            // $curl = curl_init();

            // curl_setopt_array($curl, array(
            //     CURLOPT_URL => 'https://api.fonnte.com/send',
            //     CURLOPT_RETURNTRANSFER => true,
            //     CURLOPT_ENCODING => '',
            //     CURLOPT_MAXREDIRS => 10,
            //     CURLOPT_TIMEOUT => 0,
            //     CURLOPT_FOLLOWLOCATION => true,
            //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //     CURLOPT_CUSTOMREQUEST => 'POST',
            //     CURLOPT_POSTFIELDS => array(
            //         'target' => $target,
            //         'message' => $message,
            //         'delay' => '2',
            //         'countryCode' => '62',
            //     ),
            //     CURLOPT_HTTPHEADER => array(
            //         "Authorization: $token"
            //     ),
            // ));

            // $response = curl_exec($curl);
            // $res = json_decode($response, true);
            // $err = curl_error($curl);
            // curl_close($curl);
            // // var_dump($res);
            // var_dump($response);
            // if ($err) {
            //     $fail_count++;
            // } else {
            //     if (isset($res["status"]) && $res["status"] == true) {
            //         foreach ($res["id"] as $k => $v) {
            //             $target = $res["target"][$k];
            //             $status = $res["process"];
            //             $update = $this->db->set('status', $status)
            //                 ->set('id', $v)
            //                 ->where('contact', $target)
            //                 ->update('undangan');
            //             if ($update) {
            //                 $success_count++;
            //             } else {
            //                 $fail_count++;
            //             }
            //         }
            //     } else {
            //         $fail_count++;
            //     }
            // }
        }

        if ($fail_count == 0) {
            echo json_encode(array('resp' => 'success', 'text' => 'Broadcast successfully to all recipients'));
        } else {
            echo json_encode(array('resp' => 'error', 'text' => 'Broadcast failed to some recipients'));
        }
    }

    function callback_status()
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $device = $data['device'];
        $id = $data['id'];
        $stateid = $data['stateid'];
        $status = $data['status'];
        $state = $data['state'];

        //update status and state
        if (isset($id) && isset($stateid)) {
            $update = $this->db->set('status', $status)
                ->set('state', $state)
                ->set('stateid', $stateid)
                ->where('id', $id)
                ->update('undangan');
            return $update;
            // mysqli_query($conn, "UPDATE report SET status = '$status',state = '$state',stateid = '$stateid' WHERE id = '$id'");
        } else if (isset($id) && !isset($stateid)) {
            $update = $this->db->set('status', $status)
                // ->set('state', $state)
                ->where('id', $id)
                ->update('undangan');
            return $update;
            // mysqli_query($conn, "UPDATE report SET status = '$status' WHERE id = '$id'");
        } else {
            $update = $this->db->set('state', $state)
                ->where('stateid', $stateid)
                ->update('undangan');
            return $update;

            // mysqli_query($conn, "UPDATE report SET state = '$state' WHERE stateid = '$stateid'");
        }
    }
}
