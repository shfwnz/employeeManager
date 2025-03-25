<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
    // response status
    public $status;

    // response message
    public $message;

    // response data
    public $resource;

    // constructor method
    public function __construct($status, $message, $resource)
    {
        // call parent constructor
        parent::__construct($resource);

        // set response attributes
        $this->status = $status;
        $this->message = $message;
    }

    // format response
    public function toArray(Request $request): array
    {
        return [
            'success' => $this->status,
            'message' => $this->message,
            'data' => $this->resource
        ];
    }
}
