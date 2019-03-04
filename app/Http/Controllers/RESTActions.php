<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

trait RESTActions {

    public function all()
    {
        $m = self::MODEL;
        $get = $m::all();
        $data['status'] = 'success';
        $data['message'] = '';
        $data['result'] = $get;

        return response()->json($data, Response::HTTP_OK);
    }

    public function get($id)
    {
        $m = self::MODEL;
        $get = $m::find($id);
        if(is_null($get)){
            $data['status'] = 'error';
            $data['message'] = 'Data Tidak Bisa Ditemukan !';
            $data['result'] = $get;
            $status = Response::HTTP_NOT_FOUND;
        } else {
            $data['status'] = 'success';
            $data['message'] = '';
            $data['result'] = $get;
            $status = Response::HTTP_OK;
        }
        return response()->json($data, $status);
    }

    public function add(Request $request)
    {
        $m = self::MODEL;
        $valid = Validator::make($request->all(), $m::$rules_add);
        if ($valid->fails()) {
            $error = $valid->errors();
            $data['status'] = 'error';
            $data['message'] = $error;
            $data['result'] = null;
            $status = 400;
        } else {
            $filter = $request->all();

            $get = $m::create($filter);
            if ($get) {
                $data['status'] = 'success';
                $data['message'] = 'Data Berhasil Ditambahkan !';
                $data['result'] = $get;
                $status = 201;
            } else {
                $data['status'] = 'error';
                $data['message'] = 'Data Gagal Ditambahkan !';
                $data['result'] = $get;
                $status = 400;
            }
        }

        return response()->json($data, $status);
    }

    public function put(Request $request, $id)
    {
        $m = self::MODEL;
        $valid = Validator::make($request->all(), $m::$rules_update);
        if ($valid->fails()) {
            $error = $valid->errors();
            $data['status'] = 'error';
            $data['message'] = $error;
            $data['result'] = null;
            $status = 400;
        } else {
            $filter = $request->all();

            $get = $m::find($id);
            if ($get) {
                if ($get->update($filter)) {
                    $data['status'] = 'success';
                    $data['message'] = 'Data Berhasil Diubah !';
                    $data['result'] = $get;
                    $status = 201;
                } else {
                    $data['status'] = 'error';
                    $data['message'] = 'Data Gagal Diubah !';
                    $data['result'] = $get;
                    $status = 400;
                }
            } else {
                $data['status'] = 'error';
                $data['message'] = 'Data Tidak Ditemukan !';
                $data['result'] = $get;
                $status = 400;
            }
        }

        return response()->json($data, $status);
    }

    public function remove($id)
    {
        $m = self::MODEL;
        $get = $m::find($id);
        if ($get) {
            if ($m::destroy($id)) {
                $data['status'] = 'success';
                $data['message'] = 'Data Berhasil Dihapus !';
                $data['result'] = true;
                $status = 200;
            } else {
                $data['status'] = 'error';
                $data['message'] = 'Data Gagal Dihapus !';
                $data['result'] = false;
                $status = 400;
            }
        } else {
            $data['status'] = 'error';
            $data['message'] = 'Data Tidak Ditemukan !';
            $data['result'] = $get;
            $status = 400;
        }

        return response()->json($data, $status);
    }

    public function login(Request $request) 
    {
        $m = self::MODEL;
        $valid = Validator::make($request->all(), $m::$rules_add);
        if ($valid->fails()) {
            $error = $valid->errors();
            $data['status'] = 'error';
            $data['message'] = $error;
            $data['result'] = null;
            $status = 400;
        } else {
            $get = $m::where('username', '=', $request['username'])->where('password', '=', $request['password'])->get();
            if (count($get) > 0) {
                $data['status'] = 'success';
                $data['message'] = 'Berhasil Login !';
                $data['result'] = $get;
                $status = 200;
            } else {
                $data['status'] = 'error';
                $data['message'] = 'Gagal Login !';
                $data['result'] = $get;
                $status = 400;
            }
        }

        return response()->json($data, $status);
    }

    public function register(Request $request)
    {
        $m = self::MODEL;
        $valid = Validator::make($request->all(), $m::$rules_add);
        if ($valid->fails()) {
            $error = $valid->errors();
            $data['status'] = 'error';
            $data['message'] = $error;
            $data['result'] = null;
            $status = 400;
        } else {
            $requestData = $request->all();
            $get = $m::create($requestData);
            if ($get) {
                $data['status'] = 'success';
                $data['message'] = 'Berhasil Di Daftarkan !';
                $data['result'] = $get;
                $status = 200;
            } else {
                $data['status'] = 'error';
                $data['message'] = 'Gagal Di Daftarkan !';
                $data['result'] = $get;
                $status = 400;
            }
        }

        return response()->json($data, $status);
    }

}
