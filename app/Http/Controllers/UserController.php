<?php

namespace App\Http\Controllers;

use App\Http\Requests\{StoreUserRequest, UpdateUserRequest};
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Models\Role;
use Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Path for user avatar file.
     *
     * @var string
     */
    protected $avatarPath = '/uploads/images/avatars/';

    public function __construct()
    {
        $this->middleware('permission:user view')->only('index', 'show');
        $this->middleware('permission:user create')->only('create', 'store');
        $this->middleware('permission:user edit')->only('edit', 'update');
        $this->middleware('permission:user delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $users = User::with('roles:id,name');
            return Datatables::of($users)
                ->addIndexColumn()
                ->addColumn('action', 'users.include.action')
                ->addColumn('role', function ($row) {
                    return $row->getRoleNames()->toArray() !== [] ? $row->getRoleNames()[0] : '-';
                })
                ->addColumn('phone', function ($row) {
                    return $row->phone ? $row->phone  : '-';
                })
                ->addColumn('key_sort_unit', function ($row) {
                    return $row->key_sort_unit ? $row->key_sort_unit  : '-';
                })
                ->addColumn('avatar', function ($row) {
                    if ($row->avatar == null) {
                        return 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($row->email))) . '&s=500';
                    }
                    return asset($this->avatarPath . $row->avatar);
                })
                ->toJson();
        }

        return view('users.index');
    }


    public function create()
    {
        return view('users.create');
    }

    public function store(StoreUserRequest $request)
    {
        $attr = $request->validated();

        if ($request->file('avatar') && $request->file('avatar')->isValid()) {

            $filename = $request->file('avatar')->hashName();

            if (!file_exists($folder = public_path($this->avatarPath))) {
                mkdir($folder, 0777, true);
            }

            Image::make($request->file('avatar')->getRealPath())->resize(500, 500, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($this->avatarPath . $filename);

            $attr['avatar'] = $filename;
        }

        $attr['password'] = bcrypt($request->password);

        $user = User::create($attr);

        $user->assignRole($request->role);

        Alert::toast('The user was created successfully.', 'success');
        return redirect()->route('users.index');
    }

    public function show(User $user)
    {
        $user->load('roles:id,name');

        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $user->load('roles:id,name');

        return view('users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $attr = $request->validated();

        if ($request->file('avatar') && $request->file('avatar')->isValid()) {
            $filename = $request->file('avatar')->hashName();

            // if folder don't exist, then create folder
            if (!file_exists($folder = public_path($this->avatarPath))) {
                mkdir($folder, 0777, true);
            }

            // Intervention Image
            Image::make($request->file('avatar')->getRealPath())->resize(500, 500, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save(public_path($this->avatarPath) . $filename);

            // delete old avatar from storage
            if ($user->avatar != null && file_exists($oldAvatar = public_path($this->avatarPath . $user->avatar))) {
                unlink($oldAvatar);
            }

            $attr['avatar'] = $filename;
        } else {
            $attr['avatar'] = $user->avatar;
        }

        if (is_null($request->password)) {
            unset($attr['password']);
        } else {
            $attr['password'] = bcrypt($request->password);
        }

        // Convert $request->role to an array if it's a string
        $newRoles = is_array($request->role) ? $request->role : explode(',', $request->role);

        // Fetch the user's current roles
        $oldRoles = $user->roles->pluck('name')->toArray();

        // Convert role IDs to names
        $newRoleNames = Role::whereIn('id', $newRoles)->pluck('name')->toArray();

        // Log changes if the role is different
        if ($oldRoles !== $newRoleNames) {
            activity()
                ->useLog('log_user') // Set custom log name
                ->causedBy(auth()->user())
                ->performedOn($user)
                ->withProperties([
                    'old' => ['roles' => $oldRoles],
                    'attributes' => ['roles' => $newRoleNames],
                ])
                ->event('updated') // Set event name
                ->log("User {$user->name} role updated"); // Custom log message
        }

        $user->update($attr);

        // Sync roles
        $user->syncRoles($newRoleNames);

        Alert::toast('The user was updated successfully.', 'success');
        return redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
        if ($user->avatar != null && file_exists($oldAvatar = public_path($this->avatarPath . $user->avatar))) {
            unlink($oldAvatar);
        }

        $user->delete();

        Alert::toast('The user was deleted successfully.', 'success');
        return redirect()->route('users.index');
    }

    public function updateNoWa(Request $request)
    {
        // Validasi input
        $request->validate([
            'no_wa' => 'required|numeric|digits_between:10,15',
        ], [
            'no_wa.required' => 'Nomor WhatsApp harus diisi.',
            'no_wa.numeric' => 'Nomor WhatsApp hanya boleh berisi angka.',
            'no_wa.digits_between' => 'Nomor WhatsApp harus memiliki panjang antara 10 hingga 15 digit.',
        ]);

        // Ambil user yang sedang login
        $user = Auth::user();

        // Update nomor WhatsApp
        $user->phone = $request->input('no_wa');
        $user->save();

        // Hapus session yang menunjukkan form untuk input nomor WA
        session()->forget('show_form_no_wa');

        // Tampilkan notifikasi berhasil
        Alert::toast('Nomor WhatsApp berhasil diperbarui.', 'success');

        // Redirect kembali ke halaman sebelumnya
        return redirect()->back();
    }
}
