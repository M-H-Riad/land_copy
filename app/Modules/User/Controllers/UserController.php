<?php namespace App\Modules\User\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Modules\User\Models\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use DB;
use App\Mail\UserRegistration;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    public function index()
    {
        $data['title'] = 'View Users';
        $data['roles'] = Role::with('perms')->orderBy('display_name', 'asc')->get();
        // dd($data['roles']);
        return View::make('User::role.index', $data);
    }


    public function index_user()
    {
        $pageTitle = "User List";
        $model     = User::where( 'status', '=', '1' )->orderBy( 'id', 'DESC' )->get();

        return view( 'User::user.index', [
            'model'     => $model,
            'pageTitle' => $pageTitle
        ] );
    }


    public function edit_user($id)
    {
        //echo $id;die;
        $title = 'Update User Information';
        $user = User::findOrFail( $id );
        //print_r($user);die;
        return view('User::user.edit', compact('user','title'));
    }



    public function update_user($id, Request $request)
    {
        $user            = User::findOrFail($id);

        //echo $id;
       // print_r($user);
        //die;

        $user->name        = $request['name'];
        $user->email       = $request['email'];
        $user->user_name   = $request['user_name'];
        $user->password    = bcrypt($request['password']);
        $user->save();


        Session::flash('success','Successfully updated');
        return redirect()->route('user-list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //    if(!Auth::user()->can('user-management')) { abort(403); }
        if(Auth::user()->stakeholder_id) {
            $roles = ['' => 'Select One'] + Role::where(['stakeholder_id' => Auth::user()->stakeholder_id])->pluck('display_name', 'id')->all();
        }else{
            $roles = ['' => 'Select One'] + Role::pluck('display_name', 'id')->all();
        }
        return view('User::create',compact('roles'));
    }


    /**
     * @return mixed
     */
    public function getData()
    {
        if(Auth::user()->stakeholder_id){
            $query = User::where(['stakeholder_id' => Auth::user()->stakeholder_id])->orderBy('created_at','desc')->select();
        }else{
            $query = User::orderBy('created_at','desc')->select();
        }
        return Datatables::of($query)
        ->editColumn('created_at',function ($list){
            return $list->created_at;
        })
//            ->editColumn('updated_at',function ($list){
////                return $list->updated_at->diffForHumans();
//            })
        ->addColumn('actions', function ($list){
            return '<a href="' . route('user.edit' , ($list->id)) . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a> &nbsp;';
        })
//            ->addColumn('modules', function ($list){
//                return $list->id;
//            })
        ->rawColumns(['actions', 'name'])
        ->make(true);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'role_id'   => 'required',
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users',
            'password'  => 'required|string|min:6|confirmed',
        ]);

        $data = [
            'name'          => $request['name'],
            'email'         => $request['email'],
            'stakeholder_id'=> Auth::user()->stakeholder_id,
            'password'      => bcrypt($request['password']),
        ];

        $user = User::create($data);
        $user->roles()->sync((array)$request->get('role_id'));

        Session::flash('success','Successfully added');
        return redirect()->route('user.index');
    }

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $id
     * @return Response
     */
    public function edit($id = '')
    {
       $id = empty($id)? Auth::user()->id : $id;
       $data = User::findOrFail($id);
       if(Auth::user()->stakeholder_id) {
        $roles = ['' => 'Select One'] +
        Role::where(['stakeholder_id' => Auth::user()->stakeholder_id])
        ->orWhere(['id' => 3])
        ->pluck('display_name', 'id')->all();
    }else{
        $roles = ['' => 'Select One'] + Role::pluck('display_name', 'id')->all();
    }
    return view('User::edit', compact('data','roles'));
}

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param Request $request
     * @return Response
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'role_id'       => 'required',
            'name'          => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:users,id,'.$id,
            'avatar'        => commonImageValidator(),
        ]);

        $user            = User::findOrFail($id);
        $user->name      = $request['name'];
        $user->email     = $request['email'];
        $user->save();

        $user->roles()->sync((array)$request->get('role_id'));

        if($request->hasFile('avatar')){
            $photoName = $user->id.'.jpg';
            $path = 'uploads/avatars';
            $request->avatar->move($path, $photoName);
//            $user->email     = $request['email'];
//            $user->save();
        }

        Session::flash('success','Successfully updated');
        return redirect()->route('user.index');
    }

    public function profile()
    {
      $user = User::findOrFail(Auth::user()->id);
      return view('User::profile', compact('user'));
  }

    public function register_create(Request $request)
    {
        $this->validate($request, [
            'department_id' => 'required',
            'phone' => 'required',
            'designation_id' => 'required',
            'email'     => 'required|string|email|max:255|unique:users',
            'password'  => 'required|string|min:6|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{6,}$/',
            
        ]);
  
        $data = [
            'full_name' => $request['first_name'].' '.$request['last_name'],
            'full_name_ban' => $request['first_name_ban'].' '.$request['last_name_ban'],
            'pf_no' => $request['pf_no'],
            'office_id' => $request['office_id'],
            'department_id' => $request['department_id'],
            'phone' => $request['phone'],
            'designation_id' => $request['designation_id'],
            'email'     => $request['email'],
            'user_name' => explode('@',$request['email'])[0],
            'password'      => bcrypt($request['password']),
        ];

        $id=user::create($data)->id;
        $data['id']=$id;
        //Mail send to user---------
        Mail::to($request['email'])->send(new UserRegistration($data));

        Session::flash('success','Successfully added');
        return redirect()->route('user-list');
    }


    public function register(Request $request)
    {


        $departments = DB::table('departments')->get();
        $designations = DB::table('designations')->get();

        return view('User::register.register',['departments' => $departments,'designations'=>$designations]);

        //return view('Land::zone.index', compact('zones'));

        /*$this->validate($request, [
            'role_id'   => 'required',
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users',
            'password'  => 'required|string|min:6|confirmed',
        ]);

        $data = [
            'name'          => $request['name'],
            'email'         => $request['email'],
            'stakeholder_id'=> Auth::user()->stakeholder_id,
            'password'      => bcrypt($request['password']),
        ];

        $user = User::create($data);
        $user->roles()->sync((array)$request->get('role_id'));

        Session::flash('success','Successfully added');
        return redirect()->route('user.index');*/
    }










  public function structure()
  {
    $role = Role::where('stakeholder_id', Auth::user()->stakeholder_id)->where('parent_id')->first(['display_name','id']);
    return view('User::structure',compact('role'));
}

public function change_password(Request $request){
    $this->validate($request, [
        "old_password" => "required",
        "password" => "required|confirmed",
        "password_confirmation" => "required|same:password"
    ]);
    $password = Hash::make($request->password);
    $user = User::findOrFail(Auth::user()->id);
    if (!Hash::check($request->old_password,$user->password)) {
    // The passwords match...
        \App\Library\AuditTrailLib::addTrail('User',Auth::user()->user_name,'Change Password - Old password not matched','Failed');
        return redirect()->back()->withErrors('Old Password did not matched.');
    }
    $user->password = $password;
    if($user->save()){
        \App\Library\AuditTrailLib::addTrail('User',Auth::user()->user_name,'Change Password','Success');
        return redirect()->back()->with('success','Password changed successfully.');
    }
    else{
        \App\Library\AuditTrailLib::addTrail('User',Auth::user()->user_name,'Change Password -  not done','Failed');
        return redirect()->back()->withErrors('Password change failed.');
    }
 }

   public function user_activation($id){
        $data=User::find($id);

        $startTime = Carbon::parse($data->created_at);
        $endTime = Carbon::parse(now());
        $totalDuration = $endTime->diffInMinutes($startTime);
       
        if($totalDuration > 30){
            $datas['error']='Your 30 minutes time exceed. You have to activated your account within 30 minutes';
            return view('emails.userRegistration',compact('datas'));
        }
        else
        {
            $user            = User::findOrFail($id);
            $user->status     = 1;
            $user->save();

            $data_new['success']='Congratulatons, Your account is activated!';

            return view('emails.userRegistration',compact('data_new'));
        }
        
   }

   public function showResetForm($token){
   
         $user=User::where('remember_token',$token)->first();

        return view('auth.passwords.reset')->with(
            ['email' => $user->email]
        );
   }

   public function userPasswordUpdate(Request $request){
        $this->validate($request, [
            "password" => "required|confirmed",
            "password_confirmation" => "required|same:password"
        ]);

        $password = Hash::make($request->password);

        User::where('email',$request->email)->update(['password'=>$password]);

        return redirect('/login')->with('success_new','We have e-mailed your password reset link!');
   }
}
