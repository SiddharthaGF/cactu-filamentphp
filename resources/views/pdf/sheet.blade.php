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

        <p style="position: absolute; padding-right: 19.4rem; right: 0; padding-top: 28.5rem; white-space: nowrap;">
            {{ $child->last_name }}
        </p>



        <p style="position: absolute; padding-left: 20.3rem; padding-top: 30.6rem; white-space: nowrap;">
            {{ $child->pseudonym }}</p>
        @php
            $date = $child->birthdate->format('d/m/Y');
        @endphp

        @if ($child->sexual_identity == \App\Enums\SexualIdentity::Girl)
            <p style="position: absolute; padding-left: 54.0rem; padding-top: 30.7rem">X</p>
        @elseif ($child->sexual_identity == \App\Enums\SexualIdentity::Boy)
            <p style="position: absolute; padding-left: 43.5rem; padding-top: 30.7rem">X</p>
        @else
            <p style="position: absolute; padding-left: 64.2rem; padding-top: 30.7rem">X</p>
        @endif

        @if ($child->gender == \App\Enums\Gender::Female)
            <p style="position: absolute; padding-left: 43.5rem; padding-top: 32.1rem">X</p>
        @elseif ($child->gender == \App\Enums\Gender::Male)
            <p style="position: absolute; padding-left: 54.0rem; padding-top: 32.1rem">X</p>
        @else
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
        @endphp
        <p style="position: absolute; padding-right: 9.6rem; right: 0; padding-top: 34.1rem; white-space: nowrap;">
            {{ $community->zone->city->state->name }}</p>

        <p style="position: absolute; padding-left: 9.8em; padding-top: 36.3rem; white-space: nowrap;">
            {{ $community->zone->city->name }}</p>

        <p style="position: absolute; padding-left: 19.7rem; padding-top: 38.4rem; white-space: nowrap;">
            {{ $community->name }}</p>

        <p style="position: absolute; padding-left: 43.7rem; padding-top: 36.3rem; white-space: nowrap;">
            {{ $community->zone->name }}</p>

        <p style="position: absolute; padding-left: 43.7rem; padding-top: 38.4rem; white-space: nowrap;">
            {{ $child->family_nucleus->house->neighborhood }}</p>





        @if ($child->family_nucleus->house->territory == \App\Enums\Location::Urban)
            <p style="position: absolute; padding-left: 20.1rem; padding-top: 40.5rem;">X</p>
        @elseif ($child->family_nucleus->house->territory == \App\Enums\Location::Periurban)
            <p style="position: absolute; padding-left: 26.1rem padding-top: 40.5rem;">X</p>
        @elseif ($child->family_nucleus->house->territory == \App\Enums\Location::Rural)
            <p style="position: absolute; padding-left: 34rem; padding-top: 40.5rem;">X</p>
        @else
            <p style="position: absolute; padding-left: 39rem; padding-top: 40.5rem;">X</p>
        @endif



        @php
            $latitude = $child->family_nucleus->house->latitud;
        @endphp

        <p style="position: absolute; padding-left: 26.7rem; padding-top: 42.6rem; white-space: nowrap;">
            {{ $latitude }}</p>


        @php
            $longitude = $child->family_nucleus->house->longitude;
        @endphp

        <p style="position: absolute; padding-left: 53.7rem; padding-top: 42.6rem; white-space: nowrap;">
            {{ $longitude }}</p>







        <p style="position: absolute; padding-left: 53.7rem; padding-top: 42.6rem; white-space: nowrap;">
            {{ $child->family_nucleus->house->tutor }}</p>


        <p style="position: absolute; padding-left: 23.7rem; padding-top: 52.6rem; white-space: nowrap;">
            {{ $child->family_nucleus->house->family_nucleus->conventional_phone }}</p>

        <p style="position: absolute; padding-left: 23.7rem; padding-top: 52.6rem; white-space: nowrap;">
            {{ $child->family_nucleus->house->walls }}</p>


        <p style="position: absolute; padding-left: 53.7rem; padding-top: 60.3rem; white-space: nowrap;">
            {{ $child->religious }}</p>



        <img style="z-index: -1; position: absolute" src="{{ public_path('/images/sheet/1.jpg') }}" height="1120">

    </div>


    <div style="page-break-after: always"></div>


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


        <p style="position: absolute; padding-left: 53.7rem; padding-top: 10.3rem; white-space: nowrap;">
            {{ $child->last_name }}</p>



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

        {{-- @php
        for ($i = 0; $i < count($child->activities_for_family_support); $i++)
            echo $child->activities_for_family_support[$i].",";
        @endphp --}}


        {{-- @php
            $activities = $child->activities_for_family_support;

            foreach ($activities as $activity) {
                if ($activity == 1) {
                    echo '<p style="position: absolute; padding-left: 4.5rem; padding-top: 19.1rem; background-color: red">YYx</p>';
                    echo $activity . ',';
                }

            }
        @endphp --}}


        @php
            $activities = $child->activities_for_family_support;
        @endphp

        @foreach ($activities as $activity)
            @if ($activity == \App\Enums\ActivityForFamilySupport::Washes)
                <p style="position: absolute; padding-left: 4.5rem; padding-top: 19.1rem; background-color: green">yyxx
                </p>
            @elseif ($activity == \App\Enums\ActivityForFamilySupport::BringsFirewood)
                <p style="position: absolute; padding-left: 20.2rem; padding-top: 19.1rem;">xxX</p>
            @elseif ($activity == \App\Enums\ActivityForFamilySupport::BringsWater)
                <p style="position: absolute; padding-left: 27rem; padding-top: 19.1rem;">Xxx</p>
            @elseif ($activity == \App\Enums\ActivityForFamilySupport::TakesCareOfAnimals)
                <p style="position: absolute; padding-left: 12.5rem; padding-top: 19.1rem;">Xxx</p>
            @elseif ($activity == \App\Enums\ActivityForFamilySupport::Cooks)
                <p style="position: absolute; padding-left: 33.7rem; padding-top: 19.1rem;">xxX</p>
            @elseif ($activity == \App\Enums\ActivityForFamilySupport::HasDeBed)
                <p style="position: absolute; padding-left: 41.4rem; padding-top: 19.1rem;">X</p>
            @elseif ($activity == \App\Enums\ActivityForFamilySupport::DoesTheShopping)
                <p style="position: absolute; padding-left: 41.4rem; padding-top: 19.1rem;">X</p>
            @elseif ($activity == \App\Enums\ActivityForFamilySupport::CaresOfBrothersSisters)
                <p style="position: absolute; padding-left: 41.4rem; padding-top: 19.1rem;">X</p>
            @elseif ($activity == \App\Enums\ActivityForFamilySupport::CleansTheHouse)
                <p style="position: absolute; padding-left: 41.4rem; padding-top: 19.1rem;">X</p>
            @elseif ($activity == \App\Enums\ActivityForFamilySupport::RunsErrands)
                <p style="position: absolute; padding-left: 41.4rem; padding-top: 19.1rem;">X</p>
            @elseif ($activity == \App\Enums\ActivityForFamilySupport::GathersGrassForAnimals)
                <p style="position: absolute; padding-left: 41.4rem; padding-top: 19.1rem;">X</p>
            @endif
        @endforeach


        <p style="position: absolute; padding-left: 20.2rem; padding-top: 49.6rem; white-space: nowrap;">

            {{ $child->physical_description }}
        </p>







        <img style="z-index: -1; position: absolute" src="{{ public_path('/images/sheet/2.jpg') }}" height="1120">
    </div>


    <div style="page-break-after: always"></div>


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


        <p style="position: absolute; padding-left: 53.7rem; padding-top: 10.3rem; white-space: nowrap;">
            {{ $child->last_name }}</p>



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

        {{-- @php
        for ($i = 0; $i < count($child->activities_for_family_support); $i++)
            echo $child->activities_for_family_support[$i].",";
        @endphp --}}


        {{-- @php
            $activities = $child->activities_for_family_support;

            foreach ($activities as $activity) {
                if ($activity == 1) {
                    echo '<p style="position: absolute; padding-left: 4.5rem; padding-top: 19.1rem; background-color: red">YYx</p>';
                    echo $activity . ',';
                }

            }
        @endphp --}}


        @php
            $activities = $child->activities_for_family_support;
        @endphp

        @foreach ($activities as $activity)
            @if ($activity == \App\Enums\ActivityForFamilySupport::Washes)
                <p style="position: absolute; padding-left: 4.5rem; padding-top: 19.1rem; background-color: green">yyxx
                </p>
            @elseif ($activity == \App\Enums\ActivityForFamilySupport::BringsFirewood)
                <p style="position: absolute; padding-left: 20.2rem; padding-top: 19.1rem;">xxX</p>
            @elseif ($activity == \App\Enums\ActivityForFamilySupport::BringsWater)
                <p style="position: absolute; padding-left: 27rem; padding-top: 19.1rem;">Xxx</p>
            @elseif ($activity == \App\Enums\ActivityForFamilySupport::TakesCareOfAnimals)
                <p style="position: absolute; padding-left: 12.5rem; padding-top: 19.1rem;">Xxx</p>
            @elseif ($activity == \App\Enums\ActivityForFamilySupport::Cooks)
                <p style="position: absolute; padding-left: 33.7rem; padding-top: 19.1rem;">xxX</p>
            @elseif ($activity == \App\Enums\ActivityForFamilySupport::HasDeBed)
                <p style="position: absolute; padding-left: 41.4rem; padding-top: 19.1rem;">X</p>
            @elseif ($activity == \App\Enums\ActivityForFamilySupport::DoesTheShopping)
                <p style="position: absolute; padding-left: 41.4rem; padding-top: 19.1rem;">X</p>
            @elseif ($activity == \App\Enums\ActivityForFamilySupport::CaresOfBrothersSisters)
                <p style="position: absolute; padding-left: 41.4rem; padding-top: 19.1rem;">X</p>
            @elseif ($activity == \App\Enums\ActivityForFamilySupport::CleansTheHouse)
                <p style="position: absolute; padding-left: 41.4rem; padding-top: 19.1rem;">X</p>
            @elseif ($activity == \App\Enums\ActivityForFamilySupport::RunsErrands)
                <p style="position: absolute; padding-left: 41.4rem; padding-top: 19.1rem;">X</p>
            @elseif ($activity == \App\Enums\ActivityForFamilySupport::GathersGrassForAnimals)
                <p style="position: absolute; padding-left: 41.4rem; padding-top: 19.1rem;">X</p>
            @endif
        @endforeach



        <p
            style="position: absolute; padding-left: 53.7rem; padding-top: 42.6rem; white-space: nowrap;">
            {{ $child->family_nucleus->house->tutors }}</p>







        <img style="z-index: -1; position: relative" src="{{ public_path('/images/sheet/3.jpg') }}" height="1120">
    </div>


    <div style="page-break-after: always"></div>


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


        <p style="position: absolute; padding-left: 53.7rem; padding-top: 10.3rem; white-space: nowrap;">
            {{ $child->last_name }}</p>



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

        {{-- @php
        for ($i = 0; $i < count($child->activities_for_family_support); $i++)
            echo $child->activities_for_family_support[$i].",";
        @endphp --}}


        {{-- @php
            $activities = $child->activities_for_family_support;

            foreach ($activities as $activity) {
                if ($activity == 1) {
                    echo '<p style="position: absolute; padding-left: 4.5rem; padding-top: 19.1rem; background-color: red">YYx</p>';
                    echo $activity . ',';
                }

            }
        @endphp --}}


        @php
            $activities = $child->activities_for_family_support;
        @endphp

        @foreach ($activities as $activity)
            @if ($activity == \App\Enums\ActivityForFamilySupport::Washes)
                <p style="position: absolute; padding-left: 4.5rem; padding-top: 19.1rem; background-color: green">yyxx
                </p>
            @elseif ($activity == \App\Enums\ActivityForFamilySupport::BringsFirewood)
                <p style="position: absolute; padding-left: 20.2rem; padding-top: 19.1rem;">xxX</p>
            @elseif ($activity == \App\Enums\ActivityForFamilySupport::BringsWater)
                <p style="position: absolute; padding-left: 27rem; padding-top: 19.1rem;">Xxx</p>
            @elseif ($activity == \App\Enums\ActivityForFamilySupport::TakesCareOfAnimals)
                <p style="position: absolute; padding-left: 12.5rem; padding-top: 19.1rem;">Xxx</p>
            @elseif ($activity == \App\Enums\ActivityForFamilySupport::Cooks)
                <p style="position: absolute; padding-left: 33.7rem; padding-top: 19.1rem;">xxX</p>
            @elseif ($activity == \App\Enums\ActivityForFamilySupport::HasDeBed)
                <p style="position: absolute; padding-left: 41.4rem; padding-top: 19.1rem;">X</p>
            @elseif ($activity == \App\Enums\ActivityForFamilySupport::DoesTheShopping)
                <p style="position: absolute; padding-left: 41.4rem; padding-top: 19.1rem;">X</p>
            @elseif ($activity == \App\Enums\ActivityForFamilySupport::CaresOfBrothersSisters)
                <p style="position: absolute; padding-left: 41.4rem; padding-top: 19.1rem;">X</p>
            @elseif ($activity == \App\Enums\ActivityForFamilySupport::CleansTheHouse)
                <p style="position: absolute; padding-left: 41.4rem; padding-top: 19.1rem;">X</p>
            @elseif ($activity == \App\Enums\ActivityForFamilySupport::RunsErrands)
                <p style="position: absolute; padding-left: 41.4rem; padding-top: 19.1rem;">X</p>
            @elseif ($activity == \App\Enums\ActivityForFamilySupport::GathersGrassForAnimals)
                <p style="position: absolute; padding-left: 41.4rem; padding-top: 19.1rem;">X</p>
            @endif
        @endforeach


        <p style="position: absolute; padding-left: 20.2rem; padding-top: 49.6rem; white-space: nowrap;">

            {{ $child->physical_description }}
        </p>







        <img style="z-index: -1; position: relative" src="{{ public_path('/images/sheet/4.jpg') }}" height="1120">
    </div>



    {{-- <img style="position: relative" src="{{ public_path('/images/sheet/1.jpg') }}" height="1120"> --}}
    {{-- <img style="position: relative" src="{{ public_path('/images/sheet/2.jpg') }}" height="1120"> --}}
    {{-- <img style="position: relative" src="{{ public_path('/images/sheet/3.jpg') }}" height="1120"> --}}
    {{-- <img style="position: relative" src="{{ public_path('/images/sheet/4.jpg') }}" height="1120"> --}}

</body>

</html>
