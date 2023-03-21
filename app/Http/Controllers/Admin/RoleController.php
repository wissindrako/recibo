<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\Facades\Splade;
use ProtoneMedia\Splade\SpladeTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('name', 'LIKE', "%{$value}%")
                        ->orWhere('guard_name', 'LIKE', "%{$value}%");
                });
            });
        });

        $roles = QueryBuilder::for(Role::class)
        ->defaultSort('name')
        ->allowedSorts(['name', 'guard_name'])
        ->allowedFilters(['name', 'guard_name', $globalSearch])
        ->paginate()
        ->withQueryString();
        return view('admin.roles.index', [
            'roles' => SpladeTable::for($roles)
            ->defaultSort('name')
            ->withGlobalSearch()
            ->column('name', sortable: true, searchable: true)
            ->column('guard_name', sortable: true, searchable: true)
            ->column('action')
            // ->rowLink(function(User $user){
            //     return route('users.show', $user);
            // })
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rol = Role::findOrFail($id);
        return view('admin.roles.show', compact('rol'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rol = Role::findOrFail($id);
        return view('admin.roles.edit', compact('rol'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'guard_name' => ['required', 'string']
        ]);

        // $rol->update($data);
        $rol = Role::findOrFail($id);
        $rol->name = $request->name;
        $rol->guard_name = $request->guard_name;
        $rol->update();

        Splade::toast('Rol actualizado!')->autoDismiss(5);

        return redirect()->route('roles');
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
}
