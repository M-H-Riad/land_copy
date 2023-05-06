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
use Illuminate\Support\Str;

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


}
