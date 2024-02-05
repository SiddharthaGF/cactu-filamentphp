<?php

declare(strict_types=1);

use App\Enums\StatusVigency;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('states', function (Blueprint $table): void {
            $table->char('code', 2)->primary();
            $table->string('name', 100)->unique();
            $table->foreignId('coordinator_id')->nullable()->unique()->constrained('users');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
        });

        Schema::create('cities', function (Blueprint $table): void {
            $table->foreignUlid('state_code', 2)->constrained('states', 'code');
            $table->char('code', 4)->primary();
            $table->string('name', 100);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
            $table->unique(['name', 'code']);
        });

        Schema::create('zones', function (Blueprint $table): void {
            $table->foreignUlid('city_code', 4)->constrained('cities', 'code');
            $table->char('code', 6)->primary();
            $table->string('name', 100);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
            $table->unique(['name', 'code']);
        });

        Schema::create('communities', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 100);
            $table->foreignUlid('zone_code', 6)->constrained('zones', 'code');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->unsignedBigInteger('vigency')->default(StatusVigency::Active);
            $table->timestamps();
            $table->unique(['name', 'zone_code']);
        });

        Schema::create('community_managers', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('community_id')->constrained();
            $table->foreignId('manager_id')->unique()->constrained('users');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
        });

        Schema::create('family_nuclei', function (Blueprint $table): void {
            $table->id();
            $table->char('conventional_phone', 9)->nullable();
            $table->json('risk_factors')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
        });

        Schema::create('tutors', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('family_nucleus_id')->constrained()
                ->cascadeOnDelete();
            $table->string('name');
            $table->char('dni', 10)->unique();
            $table->unsignedTinyInteger('gender');
            $table->date('birthdate');
            $table->unsignedTinyInteger('relationship');
            $table->boolean('is_present')->default(true);
            $table->unsignedTinyInteger('reason_not_present')->nullable();
            $table->string('specific_reason')->nullable();
            $table->date('deathdate')->nullable();
            $table->unsignedTinyInteger('occupation')->nullable();
            $table->string('specific_occupation')->nullable();
            $table->decimal('salary')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
        });

        Schema::create('alliances', function (Blueprint $table): void {
            $table->id();
            $table->string('alliance', 100)->unique();
            $table->string('country')->unique();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
        });

        Schema::create('contacts', function (Blueprint $table): void {
            $table->string('id', 8)->unique();
            $table->foreignId('alliance_id')->constrained();
            $table->string('name', 150);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
        });


        Schema::create('children', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('manager_id')->constrained('users')->cascadeOnDelete();
            $table->char('children_number', 9)->nullable();
            $table->string('case_number', 8)->nullable();
            $table->foreignId('family_nucleus_id')->constrained();
            $table->foreignUlid('contact_id', 8)->nullable()->constrained();
            $table->string('name');
            $table->char('dni')->unique();
            $table->tinyInteger('gender');
            $table->date('birthdate');
            $table->tinyInteger('affiliation_status');
            $table->string('pseudonym', 100);
            $table->tinyInteger('sexual_identity');
            $table->tinyInteger('literacy')
                ->default(0);
            $table->tinyInteger('language');
            $table->string('specific_language', 50)->nullable();
            $table->string('religious')->nullable();
            $table->tinyInteger('nationality');
            $table->string('specific_nationality', 50)->nullable();
            $table->tinyInteger('migratory_status');
            $table->tinyInteger('ethnic_group');
            $table->json('activities_for_family_support')->nullable();
            $table->json('recreation_activities')->nullable();
            $table->json('additional_information')->nullable();
            $table->tinyInteger('health_status');
            $table->foreignId('reviewed_by')->nullable()->constrained('users');
            $table->dateTime('reviewed_at')->nullable();
            $table->foreignId('disaffiliated_by')->nullable()->constrained('users');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->dateTime('disaffiliated_at')->nullable();
            $table->timestamps();
        });

        Schema::create('banking_information', function ($table): void {
            $table->id();
            $table->unsignedBigInteger('banking_informationable_id');
            $table->string('banking_informationable_type');
            $table->unsignedTinyInteger('account_type');
            $table->unsignedTinyInteger('financial_institution_types');
            $table->string('financial_institution_bank');
            $table->string('account_number', 15);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
        });

        Schema::create('mobile_numbers', function ($table): void {
            $table->id();
            $table->unsignedBigInteger('mobile_numerable_id');
            $table->string('mobile_numerable_type');
            $table->char('number', 14)->unique();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
        });

        Schema::create('family_members', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('family_nucleus_id')->constrained();
            $table->string('name', 100);
            $table->date('birthdate');
            $table->unsignedTinyInteger('gender');
            $table->unsignedTinyInteger('relationship');
            $table->unsignedTinyInteger('education_level');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
        });

        Schema::create('educational_institutions', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 200);
            $table->string('education_type', 20);
            $table->string('financing_type', 20);
            $table->char('zone_code', 6);
            $table->string('address', 100)->nullable();
            $table->string('area', 20);
            $table->string('academic_regime', 20);
            $table->string('modality', 120);
            $table->string('academic_day', 50);
            $table->string('educative_level', 40);
            $table->string('typology', 100);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
            $table->unique(['name', 'zone_code']);
        });

        Schema::create('educational_record', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('child_id')->constrained();
            $table->foreignId('educational_institution_id')->constrained();
            $table->unsignedTinyInteger('status');
            $table->string('level');
            $table->string('fovorite_subject');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
        });

        Schema::create('mailboxes', function (Blueprint $table): void {
            $table->foreignId('id')->primary()->constrained('children')
                ->cascadeOnDelete();
            $table->unsignedTinyInteger('vigency');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->string('token')->unique();
            $table->timestamps();
        });

        Schema::create('mails', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('mailbox_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('type');
            $table->foreignId('reply_mail_id')->nullable()->constrained('mails');
            $table->unsignedTinyInteger('status');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
        });

        Schema::create('answers', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('mail_id')->constrained()->cascadeOnDelete();
            $table->text('content');
            $table->string('attached_file_path');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
        });

        Schema::create('reasons_leaving_study', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('child_id')->constrained()->cascadeOnDelete();
            $table->text('reason');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
        });

        Schema::create('health_status_record', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('child_id')->constrained()->cascadeOnDelete();
            $table->string('description')->nullable();
            $table->string('treatment')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
        });

        Schema::create('disabilities', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('child_id')->constrained('children')->cascadeOnDelete();
            $table->unsignedTinyInteger('type');
            $table->unsignedTinyInteger('percent');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
        });

        Schema::create('houses', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('family_nucleus_id')->constrained();
            $table->unsignedTinyInteger('property');
            $table->unsignedTinyInteger('home_space');
            $table->unsignedTinyInteger('roof');
            $table->unsignedTinyInteger('walls');
            $table->unsignedTinyInteger('floor');
            $table->json('basic_services');
            $table->double('latitude');
            $table->double('longitude');
            $table->string('neighborhood');
            $table->foreignId('created_by');
            $table->foreignId('updated_by');
            $table->timestamps();
        });

        Schema::create('risks_near_home', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('house_id')->constrained();
            $table->string('description');
            $table->foreignId('created_by');
            $table->foreignId('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_status_record');
        Schema::dropIfExists('reasons_leaving_study');
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('letters');
        Schema::dropIfExists('mailboxes');
        Schema::dropIfExists('preschool_educational_record');
        Schema::dropIfExists('educational_record');
        Schema::dropIfExists('educational_institutions');
        Schema::dropIfExists('children');
        Schema::dropIfExists('people');
        Schema::dropIfExists('neighborhoods');
        Schema::dropIfExists('zones');
        Schema::dropIfExists('cities');
        Schema::dropIfExists('communities');
    }
};
