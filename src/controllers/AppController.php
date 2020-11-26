<?php

class AppController {

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

            ob_start(); # otwiera zapis bufora
            include $templatePath; # wczytujemy ścieżkę do pliku html do bufora
            $output = ob_get_clean(); # do zmiennej output przypisujemy to co jest w buforze
        }
        print($output);
    }
}

?>