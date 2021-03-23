<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\UserRequest;
use App\Models\User;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $total = User::count();
        $filtered = 0;
        $data = [];
        $search = $request->input('search')['value'];

        $orderColumnIndex = $request->input('order')[0]['column'];
        $orderColumn = $request->input('columns')[$orderColumnIndex]['data'];
        $orderDir = $request->input('order')[0]['dir'];
        
        if ($search) {
            $q = '%'.$search.'%';
            $query = User::whereHas('roles', function ($query) use ($q) {
                $query->where('name', 'ilike', $q)
                      ->orWhere('email', 'ilike', $q)
                      ->orWhere('roles.name', 'ilike', $q);
            })->orderBy($orderColumn, $orderDir);
            $users = $query->offset($start)->limit($length)->get();
            $filtered = $query->count();
        } else {
            $users = User::orderBy($orderColumn, $orderDir)->offset($start)->limit($length)->get();
            $filtered = $total;
        }

        foreach ($users as $user) {
            $user_roles = [];
            foreach ($user->roles as $role) {
                $user_roles[] = $role->name;
            }
            $data[] = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $user_roles,
                'created_at' => Carbon::parse($user->created_at)->toDateTimeString(),
            ];
        }
        return response()->json([
            'search' => $search,
            'draw' => $draw,
            'recordsTotal' => $total,
            'recordsFiltered' => $filtered,
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        \DB::beginTransaction();
        $status = false;
        $code = 422;
        $message = '';
        $sTime = microtime(true);
        try {        
            $model = new User;
            
            $data = [
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => bcrypt($request->get('password'))
            ];
            
            
            if ($model->fill($data) && $model->save()) {
                $model->roles()->attach($request->get('role'));
                \DB::commit();
                $msg = "User Success Saved";
                $status = true;
                $code = 200;
                $message = 'Success';
            }
        } catch (\Throwable $e) {
            \DB::rollback();
            $status = false;
            $message = 'Unprocessable Entity';
            $msg = 'User not Updated';
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => [
                'message'=>$msg,
            ],
            'time' => microtime(true) - $sTime
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        \DB::beginTransaction();
        $status = false;
        $code = 422;
        $message = '';
        $sTime = microtime(true);
        try {        
            $model = User::findOrFail($id);

            $data = [
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => bcrypt($request->get('password'))
            ];

            
            if ($model->fill($data) && $model->save()) {
                $model->roles()->sync($request->get('role'));

                \DB::commit();
                $msg = "User Success Saved";
                $status = true;
                $code = 200;
                $message = 'Success';
            }
        } catch (\Throwable $e) {
            \DB::rollback();
            $status = false;
            $message = 'Unprocessable Entity';
            $msg = 'User not Updated';
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => [
                'message'=>$msg,
            ],
            'time' => microtime(true) - $sTime
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \DB::beginTransaction();
        $status = false;
        $code = 422;
        $message = '';
        $sTime = microtime(true);
        try {
            $model = User::findOrFail($id);
            $model->delete();
            \DB::commit();
            $msg = "User Success Deleted";
            $status = true;
            $code = 200;
            $message = 'Success';
        } catch (\Throwable $th) {
            \DB::rollback();
            $status = false;
            $message = 'Unprocessable Entity';
            $msg = 'User not Deleted';
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => [
                'message'=>$msg,
            ],
            'time' => microtime(true) - $sTime
        ]);

    }
}
