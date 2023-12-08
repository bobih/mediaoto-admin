<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use \Firebase\JWT\JWT;
use DB;

class UserController extends Controller
{
    public function getUserInfo(Request $request)
    {

        $userid = $request['userid'];
        if (is_null($userid)) {
            return $this->respond(['error' => 'Invalid User'], 401);
        }

        //$userid = 25;
        $sql = "SELECT * from users WHERE id='" . $userid . "' LIMIT 1";
        $query = DB::table('users')->where('id', $userid)->get();

        $data = [];
        $x = 0;
        foreach ($query as $rows) {
            if ($rows->quota == 0) {
                $rows->quota = "0";
            }
            $data[$x]['id'] = $rows->id;
            $data[$x]['nama'] = trim(ucwords($rows->nama));
            $data[$x]['email'] = $rows->email;
            $data[$x]['phone'] = $rows->phone;
            $data[$x]['quota'] = $rows->quota; // $rows->phone'];
            $data[$x]['alamat'] = $rows->alamat;
            $data[$x]['lokasi'] = $rows->lokasi;
            $data[$x]['ktp'] = $rows->ktp;
            $data[$x]['npwp'] = $rows->npwp;
            $data[$x]['image'] = $rows->image;


            $data[$x]['fcmtoken'] = $rows->fcmtoken;

            $data[$x]['register'] = $rows->created_at;


            $key = getenv('JWT_SECRET');
            $iat = time(); // current timestamp value
            $exp = $iat + 36000;

            $payload = array(
                "iss" => "mediaoto",
                "aud" => "mobile",
                "sub" => "api",
                "iat" => $iat, //Time the JWT issued at
                "exp" => $exp, // Expiration time of token
                "email" => $rows->email,
            );

            $token = JWT::encode($payload, $key, 'HS256');
            $data[$x]['token'] = $token;


            $x++;

        }

        array_walk_recursive($data, function (&$item) {
            $item = strval($item); });
        return response()->json($data, 200);
    }


    public function updateImage()
    {


        $userid = trim($this->request->getVar('userid', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $nama = trim($this->request->getVar('nama', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $phone = trim($this->request->getVar('phone', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $alamat = trim($this->request->getVar('alamat', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        $file = $this->request->getFile('file');

        if (!$file->isValid()) {
            return $this->respond(['error' => 'Update Faled'], 401);
        }
        ;


        $newName = $file->getRandomName();
        if ($file->move('/DATA/mediaoto/public_html/images', $newName)) {
            $db = db_connect();
            $sql = "UPDATE `users` SET `nama`='" . $nama . "', `phone`='" . $phone . "', `alamat`='" . $alamat . "', `image` = '" . $newName . "' WHERE `users`.`id` = '" . $userid . "';";
            $query = $db->query($sql);
            $db->close();
            // remove old filename
            $oldfile = '/DATA/mediaoto/public_html/images/' . basename(trim($this->request->getVar('oldfilename')));
            //delete_files($path);
            if (file_exists($oldfile)) {
                unlink($oldfile);
            }

            return $this->respond(['message' => 'Update Successfully'], 200);
        } else {
            return $this->respond(['error' => 'Update Faled'], 401);
        }
    }

    public function updateUserInfo()
    {
        $userid = trim($this->request->getVar('userid', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $nama = trim($this->request->getVar('nama', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $phone = trim($this->request->getVar('phone', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $alamat = trim($this->request->getVar('alamat', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        $db = db_connect();
        $sql = "UPDATE `users` SET `nama`='" . $nama . "', `phone`='" . $phone . "', `alamat`='" . $alamat . "' WHERE `users`.`id` = '" . $userid . "';";
        if ($db->query($sql)) {
            $db->close();
            return $this->respond(['message' => 'Update Successfully'], 200);
        } else {
            return $this->respond(['error' => 'Update Faled'], 401);
        }
    }

    public function changePassword()
    {

        $userModel = new UserModel();

        $userid = trim($this->request->getVar('userid', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $oldPassword = $this->request->getVar('oldpassword');
        //$oldPassword  = password_hash(trim($this->request->getVar('oldpassword')), PASSWORD_DEFAULT);
        $newPassword = password_hash(trim($this->request->getVar('newpassword')), PASSWORD_DEFAULT);

        $user = $userModel->where('id', $userid)->first();
        $pwd_verify = password_verify($oldPassword, $user['password']);

        $db = db_connect();

        if ($pwd_verify) {
            $sql = "UPDATE `users` SET password = '" . $newPassword . "' WHERE `users`.`id` = '" . $userid . "';";
            if ($db->query($sql)) {
                return $this->respond(['message' => 'Update Successfully'], 200);
            } else {
                return $this->respond(['error' => 'Update Faled'], 401);
            }
        } else {
            return $this->respond(['error' => 'Update Faled'], 401);
        }
    }
}
