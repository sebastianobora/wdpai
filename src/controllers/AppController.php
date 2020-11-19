<?php

class AppController {
    protected function render(string $template = null){
        $templatePath = 'public/views/'.$template.'.html';
        $output = 'File not found';

        if(file_exists($templatePath)) {
            ob_start(); # otwiera zapis bufora
            include $templatePath; # wczytujemy ścieżkę do pliku html do bufora
            $output = ob_get_clean(); # do zmiennej output przypisujemy to co jest w buforze
        }
        print($output);
    }
}

?>