<?php

namespace App\Controllers;

use Slim\Http\Request;


class PublicController extends Controller {

    /**
     * 图片上传
     *
     * @param Request $req
     * @return \Slim\Http\Response
     */
    public function upload(Request $req) {
        $files =  $req->getUploadedFiles();
       $targetPath = "";
        foreach($files as $file) {
            $ext = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
            $targetPath = "upload/" . date("YmdHis") . rand(1000,9999) . '.' . $ext;
            $file->moveTo($targetPath);
        }
        return $this->jsonTip(1, "OK", [
            "file" => $targetPath,
            "view" => iAsset($targetPath),
        ]);
    }

}