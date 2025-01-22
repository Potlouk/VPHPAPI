<?php
namespace src\DTO;

use src\requests\ApiRequest;

final class RequestDTO{

    static public function transform(ApiRequest $request, array $additionalData = []): array{
        $request = $request->rawContent();
        
        if ($request) $request = json_decode($request, TRUE);
        else $request = [];

        return array_merge($request,$additionalData);
    }

}


?>