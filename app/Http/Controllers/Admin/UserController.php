<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\Facades\Splade;
use ProtoneMedia\Splade\SpladeTable;
use Spatie\Permission\Models\Role;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\Hash;

use App\Helpers\FormatoFecha;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:users')->only('index', '__invoke');
        $this->middleware('can:user.show')->only('show');
        // $this->middleware('can:user.edit')->only('edit', 'update');
    }

    public function __invoke(Request $request)
    {
        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('name', 'LIKE', "%{$value}%")
                        ->orWhere('email', 'LIKE', "%{$value}%");
                });
            });
        });

        $fecha = new FormatoFecha();

        //$users = QueryBuilder::for(User::class)
        $users = QueryBuilder::for(User::with('roles'))
            ->defaultSort('-created_at')
            ->allowedSorts(['name', 'email', 'created_at'])
            ->allowedFilters(['name', 'email', $globalSearch])
            ->paginate()
            ->withQueryString();
        //dd($users);
        return view('admin.users.index', [
            'users' => SpladeTable::for($users)
                ->defaultSort('name')
                ->withGlobalSearch()
                ->column('name', label: 'Nombre', sortable: true, searchable: true)
                ->column('roles.name', label: 'Roles')
                ->column('email', sortable: true, searchable: true)
                ->column(
                    key: 'email_verified_at',
                    as: fn($dato) => $fecha->fecha_dmyhm($dato),
                    label: 'Fecha email'
                )
                ->column(
                    key: 'is_active',
                    as: fn($dato) => $dato ? 'Activo' : 'Inactivo',
                    label: 'Estado'
                )
                ->column(
                    key: 'created_at',
                    as: fn($dato) => $fecha->fecha_dmy($dato),
                    label: 'Creado en',
                    sortable: true
                )
                ->column('action')
            // ->rowLink(function(User $user){
            //     return route('users.show', $user);
            // })
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     return view('admin.users.index');
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $roles = Role::find($request->roles)->pluck('name');

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'is_active' => $request->is_active,
            'password' => Hash::make($request->password),
        ])->assignRole($roles);

        Splade::toast('Usuario creado')->autoDismiss(5);

        return redirect()->route('users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all();
        $userRoleIds = $user->roles->pluck('id')->toArray();
        // Retornar la vista con el usuario
        return view('admin.users.edit', compact('user', 'roles', 'userRoleIds'));
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
        $roles = Role::find($request->roles)->pluck('id');

        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->is_active = $request->is_active;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        $user->roles()->sync($roles);

        Splade::toast('Usuario actualizado')->autoDismiss(5);

        return redirect()->route('users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function email_confirm($id)
    {
        $user = User::findOrFail($id);

        if (!$user->email_verified_at) {
            $user->email_verified_at = Carbon::now()->toDateTimeString();
        }

        $user->save();

        Splade::toast('Email confirmado!')->autoDismiss(5);

        return redirect()->route('users');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function active($id)
    {
        $user = User::findOrFail($id);

        $user->is_active = !$user->is_active;

        $user->save();

        Splade::toast('Estado de usuario actualizado!')->autoDismiss(5);

        return redirect()->route('users');
    }
}
