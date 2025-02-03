<?php
namespace src\traits;

trait Serialisation{

    /**
     * Converts array to string full of placeholders corresponding to array's length.
     *
     * @param array<string, string> $array
     * @param string $placeholder 
     * @return string full of placeholders.
     */
    public function toStringPlaceHolder(array $array, string $placeholder): string{
        return implode(',', array_fill(0, count($array), $placeholder));
    }

    /**
     * Coverts array values to one string.
     * @param array<string, mixed> $array
     * @return string 
     */
    public function toKeyNameString(array $array): string{
        return implode(',',array_keys($array));
    }


    /**
     * Coverts array to string full that consists of keys and placeholder. 
     * @param array <string, string> $array
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