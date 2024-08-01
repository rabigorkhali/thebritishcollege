<?php

namespace App\Constants;

class HttpStatusCodes
{
    // Success Codes
    const OK = 200;
    const CREATED = 201;
    
    // Client Errors
    const BAD_REQUEST = 400;
    const UNAUTHORIZED = 401;
    const NOT_FOUND = 404;
    
    // Server Errors
    const INTERNAL_SERVER_ERROR = 500;
}
