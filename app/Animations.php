<?php

namespace App;

use Faker\Provider\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Animations extends Model
{
    private $winArray = array();
    private $failArray = array();

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        /*
        $winDIR = 'GIFs/WIN';
        $failDIR = 'GIFs/FAIL';

        $files = File::allFiles(public_path());

        $winGIFs = Storage::files($winDIR);
        $failGIFs = Storage::files($failDIR);

        /*
        if(is_dir($winDIR) && is_dir($failDIR)){
            if ($dh = opendir($winDIR))
            {
                while (($file = readdir($dh)) !== false)
                {
                    error_log($winDIR . $file);
                    $winArray[] = $winDIR . $file;
                }
                closedir($dh);
            }

            if ($dh = opendir($failDIR))
            {
                while (($file = readdir($dh)) !== false)
                {
                    error_log($failDIR . $file);
                    $failArray[] = $failDIR . $file;
                }
                closedir($dh);
            }
        }

        /*
        //fill the win array
        foreach(glob('images/GIFs/WIN/*.gif') as $filepath){
            $winArray[] = $filepath;
        }
        //fill the fail array
        foreach(glob('images/GIFs/FAIL/*.gif') as $filepath){
            $failArray[] = $filepath;
        }
        */
    }

    /*
    public function getArray($valid){

        if($valid == true){
            $pos = random_int(0, sizeof($this->winArray) - 1);
            return $this->winArray[$pos];
        }
        else{
            $pos = random_int(0, sizeof($this->failArray) - 1);
            return $this->failArray[$pos];
        }
    }
    */
}
