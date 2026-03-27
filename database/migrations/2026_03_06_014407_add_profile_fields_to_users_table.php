<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar_path')->nullable()->after('role');

            $table->string('phone', 30)->nullable()->after('email');

            $table->enum('type', ['etudiant', 'prof', 'scolarite'])->nullable()->after('phone');

            // Student
            $table->string('filiere', 120)->nullable()->after('type');
            $table->string('annee', 20)->nullable()->after('filiere');

            // Prof
            $table->string('departement', 120)->nullable()->after('annee');

            // IDs
            $table->string('cin', 30)->nullable()->after('departement');
            $table->string('cne', 30)->nullable()->after('cin');

            // Birth date
            $table->date('date_naissance')->nullable()->after('cne');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'avatar_path',
                'phone',
                'type',
                'filiere',
                'annee',
                'departement',
                'cin',
                'cne',
                'date_naissance',
            ]);
        });
    }
};