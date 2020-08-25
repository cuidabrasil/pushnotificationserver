<?php

namespace App\Http\Controllers;

use App\DataTables\ProfilesDataTable;
use App\DataTables\UsersDataTable;
use Illuminate\Http\Request;
use App\Http\Requests\CreateProfilesRequest;
use App\Http\Requests\UpdateProfilesRequest;
use App\Repositories\ProfilesRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Exports\ProfilesExport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Image;

class ProfilesController extends AppBaseController
{
    /** @var  ProfilesRepository */
    private $profilesRepository;

    public function __construct(ProfilesRepository $profilesRepo)
    {
        $this->profilesRepository = $profilesRepo;
    }

    /**
     * Display a listing of the Profiles.
     *
     * @param ProfilesDataTable $profilesDataTable
     * @return Response
     */
    public function index(ProfilesDataTable $profilesDataTable, UsersDataTable $usersDataTable, Request $request )
    {
        if ( \Auth::user()->type == 'editor') return redirect(route('dashboard'));

        $input = $request->all();

        if ( isset($input['type']) ) {
            if ( $input['type'] == 'usuario' ) {
                return $profilesDataTable->render('profiles.index');
            } else {
                return $usersDataTable->render('profiles.index');
            }
        } else {
            return $profilesDataTable->render('profiles.index');
        }

    }

    /**
     * Show the form for creating a new Profiles.
     *
     * @return Response
     */
    public function create()
    {
        if ( \Auth::user()->type == 'editor') return redirect(route('dashboard'));
        return view('profiles.create');
    }

    /**
     * Store a newly created Profiles in storage.
     *
     * @param CreateProfilesRequest $request
     *
     * @return Response
     */
    public function store(CreateProfilesRequest $request)
    {
        if ( \Auth::user()->type == 'editor') return redirect(route('dashboard'));
        $input = $request->all();

        $profiles = $this->profilesRepository->create($input);

        Flash::success('Profiles saved successfully.');

        return redirect(route('profiles.index'));
    }

    /**
     * Display the specified Profiles.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if ( \Auth::user()->type == 'editor') return redirect(route('dashboard'));
        $profiles = $this->profilesRepository->findWithoutFail($id);

        if (empty($profiles)) {
            Flash::error('Profiles not found');

            return redirect(route('profiles.index'));
        }

        $favorites = \App\Models\Profilefavorites::where('profile_id','=',$id)->orderBy('created_at','desc')->get();
        $messages = \App\Models\Profilemessages::where('profile_id','=',$id)->orderBy('created_at','desc')->get();
        $pushs = \App\Models\Profilepushs::where('profile_id','=',$id)->orderBy('created_at','desc')->get();
        $settings = \App\Models\Profilesettings::where('profile_id','=',$id)->get();
        $readContents = \App\Models\UserContentReaders::where('user_id','=', $profiles->user_id)->orderBy('created_at','desc')->get();
        $interests = \App\Models\UserInterests::where('user_id','=', $profiles->user_id)
                                                ->join('tags', 'tags.id', 'user_interests.tag_id')
                                                ->where('tags.status', 1)->get();

        return view('profiles.show')
            ->with('interests', $interests)
            ->with('profiles', $profiles)
            ->with('favorites', $favorites)
            ->with('messages', $messages)
            ->with('pushs', $pushs)
            ->with('settings', $settings)
            ->with('readContents', $readContents);
    }

    /**
     * Show the form for editing the specified Profiles.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if ( \Auth::user()->type == 'editor') return redirect(route('dashboard'));
        $profiles = $this->profilesRepository->findWithoutFail($id);

        if (empty($profiles)) {
            Flash::error('Usuário não encontrado');
            return redirect(route('profiles.index'));
        }

        $favorites = \App\Models\Profilefavorites::where('profile_id','=',$id)->orderBy('created_at','desc')->get();
        $messages = \App\Models\Profilemessages::where('profile_id','=',$id)->orderBy('created_at','desc')->get();
        $pushs = \App\Models\Profilepushs::where('profile_id','=',$id)->orderBy('created_at','desc')->get();
        $settings = \App\Models\Profilesettings::where('profile_id','=',$id)->get();
        $readContents = \App\Models\UserContentReaders::where('user_id','=', $profiles->user_id)->orderBy('created_at','desc')->get();
        $interests = \App\Models\UserInterests::where('user_id','=', $profiles->user_id)
                                                ->join('tags', 'tags.id', 'user_interests.tag_id')
                                                ->where('tags.status', 1)->get();

        return view('profiles.edit')
            ->with('interests', $interests)
            ->with('profiles', $profiles)
            ->with('favorites', $favorites)
            ->with('messages', $messages)
            ->with('pushs', $pushs)
            ->with('settings', $settings)
            ->with('readContents', $readContents);
    }

    /**
     * Update the specified Profiles in storage.
     *
     * @param  int              $id
     * @param UpdateProfilesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProfilesRequest $request)
    {
        if ( \Auth::user()->type == 'editor') return redirect(route('dashboard'));
        $profiles = $this->profilesRepository->findWithoutFail($id);

        $input = $request->all();

        if (empty($profiles)) {
            Flash::error('Usuário não encontrado');
            return redirect(route('profiles.index'));
        }

        $user = \App\Models\User::find($request->user_id);
        $user->name = $request->name;
        $user->update();

        $fileName = null;
        if ($request->hasFile('avatar')) {
            $image      = $request->file('avatar');
            $fileName   = \Uuid::generate()->string . '.' . $image->getClientOriginalExtension();

            $img = Image::make($image->getRealPath());
            $img->resize(360, 360, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->stream(); // <-- Key point
            Storage::disk('local')->put('avatars/'.$fileName, $img);
        }

        $fileName = is_null($fileName) ? $profiles->avatar : $fileName;
        $input['avatar'] = isset($input['remover']) ? null : $fileName;
        $input['avatar_url'] = isset($input['remover']) ? null : $profiles->avatar_url;

        if (strpos($input['data_nascimento'], '/') !== false) {
            $vetorData = explode("/",$input['data_nascimento']);
            $input['data_nascimento'] = $vetorData[2] . "-" . $vetorData[1] . "-" . $vetorData[0];
        }

        $profiles = $this->profilesRepository->update($input, $id);

        Flash::success('Usuário atualizado com sucesso.');

        return redirect(route('profiles.index'));
    }

    /**
     * Remove the specified Profiles from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if ( \Auth::user()->type == 'editor') return redirect(route('dashboard'));
        $profiles = $this->profilesRepository->findWithoutFail($id);

        if (empty($profiles)) {
            Flash::error('Profiles not found');

            return redirect(route('profiles.index'));
        }

        $this->profilesRepository->delete($id);

        Flash::success('Usuário removido com sucesso.');

        return redirect(route('profiles.index'));
    }

    /**
     * Show the form for editing the specified Profiles.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function export()
    {
        if ( \Auth::user()->type == 'editor') return redirect(route('dashboard'));
        
        return Excel::download(new ProfilesExport, 'profiles_'.date('Y-m-d_H-i').'.xlsx');
    }
}
