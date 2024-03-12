<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $child->dni }}</title>
    <style>
        html,
        body,
        div,
        span,
        applet,
        object,
        iframe,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        blockquote,
        pre,
        a,
        abbr,
        acronym,
        address,
        big,
        cite,
        code,
        del,
        dfn,
        em,
        img,
        ins,
        kbd,
        q,
        s,
        samp,
        small,
        strike,
        strong,
        sub,
        sup,
        tt,
        var,
        b,
        u,
        i,
        center,
        dl,
        dt,
        dd,
        ol,
        ul,
        li,
        fieldset,
        form,
        label,
        legend,
        table,
        caption,
        tbody,
        tfoot,
        thead,
        tr,
        th,
        td,
        article,
        aside,
        canvas,
        details,
        embed,
        figure,
        figcaption,
        footer,
        header,
        hgroup,
        menu,
        nav,
        output,
        ruby,
        section,
        summary,
        time,
        mark,
        audio,
        video {
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 100%;
            font: inherit;
            vertical-align: baseline;
        }

        /* HTML5 display-role reset for older browsers */
        article,
        aside,
        details,
        figcaption,
        figure,
        footer,
        header,
        hgroup,
        menu,
        nav,
        section {
            display: block;
        }

        body {
            line-height: 1;
        }

        ol,
        ul {
            list-style: none;
        }

        blockquote,
        q {
            quotes: none;
        }

        blockquote:before,
        blockquote:after,
        q:before,
        q:after {
            content: '';
            content: none;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
        }

        html {
            margin: 0;
            font-family: Verdana, sans-serif;
            font-size: 11px
        }
    </style>
</head>

<body>

    {{-- HOJA 1 --}}
    <div style="position: absolute; z-index: 2;">
        @php
            $date = $child->updated_at->format('d/m/y');
        @endphp


        <p style="position: absolute; padding-left: 25.1rem; padding-top: 17.7rem">{{ $date[0] }}</p>
        <p style="position: absolute; padding-left: 26.8rem; padding-top: 17.7rem">{{ $date[1] }}</p>
        <p style="position: absolute; padding-left: 28.8rem; padding-top: 17.7rem">{{ $date[3] }}</p>
        <p style="position: absolute; padding-left: 30.5rem; padding-top: 17.7rem">{{ $date[4] }}</p>
        <p style="position: absolute; padding-left: 32.6rem; padding-top: 17.7rem">{{ $date[6] }}</p>
        <p style="position: absolute; padding-left: 34.3rem; padding-top: 17.7rem">{{ $date[7] }}</p>
        <img style="position: absolute; padding-left: 54.0rem; padding-top: 2.5rem; transform: rotate(2deg);"
            src="{{ $child->getFilamentAvatarUrl() }}" width="151">

        @if ($date == $child->created_at->format('d/m/y'))
            <p style="position: absolute; padding-left: 10.5rem; padding-top: 19.8rem">X</p>
        @else
            <p style="position: absolute; padding-left: 28.7rem; padding-top: 19.8rem">X</p>
        @endif

        <p style="position: absolute; padding-left: 10.2rem; padding-top: 28.5rem; white-space: nowrap;">
            {{ $child->name }}</p>

        <p style="position: absolute; padding-left: 43.6rem; padding-top: 28.5rem; white-space: nowrap;">
            {{ $child->last_name }}
        </p>

        <p style="position: absolute; padding-left: 20.3rem; padding-top: 30.6rem; white-space: nowrap;">
            {{ $child->pseudonym }}</p>
        @php
            $date = $child->birthdate->format('d/m/Y');
        @endphp

        @if ($child->sexual_identity == \App\Enums\SexualIdentity::Girl)
            <p style="position: absolute; padding-left: 43.5rem; padding-top: 30.7rem">X</p>
        @elseif ($child->sexual_identity == \App\Enums\SexualIdentity::Boy)
            <p style="position: absolute; padding-left: 54rem; padding-top: 30.7rem">X</p>
        @elseif ($child->sexual_identity == \App\Enums\SexualIdentity::Other)
            <p style="position: absolute; padding-left: 64.2rem; padding-top: 30.7rem">X</p>
        @endif

        @if ($child->gender == \App\Enums\Gender::Female)
            <p style="position: absolute; padding-left: 43.5rem; padding-top: 32.1rem">X</p>
        @elseif ($child->gender == \App\Enums\Gender::Male)
            <p style="position: absolute; padding-left: 54.0rem; padding-top: 32.1rem">X</p>
        @elseif ($child->gender == \App\Enums\Gender::Other)
            <p style="position: absolute; padding-left: 64.2rem; padding-top: 32.1rem">X</p>
        @endif

        <p style="position: absolute; padding-left: 21.8rem; padding-top: 34.1rem">{{ $date[0] }}</p>
        <p style="position: absolute; padding-left: 23.5rem; padding-top: 34.1rem">{{ $date[1] }}</p>
        <p style="position: absolute; padding-left: 25.5rem; padding-top: 34.1rem">{{ $date[3] }}</p>
        <p style="position: absolute; padding-left: 27.2rem; padding-top: 34.1rem">{{ $date[4] }}</p>
        <p style="position: absolute; padding-left: 29.3rem; padding-top: 34.1rem">{{ $date[6] }}</p>
        <p style="position: absolute; padding-left: 31.0rem; padding-top: 34.1rem">{{ $date[7] }}</p>
        <p style="position: absolute; padding-left: 32.7rem; padding-top: 34.1rem">{{ $date[8] }}</p>
        <p style="position: absolute; padding-left: 34.4rem; padding-top: 34.1rem">{{ $date[9] }}</p>

        @php
            $age = str_pad($child->birthdate->diff(Carbon\Carbon::now())->format('%y'), 2, '0', STR_PAD_LEFT);
        @endphp

        <p style="position: absolute; padding-left: 44.0rem; padding-top: 34.1rem">{{ $age[0] }}</p>
        <p style="position: absolute; padding-left: 45.7rem; padding-top: 34.1rem">{{ $age[1] }}</p>


        @php
            $community = $child->manager->community_manager->community;
            $zone = $community->zone;
            $city = $zone->city;
            $state = $city->state;
        @endphp
        <p style="position: absolute; padding-left: 53.5rem; padding-top: 34.1rem; white-space: nowrap;">
            {{ $state->name }}</p>

        <p style="position: absolute; padding-left: 9.8em; padding-top: 36.3rem; white-space: nowrap;">
            {{ $city->name }}</p>

        <p style="position: absolute; padding-left: 19.7rem; padding-top: 38.4rem; white-space: nowrap;">
            {{ $community->name }}</p>

        <p style="position: absolute; padding-left: 43.7rem; padding-top: 36.3rem; white-space: nowrap;">
            {{ $community->zone->name }}</p>

        <p style="position: absolute; padding-left: 43.7rem; padding-top: 38.4rem; white-space: nowrap;">
            {{ $child->family_nucleus->house->neighborhood }}</p>


        @if ($child->family_nucleus->house->territory == \App\Enums\Location::Urban)
            <p style="position: absolute; padding-left: 20.1rem; padding-top: 40.5rem;">X</p>
        @elseif ($child->family_nucleus->house->territory == \App\Enums\Location::Periurban)
            <p style="position: absolute; padding-left: 26.1rem; padding-top: 40.5rem;">X</p>
        @elseif ($child->family_nucleus->house->territory == \App\Enums\Location::Rural)
            <p style="position: absolute; padding-left: 34rem; padding-top: 40.5rem;">X</p>
        @elseif ($child->family_nucleus->house->territory == \App\Enums\Location::Other)
            <p style="position: absolute; padding-left: 39rem; padding-top: 40.5rem;">X</p>
        @endif

        <p style="position: absolute; padding-top: 42.6rem;">
            @php
                $latitudeDigits = str_split(substr($child->family_nucleus->house->latitude, 0, 8));
                $leftOffset = 25.1;
            @endphp

            @foreach ($latitudeDigits as $digit)
                <span style="position: absolute; left: {{ $leftOffset }}rem;">
                    {{ $digit }}
                </span>

                @php
                    $leftOffset += 1.7;
                @endphp
            @endforeach
        </p>

        <p style="position: absolute; padding-top: 42.6rem;">
            @php
                $longitudeDigits = str_split(substr($longitude = $child->family_nucleus->house->longitude, 0, 8));
                $leftOffset = 47.7;
            @endphp

            @foreach ($longitudeDigits as $digit)
                <span style="position: absolute; left: {{ $leftOffset }}rem;">
                    {{ $digit }}
                </span>

                @php
                    $leftOffset += 1.7;
                @endphp
            @endforeach
        </p>

        @php
            $tutor = $child->family_nucleus->tutors->first();
        @endphp

        <p style="position: absolute; padding-left: 20.5rem; padding-top: 49.3rem; white-space: nowrap;">
            {{ $tutor->name }}
        </p>

        <p style="position: absolute; padding-top: 51.5rem;">
            @php
                $accountNumberDigits = str_split($tutor->dni);
                $leftOffset = 19;
            @endphp

            @foreach ($accountNumberDigits as $digit)
                <span style="position: absolute; left: {{ $leftOffset }}rem;">
                    {{ $digit }}
                </span>

                @php
                    $leftOffset += 1.7;
                @endphp
            @endforeach
        </p>

        <p style="position: absolute; padding-top: 53.6rem;">
            @php
                $number = $tutor->mobile_number->number;
                $number = '0' . substr($number, 4);
                $numberDigits = str_split($number);
                $leftOffset = 51;
            @endphp

            @foreach ($numberDigits as $digit)
                <span style="position: absolute; left: {{ $leftOffset }}rem;">
                    {{ $digit }}
                </span>

                @php
                    $leftOffset += 1.72;
                @endphp
            @endforeach
        </p>

        <p style="position: absolute; padding-left: 43.7rem; padding-top: 51.5rem; white-space: nowrap;">
            {{ $tutor->relationship->getLabel() }}
        </p>

        <p style="position: absolute; padding-left: 20.7rem; padding-top: 58.6rem; white-space: nowrap;">
            {{ $child->family_nucleus->house->family_nucleus->conventional_phone }}</p>

        @if ($child->language == \App\Enums\Language::Spanish->value)
            <p style="position: absolute; padding-left: 9.5rem; padding-top: 60.4rem; white-space: nowrap;">X</p>
        @elseif ($child->language == \App\Enums\Language::Quechua->value)
            <p style="position: absolute; padding-left: 15.5rem; padding-top: 60.4rem; white-space: nowrap;">X</p>
        @elseif ($child->language == \App\Enums\Language::Other->value)
            <p style="position: absolute; padding-left: 23.6rem; padding-top: 60.4rem; white-space: nowrap;">X</p>
        @endif

        <p style="position: absolute; padding-left: 53.7rem; padding-top: 60.3rem; white-space: nowrap;">
            {{ $child->religious }}</p>

        @if ($child->nationality == \App\Enums\Nationality::Ecuadorian->value)
            <p style="position: absolute; padding-left: 15.5rem; padding-top: 62.5rem; white-space: nowrap;">X</p>
        @elseif ($child->nationality == \App\Enums\Nationality::Other->value)
            <p style="position: absolute; padding-left: 28rem; padding-top: 62.5rem; white-space: nowrap;">X</p>
        @endif

        @if ($child->migratory_status == \App\Enums\MigratoryStatus::Migrant->value)
            <p style="position: absolute; padding-left: 53.2rem; padding-top: 64.6rem; white-space: nowrap;">X</p>
        @elseif ($child->migratory_status == \App\Enums\MigratoryStatus::Refugee->value)
            <p style="position: absolute; padding-left: 61.6rem; padding-top: 64.6rem; white-space: nowrap;">X</p>
        @endif

        @if ($child->ethnic_group == \App\Enums\EthnicGroup::AfroEcuadorian->value)
            <p style="position: absolute; padding-left: 14.2rem; padding-top: 66.7rem; white-space: nowrap;">X</p>
        @elseif ($child->ethnic_group == \App\Enums\EthnicGroup::Indigenous->value)
            <p style="position: absolute; padding-left: 26rem; padding-top: 66.7rem; white-space: nowrap;">X</p>
        @elseif ($child->ethnic_group == \App\Enums\EthnicGroup::Mestizo->value)
            <p style="position: absolute; padding-left: 34.4rem; padding-top: 66.7rem; white-space: nowrap;">X</p>
        @elseif ($child->ethnic_group == \App\Enums\EthnicGroup::Other->value)
            <p style="position: absolute; padding-left: 42.3rem; padding-top: 66.7rem; white-space: nowrap;">X</p>
        @endif


        @php
            $educational_record = $child->educational_record;
        @endphp

        @if ($educational_record)
            <p style="position: absolute; padding-left: 20.1rem; padding-top: 73.5rem; white-space: nowrap;">X</p>
        @else
            <p style="position: absolute; padding-left: 26rem; padding-top: 73.5rem; white-space: nowrap;">X</p>
        @endif

        @if ($educational_record?->status == \App\Enums\EducationalStatus::Kindergarten->value)
            <p style="position: absolute; padding-left: 20.1rem; padding-top: 77.2rem; white-space: nowrap;">X</p>
        @elseif ($educational_record?->status == \App\Enums\EducationalStatus::InitialEducation->value)
            <p style="position: absolute; padding-left: 20.1rem; padding-top: 79rem; white-space: nowrap;">X</p>
        @elseif ($educational_record?->status == \App\Enums\EducationalStatus::BasicGeneralEducation->value)
            <p style="position: absolute; padding-left: 20.1rem; padding-top: 80.8rem; white-space: nowrap;">X</p>
        @elseif ($educational_record?->status == \App\Enums\EducationalStatus::UnifiedGeneralBaccalaureate->value)
            <p style="position: absolute; padding-left: 20.1rem; padding-top: 82.5rem; white-space: nowrap;">X</p>
        @endif

        <p style="position: absolute; padding-left: 20.2rem; padding-top: 84.5rem; white-space: nowrap;">
            {{ $educational_record?->fovorite_subject }}</p>

        <p style="position: absolute; padding-left: 20.2rem; padding-top: 86.6rem; white-space: nowrap;">
            {{ $educational_record?->educational_institution->name }}</p>

        <p style="position: absolute; padding-left: 20.2rem; padding-top: 88.6rem; white-space: nowrap;">
            {{ $educational_record?->educational_institution->address }}</p>

        @if ($child->literacy == \App\Enums\Literacy::None->value)
            <p style="position: absolute; padding-left: 57rem; padding-top: 90.7rem; white-space: nowrap;">X</p>
        @elseif ($child->literacy == \App\Enums\Literacy::Write->value)
            <p style="position: absolute; padding-left: 42.3rem; padding-top: 90.7rem; white-space: nowrap;">X</p>
        @elseif ($child->literacy == \App\Enums\Literacy::Read->value)
            <p style="position: absolute; padding-left: 36.7rem; padding-top: 90.7rem; white-space: nowrap;">X</p>
        @elseif ($child->literacy == \App\Enums\Literacy::Both->value)
            <p style="position: absolute; padding-left: 50rem; padding-top: 90.7rem; white-space: nowrap;">X</p>
        @endif

        <img style="z-index: -1; position: absolute" src="{{ public_path('/images/sheet/1.jpg') }}" height="1120">

    </div>


    <div style="page-break-after: always"></div>


    {{-- HOJA 2 --}}
    <div style="position: absolute; z-index: 2;">


        @if ($child->health_status == \App\Enums\HealthStatus::NotSpecific)
            <p style="position: absolute; padding-left: 20.1rem; padding-top: 7.9rem">X</p>
        @elseif ($child->health_status == \App\Enums\HealthStatus::Good)
            <p style="position: absolute; padding-left: 33.3rem; padding-top: 7.9rem">X</p>
        @elseif ($child->health_status == \App\Enums\HealthStatus::Excellent)
            <p style="position: absolute; padding-left: 43.5rem; padding-top: 7.9rem">X</p>
        @elseif ($child->health_status == \App\Enums\HealthStatus::HasProblems)
            <p style="position: absolute; padding-left: 53.2rem; padding-top: 7.9rem">X</p>
        @endif

        @php
            $health_status_record = $child->health_status_record;
        @endphp

        @if ($health_status_record)
            <p style="position: absolute; padding-left: 5rem; padding-top: 11.7rem">
                {{ $health_status_record->description }}
            </p>
            <p style="position: absolute; padding-left: 5rem; padding-top: 15.4rem">
                {{ $health_status_record->treatment }}
            </p>
        @endif

        @foreach ($child->disabilities as $disability)
            @if ($disability->type == \App\Enums\Disability::Cognitive)
                <p style="position: absolute; padding-left: 4.5rem; padding-top: 19.1rem;">X</p>
            @elseif ($disability->type == \App\Enums\Disability::Physical)
                <p style="position: absolute; padding-left: 20.2rem; padding-top: 19.1rem;">X</p>
            @elseif ($disability->type == \App\Enums\Disability::Visual)
                <p style="position: absolute; padding-left: 27rem; padding-top: 19.1rem;">X</p>
            @elseif ($disability->type == \App\Enums\Disability::Hearing)
                <p style="position: absolute; padding-left: 12.5rem; padding-top: 19.1rem;">X</p>
            @elseif ($disability->type == \App\Enums\Disability::Speech)
                <p style="position: absolute; padding-left: 33.7rem; padding-top: 19.1rem;">X</p>
            @elseif ($disability->type == \App\Enums\Disability::Psychosocial)
                <p style="position: absolute; padding-left: 41.4rem; padding-top: 19.1rem;">X</p>
            @endif
        @endforeach


        @php
            $SupportActivities = $child->activities_for_family_support;
        @endphp

        @foreach ($SupportActivities as $activity)
            @if ($activity == \App\Enums\ActivityForFamilySupport::Washes->value)
                <p style="position: absolute; padding-left: 4.5rem; padding-top: 27.7rem;">X</p>
            @elseif ($activity == \App\Enums\ActivityForFamilySupport::BringsFirewood->value)
                <p style="position: absolute; padding-left: 4.5rem; padding-top: 29.4rem;">X</p>
            @elseif ($activity == \App\Enums\ActivityForFamilySupport::BringsWater->value)
                <p style="position: absolute; padding-left: 4.5rem; padding-top: 31.1rem;">X</p>
            @elseif ($activity == \App\Enums\ActivityForFamilySupport::TakesCareOfAnimals->value)
                <p style="position: absolute; padding-left: 20.1rem; padding-top: 26rem;">X</p>
            @elseif ($activity == \App\Enums\ActivityForFamilySupport::Cooks->value)
                <p style="position: absolute; padding-left: 20.1rem; padding-top: 27.7rem;">X</p>
            @elseif ($activity == \App\Enums\ActivityForFamilySupport::HasDeBed->value)
                <p style="position: absolute; padding-left: 20.1rem; padding-top: 29.4rem;">X</p>
            @elseif ($activity == \App\Enums\ActivityForFamilySupport::DoesTheShopping->value)
                <p style="position: absolute; padding-left: 20.1rem; padding-top: 31.1rem;">X</p>
            @elseif ($activity == \App\Enums\ActivityForFamilySupport::CaresOfBrothersSisters->value)
                <p style="position: absolute; padding-left: 36.6rem; padding-top: 26rem;">X</p>
            @elseif ($activity == \App\Enums\ActivityForFamilySupport::CleansTheHouse->value)
                <p style="position: absolute; padding-left: 36.6rem; padding-top: 29.4rem;">X</p>
            @elseif ($activity == \App\Enums\ActivityForFamilySupport::RunsErrands->value)
                <p style="position: absolute; padding-left: 53.2rem; padding-top: 26rem;">X</p>
            @elseif ($activity == \App\Enums\ActivityForFamilySupport::GathersGrassForAnimals->value)
                <p style="position: absolute; padding-left: 53.2rem; padding-top: 27.7rem;">X</p>
            @endif
        @endforeach


        @php
            $RecreationActivities = $child->recreation_activities;
        @endphp

        @foreach ($RecreationActivities as $activity)
            @if ($activity == \App\Enums\ActivityForRecreation::PlaysWithDolls->value)
                <p style="position: absolute; padding-left: 4.5rem; padding-top: 39.6rem;">X</p>
            @elseif ($activity == \App\Enums\ActivityForRecreation::JumpsRope->value)
                <p style="position: absolute; padding-left: 4.5rem; padding-top: 41.3rem;">X</p>
            @elseif ($activity == \App\Enums\ActivityForRecreation::PlaysBall->value)
                <p style="position: absolute; padding-left: 4.5rem; padding-top: 43rem;">X</p>
            @elseif ($activity == \App\Enums\ActivityForRecreation::PlaysMarbles->value)
                <p style="position: absolute; padding-left: 20.1rem; padding-top: 37.9rem;">X</p>
            @elseif ($activity == \App\Enums\ActivityForRecreation::PlaysHouse->value)
                <p style="position: absolute; padding-left: 20.1rem; padding-top: 39.6rem;">X</p>
            @elseif ($activity == \App\Enums\ActivityForRecreation::PlaysWithCarts->value)
                <p style="position: absolute; padding-left: 20.1rem; padding-top: 41.3rem;">X</p>
            @elseif ($activity == \App\Enums\ActivityForRecreation::PlaysHopscotch->value)
                <p style="position: absolute; padding-left: 20.1rem; padding-top: 43rem;">X</p>
            @elseif ($activity == \App\Enums\ActivityForRecreation::Runs->value)
                <p style="position: absolute; padding-left: 36.6rem; padding-top: 37.9rem;">X</p>
            @elseif ($activity == \App\Enums\ActivityForRecreation::PlaysWithRattles->value)
                <p style="position: absolute; padding-left: 36.6rem; padding-top: 39.6rem;">X</p>
            @elseif ($activity == \App\Enums\ActivityForRecreation::PlaysHideAndSeek->value)
                <p style="position: absolute; padding-left: 36.6rem; padding-top: 41.3rem;">X</p>
            @elseif ($activity == \App\Enums\ActivityForRecreation::PlaysWithFriends->value)
                <p style="position: absolute; padding-left: 36.6rem; padding-top: 43rem;">X</p>
            @elseif ($activity == \App\Enums\ActivityForRecreation::PlaysHulaHoops->value)
                <p style="position: absolute; padding-left: 53.2rem; padding-top: 37.9rem;">X</p>
            @elseif ($activity == \App\Enums\ActivityForRecreation::RidesABicycle->value)
                <p style="position: absolute; padding-left: 53.2rem; padding-top: 39.6rem;">X</p>
            @endif
        @endforeach

        <p style="position: absolute; padding-left: 20.3rem; padding-top: 49.5rem; white-space: nowrap;">
            {{ $child->physical_description }}
        </p>

        <p style="position: absolute; padding-left: 5rem; padding-top: 53.3rem; white-space: nowrap;">
            {{ $child->skills }}
        </p>

        <p style="position: absolute; padding-left: 5rem; padding-top: 59rem; white-space: nowrap;">
            {{ $child->personality }}
        </p>

        <p style="position: absolute; padding-left: 5rem; padding-top: 64.8rem; white-space: nowrap;">
            {{ $child->aspirations }}
        </p>

        <p style="position: absolute; padding-left: 5rem; padding-top: 70.4rem; white-space: nowrap;">
            {{ $child->likes }}
        </p>

        <p style="position: absolute; padding-left: 5rem; padding-top: 76rem; white-space: nowrap;">
            {{ $child->dislikes }}
        </p>


        @php
            $banking_information = $child->family_nucleus->banking_information ?? $child->banking_information;
        @endphp

        @if ($banking_information?->account_type == \App\Enums\BankAccountType::Savings->value)
            <p style="position: absolute; padding-left: 20.1rem; padding-top: 86.5rem;">X</p>
        @elseif ($banking_information?->account_type == \App\Enums\BankAccountType::Checking->value)
            <p style="position: absolute; padding-left: 36.6rem; padding-top: 86.5rem;">X</p>
        @endif


        @if ($banking_information?->financial_institution_types == \App\Enums\FinancialInstitutionType::Bank->value)
            <p style="position: absolute; padding-left: 20.1rem; padding-top: 88.7rem;">X</p>
        @elseif ($banking_information?->financial_institution_types == \App\Enums\FinancialInstitutionType::Cooperative->value)
            <p style="position: absolute; padding-left: 36.6rem; padding-top: 88.7rem;">X</p>
        @elseif ($banking_information?->financial_institution_types == \App\Enums\FinancialInstitutionType::Mutuality->value)
            <p style="position: absolute; padding-left: 51rem; padding-top: 88.7rem;">X</p>
        @endif


        <p style="position: absolute; padding-left: 43.1rem; padding-top: 90.8rem;">
            {{ $banking_information?->financial_institution_bank }}
        </p>

        <p style="position: absolute; padding-top: 93rem;">
            @php
                $accountNumberDigits = str_split($banking_information?->account_number);
                $leftOffset = 16.2;
            @endphp

            @foreach ($accountNumberDigits as $digit)
                <span style="position: absolute; left: {{ $leftOffset }}rem;">
                    {{ $digit }}
                </span>

                @php
                    $leftOffset += 1.7;
                @endphp
            @endforeach
        </p>

        <img style="z-index: -1; position: absolute" src="{{ public_path('/images/sheet/2.jpg') }}" height="1120">
    </div>


    <div style="page-break-after: always"></div>


    {{-- HOJA 3 --}}
    <div style="position: absolute; z-index: 2;">


        @php
            $tutors = $child->family_nucleus->tutors;
            if (count($tutors) < 2) {
                $tutors[] = null;
            }
            if ($tutors[0]->gender == \App\Enums\Gender::Male) {
                $aux = $tutors[0];
                $tutors[0] = $tutors[1];
                $tutors[1] = $aux;
            }
            $upOffset = 0;
        @endphp

        @foreach ($tutors as $tutor)
            @if ($tutor != null)
                @if ($tutor->is_present == 1)
                    <p style="position: absolute; padding-left: 30.4rem; padding-top: {{ 7.9 + $upOffset }}rem">X</p>
                @elseif ($tutor->is_present == 0)
                    <p style="position: absolute; padding-left: 36.5rem; padding-top: {{ 7.9 + $upOffset }}rem">X</p>
                @endif

                @if ($tutor->reason_not_present == \App\Enums\ReasonsIsNotPresent::Divorced->value)
                    <p style="position: absolute; padding-left: 4.5rem; padding-top: {{ 20.1 + $upOffset }}rem">X</p>
                @elseif ($tutor->reason_not_present == \App\Enums\ReasonsIsNotPresent::Separated->value)
                    <p style="position: absolute; padding-left: 20.1rem; padding-top: {{ 20.1 + $upOffset }}rem">X</p>
                @elseif ($tutor->reason_not_present == \App\Enums\ReasonsIsNotPresent::LivesElsewhere->value)
                    <p style="position: absolute; padding-left: 36.6rem; padding-top: {{ 20.1 + $upOffset }}rem">X</p>
                @elseif ($tutor->reason_not_present == \App\Enums\ReasonsIsNotPresent::Dead->value)
                    <p style="position: absolute; padding-left: 60rem; padding-top: {{ 20.1 + $upOffset }}rem">FECHA
                    </p>
                @elseif ($tutor->reason_not_present == \App\Enums\ReasonsIsNotPresent::Other->value)
                    <p style="position: absolute; padding-left: 7.5rem; padding-top: {{ 22.3 + $upOffset }}rem">

                        {{ $tutor->specific_reason }}
                    </p>
                @endif

                <p
                    style="position: absolute; padding-left: 62rem; padding-top: {{ 7.9 + $upOffset }}rem; white-space: nowrap; ">
                    {{ $tutor->salary }}
                </p>

                @if ($tutor->occupation == \App\Enums\Occupation::PrivateEmployee->value)
                    <p style="position: absolute; padding-left: 4.5rem; padding-top: {{ 11.6 + $upOffset }}rem">X</p>
                @elseif ($tutor->occupation == \App\Enums\Occupation::Artisan->value)
                    <p style="position: absolute; padding-left: 4.5rem; padding-top: {{ 13.3 + $upOffset }}rem">X</p>
                @elseif ($tutor->occupation == \App\Enums\Occupation::Farmer->value)
                    <p style="position: absolute; padding-left: 4.5rem; padding-top: {{ 15 + $upOffset }}rem">X</p>
                @elseif ($tutor->occupation == \App\Enums\Occupation::AnimalKeeper->value)
                    <p style="position: absolute; padding-left: 4.5rem; padding-top: {{ 16.7 + $upOffset }}rem">X</p>
                @elseif ($tutor->occupation == \App\Enums\Occupation::Cook->value)
                    <p style="position: absolute; padding-left: 20.1rem; padding-top: {{ 11.6 + $upOffset }}rem">X</p>
                @elseif ($tutor->occupation == \App\Enums\Occupation::Carpenter->value)
                    <p style="position: absolute; padding-left: 20.1rem; padding-top: {{ 13.3 + $upOffset }}rem">X</p>
                @elseif ($tutor->occupation == \App\Enums\Occupation::Builder->value)
                    <p style="position: absolute; padding-left: 20.1rem; padding-top: {{ 15 + $upOffset }}rem">X</p>
                @elseif ($tutor->occupation == \App\Enums\Occupation::DayLaborer->value)
                    <p style="position: absolute; padding-left: 20.1rem; padding-top: {{ 16.7 + $upOffset }}rem">X</p>
                @elseif ($tutor->occupation == \App\Enums\Occupation::Mechanic->value)
                    <p style="position: absolute; padding-left: 32.5rem; padding-top: {{ 11.6 + $upOffset }}rem">X</p>
                @elseif ($tutor->occupation == \App\Enums\Occupation::Salesman->value)
                    <p style="position: absolute; padding-left: 32.5rem; padding-top: {{ 13.3 + $upOffset }}rem">X</p>
                @elseif ($tutor->occupation == \App\Enums\Occupation::PaidHouseholdWork->value)
                    <p style="position: absolute; padding-left: 32.5rem; padding-top: {{ 15 + $upOffset }}rem">X</p>
                @elseif ($tutor->occupation == \App\Enums\Occupation::UnpaidHouseholdWork->value)
                    <p style="position: absolute; padding-left: 32.5rem; padding-top: {{ 16.7 + $upOffset }}rem">X</p>
                @elseif ($tutor->occupation == \App\Enums\Occupation::Unknown->value)
                    <p style="position: absolute; padding-left: 53.2rem; padding-top: {{ 11.6 + $upOffset }}rem">X</p>
                @elseif ($tutor->occupation == \App\Enums\Occupation::Other->value)
                    <p style="position: absolute; padding-left: 53.2rem; padding-top: {{ 13.3 + $upOffset }}rem">X</p>
                    <p style="position: absolute; padding-left: 57.5rem; padding-top: {{ 13.3 + $upOffset }}rem">
                        {{ $tutor->specific_occupation }}
                    </p>
                @endif

                @php
                    $upOffset += 25.6;
                @endphp
            @endif
        @endforeach


        @if ($child->family_nucleus->house->property == \App\Enums\HousePropertyTypes::SelfOwned->value)
            <p style="position: absolute; padding-left: 20.1rem; padding-top: 63.8rem">X</p>
        @elseif ($child->family_nucleus->house->property == \App\Enums\HousePropertyTypes::Rental->value)
            <p style="position: absolute; padding-left: 36.6rem; padding-top: 63.8rem">X</p>
        @elseif ($child->family_nucleus->house->property == \App\Enums\HousePropertyTypes::Borrowed->value)
            <p style="position: absolute; padding-left: 53.2rem; padding-top: 63.8rem">X</p>
        @endif



        @if ($child->family_nucleus->house->home_space == \App\Enums\HomeSpaceSituations::Room->value)
            <p style="position: absolute; padding-left: 20.1rem; padding-top: 65.9rem">X</p>
        @elseif ($child->family_nucleus->house->home_space == \App\Enums\HomeSpaceSituations::RoomAndKitchen->value)
            <p style="position: absolute; padding-left: 36.6rem; padding-top: 65.9rem">X</p>
        @elseif ($child->family_nucleus->house->home_space == \App\Enums\HomeSpaceSituations::Other->value)
            <p style="position: absolute; padding-left: 53.2rem; padding-top: 65.9rem">X</p>
        @endif



        @if ($child->family_nucleus->house->roof == \App\Enums\RoofMaterials::Thatched->value)
            <p style="position: absolute; padding-left: 20.1rem; padding-top: 68rem">X</p>
        @elseif ($child->family_nucleus->house->roof == \App\Enums\RoofMaterials::Shingle->value)
            <p style="position: absolute; padding-left: 28.5rem; padding-top: 68rem">X</p>
        @elseif ($child->family_nucleus->house->roof == \App\Enums\RoofMaterials::Asbestos->value)
            <p style="position: absolute; padding-left: 36.6rem; padding-top: 68rem">X</p>
        @elseif ($child->family_nucleus->house->roof == \App\Enums\RoofMaterials::TileZinc->value)
            <p style="position: absolute; padding-left: 44.5rem; padding-top: 68rem">X</p>
        @elseif ($child->family_nucleus->house->roof == \App\Enums\RoofMaterials::Other->value)
            <p style="position: absolute; padding-left: 53.2rem; padding-top: 68rem">X</p>
        @endif



        @if ($child->family_nucleus->house->walls == \App\Enums\WallMaterials::Brick->value)
            <p style="position: absolute; padding-left: 20.1rem; padding-top: 69.9rem">X</p>
        @elseif ($child->family_nucleus->house->walls == \App\Enums\WallMaterials::Adobe->value)
            <p style="position: absolute; padding-left: 28.5rem; padding-top: 69.9rem">X</p>
        @elseif ($child->family_nucleus->house->walls == \App\Enums\WallMaterials::CinderBlock->value)
            <p style="position: absolute; padding-left: 36.6rem; padding-top: 69.9rem">X</p>
        @elseif ($child->family_nucleus->house->walls == \App\Enums\WallMaterials::Wood->value)
            <p style="position: absolute; padding-left: 44.5rem; padding-top: 69.9rem">X</p>
        @elseif ($child->family_nucleus->house->walls == \App\Enums\WallMaterials::Bahareque->value)
            <p style="position: absolute; padding-left: 53.2rem; padding-top: 69.9rem">X</p>
        @elseif ($child->family_nucleus->house->walls == \App\Enums\WallMaterials::Cane->value)
            <p style="position: absolute; padding-left: 36.6rem; padding-top: 71.8rem">X</p>
        @elseif ($child->family_nucleus->house->walls == \App\Enums\WallMaterials::Other->value)
            <p style="position: absolute; padding-left: 53.2rem; padding-top: 71.8rem">X</p>
        @endif



        @if ($child->family_nucleus->house->floor == \App\Enums\FloorMaterials::Dirt->value)
            <p style="position: absolute; padding-left: 20.1rem; padding-top: 73.7rem">X</p>
        @elseif ($child->family_nucleus->house->floor == \App\Enums\FloorMaterials::Cement->value)
            <p style="position: absolute; padding-left: 28.5rem; padding-top: 73.7rem">X</p>
        @elseif ($child->family_nucleus->house->floor == \App\Enums\FloorMaterials::Wood->value)
            <p style="position: absolute; padding-left: 36.6rem; padding-top: 73.7rem">X</p>
        @elseif ($child->family_nucleus->house->floor == \App\Enums\FloorMaterials::Other->value)
            <p style="position: absolute; padding-left: 44.5rem; padding-top: 73.7rem">X</p>
        @endif





        @foreach ($child->family_nucleus->house->basic_services as $basicServices)
            @if ($basicServices == \App\Enums\BasicServices::DrinkingWater->value)
                <p style="position: absolute; padding-left: 4.5rem; padding-top: 77.6rem;">X</p>
            @elseif ($basicServices == \App\Enums\BasicServices::TubingWater->value)
                <p style="position: absolute; padding-left: 20.1rem; padding-top: 77.6rem;">X</p>
            @elseif ($basicServices == \App\Enums\BasicServices::WellWater->value)
                <p style="position: absolute; padding-left: 36.6rem; padding-top: 77.6rem;">X</p>
            @elseif ($basicServices == \App\Enums\BasicServices::Internet->value)
                <p style="position: absolute; padding-left: 4.5rem; padding-top: 79.1rem;">X</p>
            @elseif ($basicServices == \App\Enums\BasicServices::Sewerage->value)
                <p style="position: absolute; padding-left: 20.1rem; padding-top: 79.1rem;">X</p>
            @elseif ($basicServices == \App\Enums\BasicServices::Toilet->value)
                <p style="position: absolute; padding-left: 36.6rem; padding-top: 79.1rem;">X</p>
            @elseif ($basicServices == \App\Enums\BasicServices::Latrine->value)
                <p style="position: absolute; padding-left: 4.5rem; padding-top: 80.8rem;">X</p>
            @elseif ($basicServices == \App\Enums\BasicServices::SepticTank->value)
                <p style="position: absolute; padding-left: 20.1rem; padding-top: 80.8rem;">X</p>
            @elseif ($basicServices == \App\Enums\BasicServices::Electricity->value)
                <p style="position: absolute; padding-left: 53.2rem; padding-top: 77.6rem;">X</p>
            @elseif ($basicServices == \App\Enums\BasicServices::Shower->value)
                <p style="position: absolute; padding-left: 53.2rem; padding-top: 79.1rem;">X</p>
            @endif
        @endforeach



        @php $risks = $child->family_nucleus->house->risks_near_home; @endphp
        @if ($risks->isNotEmpty())
            <div style="position: relative; width: {{ 12 * $risks->count() + 20.7 }}rem;">
                @php $leftPosition = 42; @endphp
                @foreach ($risks as $index => $risk)
                    <span
                        style="position: absolute; left: {{ $leftPosition }}rem; top: 84.6rem; white-space: nowrap;">
                        {{ $risk->description }}
                        @if (!$loop->last)
                            ,
                        @endif
                    </span>
                    @php
                        $leftPosition += strlen($risk->description) * 0.5 + 0.7;
                    @endphp
                @endforeach
            </div>
        @endif







        @php
            $TutorRisk = $child->family_nucleus->risk_factors;
        @endphp

        @foreach ($TutorRisk as $RiskPerTutor)
            @if ($RiskPerTutor == \App\Enums\RisksTutor::Disability->value)
                <p style="position: absolute; padding-left: 4.5rem; padding-top: 93.2rem">X</p>
            @elseif ($RiskPerTutor == \App\Enums\RisksTutor::Absent->value)
                <p style="position: absolute; padding-left: 20.1rem; padding-top: 93.2rem">X</p>
            @elseif ($RiskPerTutor == \App\Enums\RisksTutor::Disease->value)
                <p style="position: absolute; padding-left: 36.6rem; padding-top: 93.2rem">X</p>
            @elseif ($RiskPerTutor == \App\Enums\RisksTutor::Jobless->value)
                <p style="position: absolute; padding-left: 53.2rem; padding-top: 93.2rem">X</p>
            @endif
        @endforeach



        @php
            $ChildRisk = $child->risks_child;
        @endphp

        @foreach ($ChildRisk as $RiskPerChild)
            @if ($RiskPerChild == \App\Enums\RisksChild::DoesNotGoToSchool->value)
                <p style="position: absolute; padding-left: 4.5rem; padding-top: 88rem">X</p>
            @elseif ($RiskPerChild == \App\Enums\RisksChild::IsAloneAtHome->value)
                <p style="position: absolute; padding-left: 20.1rem; padding-top: 88rem">X</p>
            @elseif ($RiskPerChild == \App\Enums\RisksChild::Works->value)
                <p style="position: absolute; padding-left: 36.6rem; padding-top: 88rem">X</p>
            @elseif ($RiskPerChild == \App\Enums\RisksChild::TakesCareOfSiblings->value)
                <p style="position: absolute; padding-left: 53.2rem; padding-top: 88rem">X</p>
            @elseif ($RiskPerChild == \App\Enums\RisksChild::HasADangerousJob->value)
                <p style="position: absolute; padding-left: 4.5rem; padding-top: 89.9rem">X</p>
            @elseif ($RiskPerChild == \App\Enums\RisksChild::CooksAline->value)
                <p style="position: absolute; padding-left: 20.1rem; padding-top: 89.9rem">X</p>
            @endif
        @endforeach






        <img style="z-index: -1; position: relative" src="{{ public_path('/images/sheet/3.jpg') }}" height="1120">
    </div>


    <div style="page-break-after: always"></div>





    {{-- HOJA 4 --}}
    <div style="position: absolute; z-index: 2;">



        @php
            $paddingTop = 15.6;
        @endphp

        @foreach ($child->family_nucleus->family_members->take(6) as $index => $familyMember)
            <div style="position: relative; width: 100%;">
                <div style="position: absolute; left: 4.1rem; padding-top: {{ $paddingTop }}rem;">
                    <p style="margin: 0;">
                        {{ $familyMember->name }}
                    </p>
                </div>

                <div style="position: absolute; left: 9.2rem; padding-top: {{ $paddingTop }}rem;">
                    <p style="margin: 0;">
                        {{ $familyMember->last_name }}
                    </p>
                </div>

                <div style="position: absolute; left: 19.2rem; padding-top: {{ $paddingTop }}rem;">
                    <p style="margin: 0;">
                        {{ $familyMember->birthdate->format('d/m/Y') }}
                    </p>
                </div>

                <div style="position: absolute; left: 32.4rem; padding-top: {{ $paddingTop }}rem;">
                    <p style="margin: 0;">
                        {{ $familyMember->gender->getLabel() }}
                    </p>
                </div>

                <div style="position: absolute; left: 40.8rem; padding-top: {{ $paddingTop }}rem;">
                    <p style="margin: 0;">
                        {{ $familyMember->relationship->getLabel() }}
                    </p>
                </div>

                <div style="position: absolute; left: 57.2rem; padding-top: {{ $paddingTop }}rem;">
                    <p style="margin: 0;">
                        {{ $familyMember->education_level }}
                    </p>
                </div>
            </div>

            @php
                $paddingTop += 1.7;
            @endphp
        @endforeach

        <p style="position: absolute; padding-left: 23.8rem; padding-top: 57rem; white-space: nowrap;">
            {{ $child->name . ' ' . $child->last_name }}
        </p>

        @php
            $upOffset = 0;
        @endphp

        @foreach ($tutors as $tutor)
            <p
                style="position: absolute; padding-left: 31rem; padding-top: {{ 59.1 + $upOffset }}rem; white-space: nowrap;">
                {{ $tutor?->name }}
            </p>

            <p style="position: absolute; padding-top: {{ 61.2 + $upOffset }}rem;">
                @php
                    $accountNumberDigits = str_split($tutor?->dni);
                    $leftOffset = 51;
                @endphp

                @foreach ($accountNumberDigits as $digit)
                    <span style="position: absolute; left: {{ $leftOffset }}rem;">
                        {{ $digit }}
                    </span>

                    @php
                        $leftOffset += 1.71;
                    @endphp
                @endforeach
            </p>

            @php
                $upOffset = 4.1;
            @endphp
        @endforeach

        <img style="z-index: -1; position: relative" src="{{ public_path('/images/sheet/4.jpg') }}" height="1120">
    </div>


</body>

</html>
