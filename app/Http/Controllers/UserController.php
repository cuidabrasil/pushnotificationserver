<?php

namespace App\Http\Controllers;

use App\DataTables\UserDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Illuminate\Http\Request;

class UserController extends AppBaseController
{
    public function __construct()
    {
    }

    /**
     * Display a listing of the User.
     *
     * @param UserDataTable $userDataTable
     * @return Response
     */
    public function index(UserDataTable $userDataTable)
    {
        if ( \Auth::user()->type == 'editor') return redirect(route('dashboard'));
        return $userDataTable->render('users.index');
    }

    /**
     * Show the form for creating a new User.
     *
     * @return Response
     */
    public function create()
    {
        if ( \Auth::user()->type == 'editor') return redirect(route('dashboard'));
        return view('users.create');
    }

    /**
     * Store a newly created User in storage.
     *
     * @param CreateUserRequest $request
     *
     * @return Response
     */
    public function store(CreateUserRequest $request)
    {
        if ( \Auth::user()->type == 'editor') return redirect(route('dashboard'));
        $input = $request->all();

        $input['password'] = bcrypt($request->password);

        //$user = $this->userRepository->create($input);

        Flash::success('Usuário gravado com sucesso.');

        return redirect(route('users.index'));
    }

    /**
     * Display the specified User.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if ( \Auth::user()->type == 'editor') return redirect(route('dashboard'));

        $user = \App\Models\User::where('id', $id)->first();

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        return view('users.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified User.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if ( \Auth::user()->type == 'editor') return redirect(route('dashboard'));
        $user = \App\Models\User::where('id', $id)->first();

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        return view('users.edit')->with('user', $user);
    }

    /**
     * Update the specified User in storage.
     *
     * @param  int              $id
     * @param UpdateUserRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserRequest $request)
    {
        if ( \Auth::user()->type == 'editor') return redirect(route('dashboard'));
        //$user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        $input['password'] = bcrypt($user->password);

        $user = $this->userRepository->update($request->all(), $id);

        Flash::success('User updated successfully.');

        return redirect(route('users.index'));
    }

    /**
     * Remove the specified User from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if ( \Auth::user()->type == 'editor') return redirect(route('dashboard'));
        //$user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        $this->userRepository->delete($id);

        Flash::success('User deleted successfully.');

        return redirect(route('users.index'));
    }

    public function trocarsenha($id){
        $user = \App\User::where('id', $id);
        return view('users.trocarsenha')->with(['id' => $id, 'user' => $user, 'tipo' => 'admin']);
    }

    public function trocarsenha_gravar($id, Request $request){
        \App\User::where('id', $id)->update([
            'password' => bcrypt($request->password)
        ]);
        Flash::success('Senha alterada com sucesso.');
        return redirect(route('users.index'));
    }

    public function trocarpropriasenha(){
        $id = \Auth::user()->id;
        $user = \App\User::where('id', $id);
        return view('users.trocarsenha')->with(['id' => $id, 'user' => $user, 'tipo' => 'user']);
    }
}
