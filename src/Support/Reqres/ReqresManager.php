<?php

namespace Support\Reqres;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Client\ConnectionException;

class ReqresManager
{

    const BASE_URL = 'https://reqres.in/api';

    public static function getUserById($userId = null)
    {
        try {
            $response = Http::retry(3, 100, function ($exception, $request) {
                return $exception instanceof ConnectionException;
            })->get(self::BASE_URL . "/users/{$userId}");

            $result = json_decode($response?->getBody());

            Cache::put("user.{userId}", $result, now()->addHours(24));

            return $result;
        } catch (Exception $exception) {
            return Cache::get("user.{userId}");
        }
    }

    public static function getUsersList($page = 1)
    {
        try {
            $response = Http::retry(3, 100, function ($exception, $request) {
                return $exception instanceof ConnectionException;
            })->get(self::BASE_URL . "/users?page={$page}");

            $result = json_decode($response?->getBody());

            Cache::put("users", $result, now()->addHours(24));

            return $result;
        } catch (Exception $exception) {
            return Cache::get("users");
        }
    }
}