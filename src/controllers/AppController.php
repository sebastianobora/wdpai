<?php

class AppController {

    const MAX_FILE_SIZE = 1024*1024;
    const SUPPORTED_TYPES = ['image/png', "image/jpeg"];
    const UPLOAD_DIRECTORY = '/../public/uploads/';

    private $request;

    public function __construct()
    {
        $this->request = $_SERVER['REQUEST_METHOD'];
    }

    protected function isPost(): bool{
        return $this->request === 'POST';
    }

    protected function isGet(): bool{
        return $this->request === 'GET';
    }

    protected function render(string $template = null, array $variables = []){
        $templatePath = 'public/views/'.$template.'.php';
        $output = 'File not found';

        if(file_exists($templatePath)) {
            extract($variables);

            ob_start();
            include $templatePath;
            $output = ob_get_clean();
        }
        print($output);
    }

    protected function prepareFile($file){
        $fileExtension = explode(".", $file['name']);
        $fileExtension = ".".$fileExtension[sizeof($fileExtension) - 1];

        $name = uniqid("img-");
        move_uploaded_file(
            $file['tmp_name'],
            dirname(__DIR__).self::UPLOAD_DIRECTORY.$name.$fileExtension
        );
        return $name.$fileExtension;
    }

    protected function validateFile(array $file): bool{
        if($file['size'] > self::MAX_FILE_SIZE){
            return false;
        }
        if(!isset($file['type']) && !in_array($file['type'], self::SUPPORTED_TYPES)){
            return false;
        }
        return true;
    }

    protected function accessToEdit($editedUserId, $currentUser){
        if($editedUserId != $currentUser->getUserId()){
            $url = "http://$_SERVER[HTTP_HOST]";
            header("location: {$url}/index");
        }
    }
}

?>