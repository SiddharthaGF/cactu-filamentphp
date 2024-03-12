<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $answer->mail->mailbox->child->dni . '-' . $answer->id }}</title>
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
            font-size: 14px
        }
    </style>
</head>

<body>


    <div style="position: absolute; z-index: 2;">
        @php
            $content = str_replace("\n\n", '<br>', $answer->content);
            $meses = [
                'Enero',
                'Febrero',
                'Marzo',
                'Abril',
                'Mayo',
                'Junio',
                'Julio',
                'Agosto',
                'Septiembre',
                'Octubre',
                'Noviembre',
                'Diciembre',
            ];
        @endphp
        <p style="width: 70%; margin: auto; margin-top: 4cm; padding-left: 6cm">
            Ecuador, {{ $answer->created_at->format('d') }} de {{ $meses[(int) $answer->created_at->format('m') - 1] }}
            del {{ $answer->created_at->format('Y') }}
        </p>
        <p style='text-align: justify; width: 65%; margin: auto; margin-top: 0.5cm; line-height: 0.5cm;'>
            {!! $content !!}
        </p>

        <picture>
            <img style="position: absolute; height: 6.2cm; padding: 5%; padding-left: 37.50%;"
                src="{{ $answer->mail->answers->first()->getMedia('answers')->first()->getUrl() }}">
        </picture>

    </div>

    <img style="position: relative" src="{{ public_path('/images/letters/marco2.jpg') }}" height="1122.5">
    <img style="position: relative; margin: 5%; top: 2.5%; width: 90%"
        src="{{ $answer->mail->mail->answers->first()->getMedia('answers')->first()->getUrl() }}">

</body>

</html>
