<?php

namespace src\interfaces;

use src\requests\ApiRequest;

interface ControllerInterface{
    public function get(ApiRequest $request): void;
    public function create(ApiRequest $request): void;
    public function patch(ApiRequest $request): void;
    public function delete(ApiRequest $request): void;
    public function paginate(ApiRequest $request): void;
}