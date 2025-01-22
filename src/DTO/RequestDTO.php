<?php
namespace src\DTO;

final class RequestDTO{

    static public function transform(object $request, array $additionalData = []): array{
        $request = $request->rawContent();
        
        if ($request) $request = json_decode($request, TRUE);
        else $request = [];

        return array_merge($request,$additionalData);
    }

}


?>