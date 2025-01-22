<?php
namespace src\traits;
trait Serialisation{

     /**
     * Coverts array to string full of placeholder corresponding to array's length. 
     * @param array $array
     * @param string $placeholder 
     * @return string full of placeholders.
     */
    public function toStringPlaceHolder(array $array,string $placeholder): string{
        return implode(',', array_fill(0, count($array), $placeholder));
    }

     /**
     * Coverts array values to one string.
     * @param array $array
     * @return string 
     */
    public function toKeyNameString($array): string{
        return implode(',',array_keys($array));
    }


     /**
     * Coverts array to string full that consists of keys and placeholder. 
     * @param array $array
     * @param string $placeholder 
     * @return string full of placeholders (key = placeholder).
     */
    private function toArrayPlaceHolder(array $array, string $placeholder): string {
        return implode(',', array_map(
            function ($key) use ($placeholder) {
                return "$key = {$placeholder}";
            },
            array_keys($array),
            $array
        ));
    }
}