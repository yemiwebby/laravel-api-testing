<?php

namespace Tests\Feature;

use App\CEO;
use App\User;
use Tests\TestCase;

class CEOTest extends TestCase
{
    public function testCEOCreatedSuccessfully()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');

        $ceoData = [
            "name" => "Susan Wojcicki",
            "company_name" => "YouTube",
            "year" => "2014",
            "company_headquarters" => "San Bruno, California",
            "what_company_does" => "Video-sharing platform"
        ];

        $this->json('POST', 'api/ceo', $ceoData, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJson([
                "ceo" => [
                    "name" => "Susan Wojcicki",
                    "company_name" => "YouTube",
                    "year" => "2014",
                    "company_headquarters" => "San Bruno, California",
                    "what_company_does" => "Video-sharing platform"
                ],
                "message" => "Created successfully"
            ]);
    }

    public function testCEOListedSuccessfully()
    {

        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');

        factory(CEO::class)->create([
            "name" => "Susan Wojcicki",
            "company_name" => "YouTube",
            "year" => "2014",
            "company_headquarters" => "San Bruno, California",
            "what_company_does" => "Video-sharing platform",
        ]);

        factory(CEO::class)->create([
            "name" => "Mark Zuckerberg",
            "company_name" => "FaceBook",
            "year" => "2004",
            "company_headquarters" => "Menlo Park, California",
            "what_company_does" => "The world's largest social network",
        ]);

        $this->json('GET', 'api/ceo', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "ceos" => [
                    [
                        "id" => 1,
                        "name" => "Susan Wojcicki",
                        "company_name" => "YouTube",
                        "year" => "2014",
                        "company_headquarters" => "San Bruno, California",
                        "what_company_does" => "Video-sharing platform"
                    ],
                    [
                        "id" => 2,
                        "name" => "Mark Zuckerberg",
                        "company_name" => "FaceBook",
                        "year" => "2004",
                        "company_headquarters" => "Menlo Park, California",
                        "what_company_does" => "The world's largest social network"
                    ]
                ],
                "message" => "Retrieved successfully"
            ]);
    }


    public function testRetrieveCEOSuccessfully()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');

        $ceo = factory(CEO::class)->create([
            "name" => "Susan Wojcicki",
            "company_name" => "YouTube",
            "year" => "2014",
            "company_headquarters" => "San Bruno, California",
            "what_company_does" => "Video-sharing platform"
        ]);

        $this->json('GET', 'api/ceo/' . $ceo->id, [], ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "ceo" => [
                    "name" => "Susan Wojcicki",
                    "company_name" => "YouTube",
                    "year" => "2014",
                    "company_headquarters" => "San Bruno, California",
                    "what_company_does" => "Video-sharing platform"
                ],
                "message" => "Retrieved successfully"
            ]);
    }

    public function testCEOUpdatedSuccessfully()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');

        $ceo = factory(CEO::class)->create([
            "name" => "Susan Wojcicki",
            "company_name" => "YouTube",
            "year" => "2014",
            "company_headquarters" => "San Bruno, California",
            "what_company_does" => "Video-sharing platform"
        ]);

        $payload = [
            "name" => "Demo User",
            "company_name" => "Sample Company",
            "year" => "2014",
            "company_headquarters" => "San Bruno, California",
            "what_company_does" => "Video-sharing platform"
        ];

        $this->json('PATCH', 'api/ceo/' . $ceo->id , $payload, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "ceo" => [
                    "name" => "Demo User",
                    "company_name" => "Sample Company",
                    "year" => "2014",
                    "company_headquarters" => "San Bruno, California",
                    "what_company_does" => "Video-sharing platform"
                ],
                "message" => "Updated successfully"
            ]);
    }

    public function testDeleteCEO()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');

        $ceo = factory(CEO::class)->create([
            "name" => "Susan Wojcicki",
            "company_name" => "YouTube",
            "year" => "2014",
            "company_headquarters" => "San Bruno, California",
            "what_company_does" => "Video-sharing platform"
        ]);

        $this->json('DELETE', 'api/ceo/' . $ceo->id, [], ['Accept' => 'application/json'])
            ->assertStatus(204);
    }

}
