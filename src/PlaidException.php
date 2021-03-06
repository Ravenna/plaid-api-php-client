<?php

namespace Plaid;

use Throwable;

class PlaidException extends \Exception
{
    /**
     * @var type
     */
    protected $type;

    /**
     * @var displayMessage
     */
    protected $displayMessage;


    public function __construct($message, $type, $code, $displayMessage, $requestId)
    {
        parent::__construct($message);
        $this->type = $type;
        $this->code = $code;
        $this->displayMessage = $displayMessage;
        $this->requestId = $requestId;
    }

    public static function fromResponse($response)
    {
        $e = new \Exception();

        switch ($response['error_type']) {
            case 'INVALID_REQUEST':
                $e = new InvalidRequestError(
                    $response['error_message'],
                    $response['error_type'],
                    $response['error_code'],
                    $response['display_message'],
                    $response['request_id']
                );
                break;

            case 'INVALID_INPUT':
                $e = new InvalidInputError(
                    $response['error_message'],
                    $response['error_type'],
                    $response['error_code'],
                    $response['display_message'],
                    $response['request_id']
                );
                break;

            case 'RATE_LIMIT_EXCEEDED':
                $e = new RateLimitExceededError(
                    $response['error_message'],
                    $response['error_type'],
                    $response['error_code'],
                    $response['display_message'],
                    $response['request_id']
                );
                break;

            case 'API_ERROR':
                $e = new APIError(
                    $response['error_message'],
                    $response['error_type'],
                    $response['error_code'],
                    $response['display_message'],
                    $response['request_id']
                );
                break;

            case 'ITEM_ERROR':
                $e = new ItemError(
                    $response['error_message'],
                    $response['error_type'],
                    $response['error_code'],
                    $response['display_message'],
                    $response['request_id']
                );
                break;
            case 'INSTITUTION_ERROR':
                $e = new ItemError(
                    $response['error_message'],
                    $response['error_type'],
                    $response['error_code'],
                    $response['display_message'],
                    $response['request_id']
                );
                break;
        }

        return $e;
    }

    public function getType() {
        return $this->type;
    }

    public function getDisplayMessage() {
        return $this->displayMessage;
    }

}

class InvalidRequestError extends PlaidException {}

class InvalidInputError extends PlaidException {}

class RateLimitExceededError extends PlaidException {}

class APIError extends PlaidException {}

class ItemError extends PlaidException {}
