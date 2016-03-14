<?php

namespace Inzaana\Http\Controllers;

use Illuminate\Http\Request as MediaRequest;

use Inzaana\Http\Requests;
use Inzaana\Http\Controllers\Controller;

use Auth;
use Storage;

class MediaController extends Controller
{
    //
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function reload($template_id)
    {
        $success = false;
        $message = 'MediaController::reload for loading medias from template (' . $template_id . ') NOT IMPLEMENTED.';
        return $this->responseWithflashError($message, 200);
    }

    public function save(MediaRequest $request)
    {        
        $user_id = "XXX";
        $template_id = "XXX";
        $success = true;

        if(!$request->has('type')) return $this->responseWithflashError('Image type not supported!');
        if(!$request->has('templateId')) return $this->responseWithflashError('Invalid template found!');
        if(!$request->has('image_id')) return $this->responseWithflashError('Invalid image found!');
        if(!$request->has('image_src')) return $this->responseWithflashError('Image src not supported!');
        if(!$request->has('menu_id')) return $this->responseWithflashError('Invalid menu context!');
        if(!$request->has('image')) return $this->responseWithflashError('Image data lost!');

        $user_id = Auth::user()->id;
        $template_id = $request->input('templateId');
        $img_id = $request->input('image_id');
        $img_src = $request->input('image_src');
        $menu_id = $request->input('menu_id');
        $type = $request->input('type');

        $data = $request->input('image');
        $patterns = '/^data:image\/(png|jpg|jpeg);base64,/';
        $replacements = '';
        $binary = preg_replace($patterns, $replacements, $data);
        $binary = str_replace(' ', '+', $binary);

        // $strImagePath = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "webbuilder" . DIRECTORY_SEPARATOR . "archive" . DIRECTORY_SEPARATOR;
        $strImageFileName = $user_id . '_' . $template_id . '_' . $menu_id . '_' . $img_id . '_' . md5($img_id) . '.' . $type;
        // $strFile = $strImagePath . $strImageFileName;

        $hostArchiveDir = "template-medias/";
        
        // $success = file_put_contents($strFile, base64_decode($binary));
        $success = Storage::disk('local')->put('media-archive/' . $user_id . '/' . $strImageFileName, base64_decode($binary));
        if(!$success)
        {
            $message = 'Image (' . $img_src . ') uploaded failure.';
            $this->responseWithflashError($message);
        }

        Storage::move(storage_path('app/media-archive/' . Auth::user()->id . '/' . $strImageFileName),
                        public_path() . 'template-medias' . '/' . $strImageFileName);

        $imageProfile = '{ "image_id" : "' . $img_id
                        . '", "image_type" : "' . $_REQUEST['type']
                        . '", "src": "' . $img_src
                        . '", "menu": "' . $menu_id
                        . '", "user_id": "' . $user_id
                        . '", "template_id": "' . $template_id
                        . '", "src_arch": "' . asset($hostArchiveDir . $strImageFileName)
                        . '" }';
        $message = 'Image (' . $img_src . ') uploaded success.';
        return response()->json(compact('imageProfile', 'success', 'message'))
                         ->header('Content-type', 'application/json; charset=utf-8');
    }

    protected function responseWithflashError($message, $statusCode = 404)
    {
        $success = false;
        flash()->error($message);
        return response()->json(compact('message', 'success'), $statusCode);
    }
}
