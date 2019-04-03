<?php

namespace Jeeb;

use Jeeb\APIError\CredentialsMissing;
use Jeeb\APIError\BadEnvironment;
use Jeeb\APIError\BadRequest;
use Jeeb\APIError\BadCredentials;
use Jeeb\APIError\BadAuthToken;
use Jeeb\APIError\AccountBlocked;
use Jeeb\APIError\IpAddressIsNotAllowed;
use Jeeb\APIError\Unauthorized;
use Jeeb\APIError\PageNotFound;
use Jeeb\APIError\RecordNotFound;
use Jeeb\APIError\OrderNotFound;
use Jeeb\APIError\NotFound;
use Jeeb\APIError\OrderIsNotValid;
use Jeeb\APIError\UnprocessableEntity;
use Jeeb\APIError\RateLimitException;
use Jeeb\APIError\InternalServerError;
use Jeeb\APIError\APIError;

class Exception
{
    public static function formatError($error)
    {
        if (is_array($error)) {
            $reason = '';
            $message = '';

            if (isset($error['reason'])) {
                $reason = $error['reason'];
            }

            if (isset($error['message'])) {
                $message = $error['message'];
            }

            return "{$reason} {$message}";
        } else {
            return $error;
        }
    }

    public static function throwException($http_status, $error)
    {
        $reason = is_array($error) && isset($error['reason']) ? $error['reason'] : '';

        switch ($http_status) {
            case 400:
                switch ($reason) {
                    case 'CredentialsMissing':
                        throw new CredentialsMissing(self::formatError($error));
                    case 'BadEnvironment':
                        throw new BadEnvironment(self::formatError($error));
                    default:
                        throw new BadRequest(self::formatError($error));
                }
            //no break
            case 401:
                switch ($reason) {
                    case 'BadCredentials':
                        throw new BadCredentials(self::formatError($error));
                    case 'BadAuthToken':
                        throw new BadAuthToken(self::formatError($error));
                    case 'AccountBlocked':
                        throw new AccountBlocked(self::formatError($error));
                    case 'IpAddressIsNotAllowed':
                        throw new IpAddressIsNotAllowed(self::formatError($error));
                    default:
                        throw new Unauthorized(self::formatError($error));
                }
            //no break
            case 404:
                switch ($reason) {
                    case 'PageNotFound':
                        throw new PageNotFound(self::formatError($error));
                    case 'RecordNotFound':
                        throw new RecordNotFound(self::formatError($error));
                    case 'OrderNotFound':
                        throw new OrderNotFound(self::formatError($error));
                    default:
                        throw new NotFound(self::formatError($error));
                }
            //no break
            case 422:
                switch ($reason) {
                    case 'OrderIsNotValid':
                        throw new OrderIsNotValid(self::formatError($error));
                    default:
                        throw new UnprocessableEntity(self::formatError($error));
                }
            //no break
            case 429:
                throw new RateLimitException(self::formatError($error));
            case 500:
                throw new InternalServerError(self::formatError($error));
            case 504:
                throw new InternalServerError(self::formatError($error));
            default:
                throw new APIError(self::formatError($error));
        }
    }
}

