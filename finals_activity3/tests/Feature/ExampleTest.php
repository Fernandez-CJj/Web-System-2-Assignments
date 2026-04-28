<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_home_redirects_to_student_directory(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('students.index'));
    }

    public function test_student_directory_loads_successfully(): void
    {
        $response = $this->get(route('students.index'));

        $response->assertOk();
    }
}
