<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * @covers SanctumTokenController
 */
class SanctumTokenControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function email_is_required_for_issuing_tokens()
    {
        //Execució
        $response = $this->postJson('/api/sanctum/token', [
            'password' => '12345678',
            'device_name' => "PakistaniDanny's device",
        ]);

        $response->assertStatus(422);
        $jsonResponse = json_decode($response->getContent());
        $this->assertEquals("The given data was invalid.", $jsonResponse->message);
        $this->assertEquals("The email field is required.", $jsonResponse->errors->email[0]);
    }
    /**
     * @test
     */
    public function email_is_valid_for_issuing_tokens()
    {
        //Execució
        $response = $this->postJson('/api/sanctum/token', [
            'email' => 'shitdata',
            'password' => '12345678',
            'device_name' => "PakistaniDanny's device",
        ]);

        $response->assertStatus(422);
        $jsonResponse = json_decode($response->getContent());
        $this->assertEquals("The given data was invalid.", $jsonResponse->message);
        $this->assertEquals("The provided credentials are incorrect.", $jsonResponse->errors->email[0]);
    }

    /**
     * @test
     */
    public function invalid_email_gives_incorrect_credentials_error()
    {
        //Preparació
        $user = User::create([
            'name' => 'PakistaniDanny',
            'email' => 'pakistanidanny@casteaching.com',
            'password' => 'contrasenyaanticopiadeltreball'
        ]);

        //Execució
        $response = $this->postJson('/api/sanctum/token', [
            'email' => 'shitdata',
            'password' => $user->password,
            'device_name' => $user->name . "'s device",
        ]);

        //Comprovació
        $response->assertStatus(422);
        $jsonResponse = json_decode($response->getContent());
        $this->assertEquals("The given data was invalid.", $jsonResponse->message);
        $this->assertEquals("The provided credentials are incorrect.", $jsonResponse->errors->email[0]);
    }

    /**
     * @test
     */
    public function password_is_required_for_issuing_tokens()
    {
        //Execució
        $response = $this->postJson('/api/sanctum/token', [
            'email' => 'pakistanidanny@casteaching.com',
            'device_name' => "PakistaniDanny's device",
        ]);

        $response->assertStatus(422);
        $jsonResponse = json_decode($response->getContent());
        $this->assertEquals("The given data was invalid.", $jsonResponse->message);
        $this->assertEquals("The password field is required.", $jsonResponse->errors->password[0]);
    }

    /**
     * @test
     */
    public function invalid_password_gives_incorrect_credentials_error()
    {
        //Preparació
        $user = User::create([
            'name' => 'PakistaniDanny',
            'email' => 'pakistanidanny@casteaching.com',
            'password' => Hash::make('contrasenyaanticopiadeltreball')
        ]);

        //Execució
        $response = $this->postJson('/api/sanctum/token', [
            'email' => $user->email,
            'password' => 'shitdata',
            'device_name' => $user->name . "'s device",
        ]);

        //Comprovació
        $response->assertStatus(422);
        $jsonResponse = json_decode($response->getContent());
        $this->assertEquals("The given data was invalid.", $jsonResponse->message);
        $this->assertEquals("The provided credentials are incorrect.", $jsonResponse->errors->email[0]);
    }

    /**
     * @test
     */
    public function device_name_is_required_for_issuing_tokens()
    {
        //Execució
        $response = $this->postJson('/api/sanctum/token', [
            'email' => 'pakistanidanny@casteaching.com',
            'password' => "contrasenyaanticopiadeltreball",
        ]);

        $response->assertStatus(422);
        $jsonResponse = json_decode($response->getContent());
        $this->assertEquals("The given data was invalid.", $jsonResponse->message);
        $this->assertEquals("The device name field is required.", $jsonResponse->errors->device_name[0]);
    }

    /**
     * @test
     */
    public function user_with_valid_credentials_can_issue_a_token()
    {
        //Preparació
        $user = User::create([
            'name' => 'PakistaniDanny',
            'email' => 'pakistanidanny@casteaching.com',
            'password' => Hash::make('contrasenyaanticopiadeltreball')
        ]);

        $this->assertCount(0, $user->tokens);

        //Execució
        $response = $this->postJson('/api/sanctum/token', [
            'email' => $user->email,
            'password' => 'contrasenyaanticopiadeltreball',
            'device_name' => $user->name . "'s device",
        ]);

        //Comprovació
        $response->assertStatus(200);
        $this->assertNotNull($response->getContent());
        $this->assertCount(1, $user->fresh()->tokens);
    }
}
