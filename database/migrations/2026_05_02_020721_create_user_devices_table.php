<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_devices', function (Blueprint $table) {
            $table->id();
            $table->string('device_token')->unique();
            $table->string('device_type');
            $table->enum('device_os', ['android', 'ios']);

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->double('height')->nullable();
            $table->double('weight')->nullable();
            $table->string('birth_date')->nullable();
            $table->enum('gender', ['Hombre', 'Mujer', 'Other'])->nullable();
            $table->double('grasa_corporal')->nullable();
            $table->double('masa_muscular')->nullable();
            $table->boolean('is_active')->default(false);

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('workspaces', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamps();

        });

        Schema::create('workspace_members', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(false);
            $table->string('member_role');

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('workspace_id')
                ->constrained()
                ->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('plantilla_formularios', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('version');
            $table->jsonb('content_data');
            $table->timestamps();
        });

        Schema::create('clinical_histories', function (Blueprint $table) {
            $table->id();
            $table->jsonb('content_data');

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('workspace_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('plantilla_formulario_id')
                ->constrained()
                ->onDelete('cascade');
            $table->timestamps();
        });


        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });

        Schema::create('user_roles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('role_id')
                ->constrained()
                ->onDelete('cascade');
            $table->timestamps();
        });


    }

    public function down(): void
    {
        Schema::dropIfExists('user_roles');
        Schema::dropIfExists('clinical_histories');
        Schema::dropIfExists('workspace_members');

        Schema::dropIfExists('profiles');
        Schema::dropIfExists('user_devices');
        Schema::dropIfExists('workspaces');

        Schema::dropIfExists('roles');
        Schema::dropIfExists('plantilla_formularios');
    }
};
