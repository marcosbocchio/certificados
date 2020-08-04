<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VideoCategory;
use App\Video;
use App\Http\Requests\VideoRequest;
use App\Http\Requests\CategoriaRequest;
use Illuminate\Support\Facades\DB;
use Exception as Exception;

class GestionVideoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role_or_permission:Sistemas|C_edita'],['only' => ['callView']]);
    }

    public function callView()
    {
        $user = auth()->user();
        $header_titulo = "GESTIONAR MULTIMEDIA";
        $header_descripcion =" ";

        return view('videos.crear-contenido', compact('user','header_titulo','header_descripcion'));
    }

    public function getCategorias()
    {
        return VideoCategory::where('parent_id', null)->orderBy('id', 'DESC')->get();
    }

    public function getSubCategorias($id)
    {
        return VideoCategory::where('parent_id', $id)->orderBy('id', 'DESC')->get();
    }

    public function getVideos(Request $array)
    {
        return Video::whereIn('video_categories_id', $array)->get();
    }

    public function storeCategory(CategoriaRequest $request)
    {
        $categoria = VideoCategory::find($request->id);

        if(!$categoria){
            $categoria = new VideoCategory;
        }

        DB::beginTransaction();

        try {

            $categoria->title =  $request->title;
            $categoria->acotado_sn = $request->acotado_sn;
            $categoria->description =  $request->description;
            $categoria->parent_id = $request->parent_id;

            $categoria->save();

            DB::commit();

        } catch (Exception $e) {

            DB::rollback();
            throw $e;

        }

        return $categoria;

    }

    public function nuevoVideo(VideoRequest $request)
    {
        $nuevoVideo = Video::find($request->id);
        if(!$nuevoVideo){
            $nuevoVideo = new Video;
        }

        DB::beginTransaction();
        try {

        /*obtener el Id del video */
        $re = '/(?im)\b(?:https?:\/\/)?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)\/(?:(?:\??v=?i?=?\/?)|watch\?vi?=|watch\?.*?&v=|embed\/|)([A-Z0-9_-]{11})\S*(?=\s|$)/';
        $str = $request->videoId;
        preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);

        $nuevoVideo->videoId = $matches[0][1];
        $nuevoVideo->title = $request->title;
        $nuevoVideo->description = $request->description;
        $nuevoVideo->video_category_id = $request->video_category_id;

        $nuevoVideo->save();

        DB::commit();

        } catch (Exception $e) {

            DB::rollback();
            throw $e;

        }
        return $nuevoVideo;
    }

    public function deleteCategory(Request $request)
    {
        $deleteCategory = VideoCategory::find($request->id);

        $deleteCategory->delete();
    }

    public function deleteVideo(Request $request)
    {
        $deleteVideo = Video::find($request->id);

        $deleteVideo->delete();
    }
}
