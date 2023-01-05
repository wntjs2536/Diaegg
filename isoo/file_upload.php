<?php
function uploadFile($files, $el_name, $el, $_P_DIR_FILE, $filename_org = "")
{

    global $_SERVER;

    if (!$_P_DIR_FILE) {
        $_P_DIR_FILE = $_SERVER['DOCUMENT_ROOT'] . "/isoo/_UPLOAD/";
    }

    if ($files[$el_name]['size'] > 0) {
        ########## 등록한 파일이 업로드가 허용되지 않는 확장자를 갖는 파일인지를 검사한다. ##########

        $file_name = strtolower($files[$el_name]['name']);

        $full_filename = explode(".", "$file_name");
        $extension = $full_filename[sizeof($full_filename) - 1];


        $file_name = time() . "-" . $file_name;


        if (!strcmp($extension, "html") || !strcmp($extension, "htm") ||
            !strcmp($extension, "php") || !strcmp($extension, "php3") ||
            !strcmp($extension, "php4") || !strcmp($extension, "inc")) {
            die("HTML 파일은 보안상 업로드하실 수 없습니다. 압축해서 올려주세요.");
            exit;
        }
        ########## 지정디렉토리가 없을경우 생성  ##########
        if (!is_dir($_P_DIR_FILE)) {
            $base_name = $_P_DIR_FILE;
            if (!is_dir($base_name)) mkdir($base_name);
        }

        ########## 등록하려는 파일을 현재 자료실의 지정디렉토리에 저장 ##########
        if (!copy($files[$el_name]['tmp_name'], $_P_DIR_FILE . $file_name)) {
            die("UPLOAD_COPY_FAILURE");
        }
        ########## 작업이 끝난후 임시디렉토리에 저장된 파일을 삭제한다. ##########
        if (!unlink($files[$el_name]['tmp_name'])) {
            die("UPLOAD_DELETE_FAILURE");
        }
        ########## 신규파일 업로드시 기존 파일은 삭제... ##########
        if ($file_name && $filename_org) {
            unlink($_P_DIR_FILE . $filename_org);
        }
        return $file_name;
    }
    return "";
}

$file_name = uploadFile($_FILES, "photo", $_SERVER['DOCUMENT_ROOT'] . "/isoo/_UPLOAD");

echo "SUCCESS@@@/isoo/_UPLOAD/" . $file_name;