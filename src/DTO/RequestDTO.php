<?php
namespace src\DTO;

use src\requests\ApiRequest;

final class RequestDTO{

    /**
     * @param array<string, mixed> $additionalData
     * @return array<string, mixed>
     */
    static public function transform(ApiRequest $request, array $additionalData = []): array{
        $request = $request->rawContent();
        $temp = [];
        
        if ($request)  
        $temp = json_decode($request, TRUE);
    
        return array_merge($temp,$additionalData);
    }

}


?>