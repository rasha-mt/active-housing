<?php

namespace Http\Controllers\v1;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use App\Http\Controllers\v1\UserController;
use Tests\TestCase;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class UserControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_can_get_single_user_by_id()
    {
        $user = [
            "data" => (object) [
                "id"         => 2,
                "email"      => "janet.weaver@reqres.in",
                "first_name" => "Janet",
                "last_name"  => "Weaver",
                "avatar"     => " https://reqres.in/img/faces/2-image.jpg"
            ]
        ];

        HTTP::fake([
                'https://reqres.in/api/users/2' => Http::response($user, 200),
            ]
        );

        $this->getJson('api/v1/users/2')
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    "id"         => 2,
                    "email"      => "janet.weaver@reqres.in",
                    "first_name" => "Janet",
                    "last_name"  => "Weaver"
                ]
            ]);
    }

    public function test_get_not_exist_single_user()
    {
        $user = [];

        HTTP::fake([
                'https://reqres.in/api/users/2' => Http::response($user, 404),
            ]
        );

        $this->getJson('api/v1/users/2')
            ->assertSuccessful()
            ->assertJson([
                'data' => []
            ]);
    }

    public function test_can_get_list_of_users()
    {
        $users = [
            "page"        => 1,
            "per_page"    => 6,
            "total"       => 12,
            "total_pages" => 2,
            "data"        => [
                [
                    "id"         => 7,
                    "email"      => "michael.lawson@reqres.in",
                    "first_name" => "Michael",
                    "last_name"  => "Lawson",
                    "avatar"     => "https=>//reqres.in/img/faces/7-image.jpg"
                ],
                [
                    "id"         => 8,
                    "email"      => "lindsay.ferguson@reqres.in",
                    "first_name" => "Lindsay",
                    "last_name"  => "Ferguson",
                    "avatar"     => "https://reqres.in/img/faces/8-image.jpg"
                ],
            ]
        ];

        HTTP::fake([
                'https://reqres.in/api/users?page=1' => Http::response($users, 200),
            ]
        );

        $this->getJson('api/v1/users?page=1')
            ->assertSuccessful()
            ->assertJsonStructure([
                'page',
                'per_page',
                'data' => [
                    [
                        "id",
                        "email",
                        "first_name",
                        "last_name"
                    ]
                ]
            ]);
    }
}
