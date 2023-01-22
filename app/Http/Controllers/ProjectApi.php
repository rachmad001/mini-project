<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Termwind\Components\Raw;

class ProjectApi extends Controller
{
    public function add(Request $req)
    {
        $error_msg = array(
            "status" => false,
            "msg" => ""
        );
        if ($req->project_name == NULL || $req->project_name == "") {
            $error_msg["msg"] = "project name kosong atau tidak ditemukan";
            return json_encode($error_msg);
        }
        if ($req->client_id == NULL || $req->client_id == "") {
            $error_msg["msg"] = "client id kosong atau tidak ditemukan";
            return json_encode($error_msg);
        }
        if ($req->project_start == NULL || $req->project_start == "") {
            $error_msg["msg"] = "project start kosong atau tidak ditemukan";
            return json_encode($error_msg);
        }
        if ($req->project_end == NULL || $req->project_end == "") {
            $error_msg["msg"] = "project end kosong atau tidak ditemukan";
            return json_encode($error_msg);
        }
        if ($req->project_end < $req->project_start) {
            $error_msg["msg"] = "project end tidak boleh lebih kecil dari project start";
            return json_encode($error_msg);
        }
        if ($req->project_status == NULL || $req->project_status == "") {
            $error_msg["msg"] = "project status kosong atau tidak ditemukan";
            return json_encode($error_msg);
        }
        $result = DB::insert('
            insert into tb_m_project(project_name, client_id, project_start, project_end, project_status)
            values(?,?,?,?,?)
        ', [$req->project_name, $req->client_id, $req->project_start, $req->project_end, $req->project_status]);
        if ($result) {
            return json_encode(array(
                "status" => true,
                "msg" => "berhasil menambahkan project"
            ));
        } else {
            return json_encode(array(
                "status" => false,
                "msg" => "gagal menambahkan project"
            ));
        }
    }

    public function index(Request $req)
    {
        $id = $req->input('id', NULL);
        if ($id == NULL) {
            $data = DB::select('
                select pr.*, cl.client_name from tb_m_project as pr 
                inner join tb_m_client as cl on cl.client_id = pr.client_id
            ');
            return json_encode($data);
        }
        $data = DB::select('
                select pr.*, cl.client_name from tb_m_project as pr 
                inner join tb_m_client as cl on cl.client_id = pr.client_id
                WHERE project_id = ?
            ', [$id]);
            return json_encode($data);
    }

    public function delete(Request $req)
    {

        $list_id = $req->input('project_id', NULL);
        if ($list_id == NULL) {
            return json_encode(array(
                "status" => false,
                "msg" => "tidak ada data yang dipilih"
            ));
        }
        $in = "(";
        foreach ($list_id as $id) {
            $in .= "?,";
        }
        $in[strlen($in) - 1] = ")";
        $result = DB::delete('delete from tb_m_project where project_id IN ' . $in, $list_id);
        if ($result > 0) {
            return json_encode(array(
                "status" => true,
                "msg" => "berhasil menghapus data"
            ));
        }
        var_dump($in);
        // print_r($list_id);
    }

    public function filter(Request $req)
    {
        if ($req->client == "#" && $req->status == "#" && $req->project != "") {
            $hasil = DB::select(
                'select pr.*, cl.client_name from tb_m_project as pr 
            inner join tb_m_client as cl on cl.client_id = pr.client_id
            where pr.project_name LIKE \'%' . $req->project . '%\''
            );
            return json_encode($hasil);
        }
        if ($req->client == "#" && $req->status != "#" && $req->project != "") {
            $hasil = DB::select('
            select pr.*, cl.client_name from tb_m_project as pr 
            inner join tb_m_client as cl on cl.client_id = pr.client_id
            where pr.project_name LIKE \'%' . $req->project . '%\' and project_status = ?
            ', [$req->status]);
            return json_encode($hasil);
        }
        if ($req->client != "#" && $req->status != "#" && $req->project != "") {
            $hasil = DB::select('
            select pr.*, cl.client_name from tb_m_project as pr 
            inner join tb_m_client as cl on cl.client_id = pr.client_id
            where pr.project_name LIKE \'%' . $req->project . '%\' and pr.project_status = ? and pr.client_id = ?
            ', [$req->status, $req->client]);
            return json_encode($hasil);
        }
        if ($req->client != "#" && $req->status != "#" && $req->project == "") {
            $hasil = DB::select('
            select pr.*, cl.client_name from tb_m_project as pr 
            inner join tb_m_client as cl on cl.client_id = pr.client_id
            where pr.project_status = ? and pr.client_id = ?
            ', [$req->status, $req->client]);
            return json_encode($hasil);
        }
        if ($req->client != "#" && $req->status == "#" && $req->project == "") {
            $hasil = DB::select('
            select pr.*, cl.client_name from tb_m_project as pr 
            inner join tb_m_client as cl on cl.client_id = pr.client_id
            where pr.client_id = ?
            ', [$req->client]);
            return json_encode($hasil);
        }
        if ($req->client == "#" && $req->status != "#" && $req->project == "") {
            $hasil = DB::select('
            select pr.*, cl.client_name from tb_m_project as pr 
            inner join tb_m_client as cl on cl.client_id = pr.client_id
            where pr.project_status = ?
            ', [$req->status]);
            return json_encode($hasil);
        }
    }

    public function edit(Request $req){
        $error_msg = array(
            "status" => false,
            "msg" => ""
        );
        if($req->project_id == NULL || $req->project_id == ""){
            $error_msg["msg"] = "project id kosong atau tidak ditemukan";
            return json_encode($error_msg);
        }
        if ($req->project_name == NULL || $req->project_name == "") {
            $error_msg["msg"] = "project name kosong atau tidak ditemukan";
            return json_encode($error_msg);
        }
        if ($req->client_id == NULL || $req->client_id == "") {
            $error_msg["msg"] = "client id kosong atau tidak ditemukan";
            return json_encode($error_msg);
        }
        if ($req->project_start == NULL || $req->project_start == "") {
            $error_msg["msg"] = "project start kosong atau tidak ditemukan";
            return json_encode($error_msg);
        }
        if ($req->project_end == NULL || $req->project_end == "") {
            $error_msg["msg"] = "project end kosong atau tidak ditemukan";
            return json_encode($error_msg);
        }
        if ($req->project_end < $req->project_start) {
            $error_msg["msg"] = "project end tidak boleh lebih kecil dari project start";
            return json_encode($error_msg);
        }
        if ($req->project_status == NULL || $req->project_status == "") {
            $error_msg["msg"] = "project status kosong atau tidak ditemukan";
            return json_encode($error_msg);
        }
        $hasil = DB::update('
        update tb_m_project 
        set project_name = ?,
        client_id = ?,
        project_start = ?,
        project_end = ?,
        project_status = ?
        where project_id = ?',[$req->project_name, $req->client_id, $req->project_start, $req->project_end, $req->project_status, $req->project_id]);
        if($hasil > 0){
            return json_encode(array(
                "status" => true,
                "msg" => "berhasil mengubah data"
            ));
        }else {
            return json_encode(array(
                "status" => false,
                "msg" => "gagal mengubah data"
            ));
        }
    }
}
