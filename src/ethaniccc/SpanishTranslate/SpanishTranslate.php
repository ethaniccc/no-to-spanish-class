<?php

namespace src\ethaniccc\SpanishTranslate;

require 'C:\Users\schoo\OneDrive\Desktop\php\SpanishTranslate\vendor\autoload.php';

use \Statickidz\GoogleTranslate;

if(!isset($argv[1])){
    throw new \Exception('No given story link to translate');
    return;
}

$websiteContent = file_get_contents($argv[1]);
$translator = new SpanishTranslate($websiteContent);
$translator->translateStory();

class SpanishTranslate{

    private $websiteContent;

    public function __construct(string $websiteContent){
        $this->websiteContent = $websiteContent;
    }

    public function translateStory() : void{
        $storyBeggining = StringUtils::after('<p>', $this->websiteContent);
        $storyEnd = StringUtils::before_last('<!-- Chapter Ends -->', $storyBeggining);
        $storyBase = $storyEnd;
        $story = str_replace(['<p>', '</p>', '<i>', '</i>'], ['', '', '', ''], $storyBase);
        print_r("\n");
        $translatorClient = new GoogleTranslate();
        $translatedStory = $translatorClient::translate('es', 'en', $story);
        print_r("Finalizing and confirming translations....\n");
        sleep(3);
        print_r("Translation complete!\nTranslated Story:\n");
        print_r($translatedStory);
    }

}

class StringUtils{

    public static function after($characters, $inthat){
        if (!is_bool(strpos($inthat, $characters)))
        return substr($inthat, strpos($inthat,$characters)+strlen($characters));
    }

    public static function before($characters, $inthat){
        return substr($inthat, 0, strpos($inthat, $characters));
    }

    public static function before_last($characters, $inthat){
        return substr($inthat, 0, strripos($inthat, $characters));
    }

}