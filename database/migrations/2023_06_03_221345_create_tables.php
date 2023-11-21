<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
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
            $table->char('code', 6)->index();
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
            $table->enum('vigency', ['active', 'inactive'])->default('active');
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

        schema::create('tutors', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->char('dni', 10)->unique();
            $table->enum('gender', ['male', 'female']);
            $table->char('mobile_phone', 10)->unique()->nullable();
            $table->date('birthdate');
            $table->boolean('is_parent')->default(true);
            $table->boolean('is_present')->default(true)
                ->comment('only if the is_parent field is true');
            $table->enum('reason_not_present', [
                'divorced', 'separated', 'lives_elsewhere', 'dead', 'other',
            ])->nullable()->comment('only if the is_parent field is true');
            $table->string('specific_reason')->nullable()
                ->comment('only if the is_parent field is true');
            $table->date('deathdate')->nullable()
                ->comment('only si el field reason_not_present is dead');
            $table->enum('occupation', [
                'private_employee', 'artisan', 'farmer', 'animal_keeper',
                'cook', 'carpenter', 'builder', 'day_laborer', 'mechanic',
                'salesman', 'paid_household_work', 'unpaid_household_work',
                'unknown', 'other',
            ]);
            $table->string('specific_occupation')->nullable()
                ->comment('only if the field occupation is other');
            $table->decimal('salary')->default(0);
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

        Schema::create('family_nuclei', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('tutor1_id')->nullable()
                ->constrained('tutors');
            $table->foreignId('tutor2_id')->nullable()->constrained('tutors');
            $table->char('conventional_phone', 9)->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
        });

        Schema::create('children', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('manager_id')->constrained('users');
            $table->char('children_number', 9)->nullable()
                ->comment('Assigned by ChildFund.');
            $table->string('case_number', 8)->nullable()
                ->comment('Assigned by local partner.');
            $table->foreignId('family_nucleus_id')
                ->comment('A family_nucleus_id can be registered a maximum of 3 times')
                ->constrained();
            $table->foreignUlid('contact_id', 8)->nullable()->constrained();
            $table->string('name');
            $table->char('dni')->unique()->regex('/^[0-9]{10}$/');
            $table->enum('gender', ['male', 'female']);
            $table->date('birthdate');
            $table->enum(
                'affiliation_status',
                ['pending', 'affiliated', 'disaffiliated', 'rejected']
            )
                ->default('pending');
            $table->string('pseudonym', 100);
            $table->enum('sexual_identity', ['boy', 'girl', 'other']);
            $table->enum('literacy', ['none', 'write', 'Read', 'both']);
            $table->enum('language', ['SPANISH', 'QUECHUA', 'OTHER'])
                ->default('SPANISH');
            $table->string('specific_language', 50)->nullable()
                ->comment('only if the language field is other');
            $table->string('religious')->nullable();
            $table->enum('nationality', ['ECUADORIAN', 'OTHER'])
                ->comment('only if the nationality field is other');
            $table->string('specific_nationality', 50)->nullable();
            $table->enum(
                'migratory_status',
                ['NONE', 'MIGRANT', 'REFUGEE']
            )->default('NONE');
            $table->enum(
                'ethnic_group',
                ['AFRO-ECUADORIAN', 'INDIGENOUS', 'MESTIZO', 'OTHER']
            );
            $table->json('activities_for_family_support')->nullable();
            $table->json('recreation_activities')->nullable();
            $table->json('additional_information')->nullable();
            $table->timestamps();
            $table->foreignId('reviewed_by')->nullable()
                ->constrained('users');
            $table->dateTime('reviewed_at')->nullable();
            $table->foreignId('disaffiliated_by')->nullable()
                ->constrained('users');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->dateTime('disaffiliated_at')->nullable();
        });

        DB::unprepared(
            /** @lang MySQL */
            '
            CREATE TRIGGER prevent_underage_children
            BEFORE INSERT ON children
            FOR EACH ROW
            BEGIN
                IF NEW.birthdate > CURDATE() THEN
                    SIGNAL SQLSTATE "45000"
                        SET MESSAGE_TEXT = "Cannot insert children younger than current date";
                END IF;
            END
        '
        );

        Schema::create('banking_information', function ($table): void {
            $table->id();
            $table->foreignId('family_nucleus_id')->nullable()->constrained();
            $table->foreignId('child_id')->nullable()->constrained();
            $table->enum('account_type', ['savings', 'current']);
            $table->enum(
                'type_banking',
                ['bank', 'cooperative', 'mutualist']
            );
            $table->string('name_bank');
            $table->string('account number', 15);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
        });

        DB::unprepared(
            /** @lang MySQL */
            '
            ALTER TABLE banking_information
            ADD CONSTRAINT only_one_nullable
            CHECK (
                (family_nucleus_id IS NULL AND child_id IS NOT NULL) OR
                (family_nucleus_id IS NOT NULL AND child_id IS NULL)
            )
        '
        );

        DB::unprepared(
            /** @lang MySQL */
            '
            CREATE TRIGGER prevent_both_null
            BEFORE INSERT ON banking_information
            FOR EACH ROW
            BEGIN
                IF NEW.family_nucleus_id IS NULL AND NEW.child_id IS NULL THEN
                    SIGNAL SQLSTATE "45000"
                        SET MESSAGE_TEXT = "Cannot have both family_nucleus_id and child_id as null";
                END IF;
            END
        '
        );

        Schema::create('family_members', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('family_nucleus_id')->constrained();
            $table->string('name', 100);
            $table->date('birthdate');
            $table->enum('gender', ['MALE', 'FEMALE']);
            $table->enum('relationship', [
                'father/mother', 'grandfather/grandmother', 'brother/sister',
                'uncle/aunt', 'cousin', 'stepfather/stepmother',
                'stepbrother/stepsister', 'other',
            ]);
            $table->enum(
                'education_level',
                [
                    'none', 'basic_preparatory_education',
                    'elementary_basic_education', 'medium_basic_education',
                    'higher_basic_education', 'baccalaureate', 'superior',
                ]
            );
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
        });

        Schema::create('educational_institutions', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 200);
            $table->enum(
                'type',
                ['public', 'private', 'fiscomisional', 'municipal']
            )
                ->default('public');
            $table->enum('ideology', ['secular', 'religious'])
                ->default('secular');
            $table->foreignUlid('city_code', 4)->constrained('cities', 'code');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');;
            $table->timestamps();
            $table->unique(['name', 'city_code']);
        });

        Schema::create('educational_record', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('child_id')->constrained();
            $table->foreignId('educational_institution_id')->constrained();
            $table->unsignedTinyInteger('grade');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
        });

        Schema::create(
            'preschool_educational_record',
            function (Blueprint $table): void {
                $table->id();
                $table->foreignId('child_id')->constrained();
                $table->string('name_institution', 150);
                $table->enum('type', ['KINDERGARTEN', 'INITIAL']);
                $table->enum('level', [
                    'CMH', 'CDN', 'INITIAL_1', 'INITIAL_2', 'INITIAL_3',
                    'OTHER',
                ]);
                $table->unsignedBigInteger('created_by');
                $table->unsignedBigInteger('updated_by');
                $table->timestamps();
            }
        );

        Schema::create('mailboxes', function (Blueprint $table): void {
            $table->foreignId('id')->primary()->constrained('children');
            $table->enum('vigency', ['ACTIVE', 'INACTIVE']);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
        });

        Schema::create('letters', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('mailbox_id')->constrained();
            $table->enum(
                'letter_type',
                ['initial', 'response', 'thanks', 'goodbye']
            );
            $table->enum('status', ['create', 'sent', 'replied', 'due']);
            $table->string('letter_photo_1_path', 2048);
            $table->string('letter_photo_2_path', 2048)->nullable();
            $table->string('answer', 2048)->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
        });

        Schema::create('tickets', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('letter_id')->unique()->constrained();
            $table->date('date_request');
            $table->date('due_date');
            $table->string('ticket_photo_path', 2048);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
        });

        DB::unprepared(
            /** @lang MySQL */
            '
            CREATE TRIGGER enforce_specific_language
            BEFORE INSERT ON children
            FOR EACH ROW
            BEGIN
                IF NEW.language = "OTHER" AND NEW.specific_language IS NULL THEN
                    SIGNAL SQLSTATE "45000"
                        SET MESSAGE_TEXT = "Specific language must be filled when language is set to OTHER";
                END IF;

                IF NEW.nationality = "OTHER" AND NEW.specific_nationality IS NULL THEN
                    SIGNAL SQLSTATE "45000"
                        SET MESSAGE_TEXT = "Specific nationality must be filled when nationality is set to OTHER";
                END IF;
            END
        '
        );

        Schema::create('reasons_leaving_study', function (Blueprint $table): void {
            $table->foreignId('child_id')->primary()->constrained();
            $table->text('reason');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
        });

        Schema::create('health_status_record', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('child_id')->constrained();
            $table->enum('health_status', [
                'not specified', 'good', 'excellent',
                'presents health problems',
            ]);
            $table->json('health_problem_specification')->nullable()
                ->comment('only if the language field is "presents health problems"');
            $table->json('disabilities')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
        });

        DB::unprepared(
            /** @lang MySQL */
            '
            CREATE TRIGGER enforce_health_problem_specification
            BEFORE INSERT ON health_status_record
            FOR EACH ROW
            BEGIN
                IF NEW.health_status = "presents health problems" AND NEW.health_problem_specification IS NULL THEN
                    SIGNAL SQLSTATE "45000"
                        SET MESSAGE_TEXT = "Health problem specification must be filled when health status is set to presents health problems";
                END IF;
            END
        '
        );

        Schema::create('houses', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('family_nucleus_id')->constrained();
            $table->enum('property', ['self-owned', 'rental', 'borrowed']);
            $table->enum(
                'home_space',
                ['room', 'room and kitchen', 'other']
            );
            $table->enum('roof', [
                'thatched', 'tile', 'asbestos', 'earthenware/tin', 'other',
            ]);
            $table->enum('walls', [
                'brick', 'adobe', 'cinder block', 'wood', 'bahareque', 'cane',
                'other',
            ]);
            $table->enum('floor', [
                'dirt floor', 'cement floor', 'wood floor', 'other',
            ]);
            $table->json('basic services');
            $table->json('extras');
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
