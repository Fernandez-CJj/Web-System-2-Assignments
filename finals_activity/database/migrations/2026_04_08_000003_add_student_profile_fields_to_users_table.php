<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::table('users', function (Blueprint $table) {
      $table->string('student_number')->unique()->after('id');
      $table->string('first_name')->after('student_number');
      $table->string('last_name')->after('first_name');
      $table->string('middle_name')->nullable()->after('last_name');
      $table->date('birth_date')->after('middle_name');
      $table->string('gender', 20)->after('birth_date');
      $table->string('phone', 30)->after('gender');
      $table->string('program')->after('phone');
      $table->string('year_level', 20)->after('program');
      $table->string('address')->after('year_level');
      $table->string('city')->after('address');
      $table->string('province')->after('city');
      $table->string('guardian_name')->after('province');
      $table->string('guardian_phone', 30)->after('guardian_name');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('users', function (Blueprint $table) {
      $table->dropUnique(['student_number']);
      $table->dropColumn([
        'student_number',
        'first_name',
        'last_name',
        'middle_name',
        'birth_date',
        'gender',
        'phone',
        'program',
        'year_level',
        'address',
        'city',
        'province',
        'guardian_name',
        'guardian_phone',
      ]);
    });
  }
};
