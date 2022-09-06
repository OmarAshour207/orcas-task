<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    // get users and save them
    public function add()
    {
        // get API list
        $userApis = config('user_api.apis');

        $client = new Client();
        foreach ($userApis as $userApi) {
            // send response
            $response = $client->request('GET', $userApi, ['verify' => false]);
            $users = json_decode($response->getBody()->getContents(), true);

            foreach ($users as $user) {

                // make rule from the data from API
                $rules = $this->getRules($user);

                $validator = Validator::make($user, $rules);

                if($validator->fails())
                    continue;

                $data = $validator->validated();

                // adapt key to save it in database using the next step
                $data = $this->adaptKeys($data);

                DB::insert("INSERT INTO users (firstname, lastname, email, avatar) VALUES (?, ?, ?, ?)",
                        [
                            $data['firstname'],
                            $data['lastname'],
                            $data['email'],
                            $data['avatar']
                        ]);
            }
        }

        return Response::json([
            'success'   => true,
            'message'   => "Added successfully"
        ]);
    }

    private function getRules($data)
    {
        $map = [
            'firstName'     => 'required',
            'lastName'      => 'required',
            'avatar'        => 'required',
            'fName'         => 'required',
            'lName'         => 'required',
            'picture'       => 'required',
            'email'         => 'required|unique:users'
        ];

        $rules = [];

        // make rule from the data from API
        foreach ($data as $key => $value) {
            if (key_exists($key, $map)) {
                $rules[$key] = $map[$key];
            }
        }

        return $rules;
    }

    private function adaptKeys($data)
    {
        $dataMap = [
            'firstName'     => 'firstname',
            'lastName'      => 'lastname',
            'avatar'        => 'avatar',
            'fName'         => 'firstname',
            'lName'         => 'lastname',
            'picture'       => 'avatar',
            'email'         => 'email'
        ];

        foreach ($data as $key => $value) {
            $data[$dataMap[$key]] = $value;
        }

        return $data;
    }

    // get users
    public function index()
    {
        return User::paginate(10);
    }

    // search using firstname, lastname, email
    public function search(Request $request)
    {
        $searchValue = $request->get('search_value');

        // using scope in the Model
        $users = User::search($searchValue)->get();

        return Response::json($users)->setStatusCode(200);
    }

}
