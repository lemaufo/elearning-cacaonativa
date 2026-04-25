<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            background: #F5F0E8;
            color: #1a1a1a;
            width: 100%;
        }

        .certificate {
            width: 100%;
            min-height: 560px;
            padding: 30px 50px 50px 50px;
            background: #FAF7F2;
            position: relative;
        }

        /* Borde exterior */
        .border-outer {
            position: absolute;
            top: 8px; left: 8px; right: 8px; bottom: 8px;
            border: 2px solid #7F5E43;
        }

        /* Borde interior */
        .border-inner {
            position: absolute;
            top: 14px; left: 14px; right: 14px; bottom: 14px;
            border: 1px solid #7F5E43;
        }

        /* Esquinas decorativas */
        .corner {
            position: absolute;
            width: 40px;
            height: 40px;
            z-index: 10;
        }
        .corner-tl { top: 18px; left: 18px; border-top: 3px solid #5C271A; border-left: 3px solid #5C271A; }
        .corner-tr { top: 18px; right: 18px; border-top: 3px solid #5C271A; border-right: 3px solid #5C271A; }
        .corner-bl { bottom: 18px; left: 18px; border-bottom: 3px solid #5C271A; border-left: 3px solid #5C271A; }
        .corner-br { bottom: 18px; right: 18px; border-bottom: 3px solid #5C271A; border-right: 3px solid #5C271A; }

        .content {
            position: relative;
            z-index: 5;
            padding: 10px 30px;
        }

        /* Header */
        .header { text-align: center; margin-bottom: 16px; padding-top: 10px; }

        .logo-text {
            font-size: 22px;
            font-weight: bold;
            color: #5C271A;
            letter-spacing: 2px;
            font-style: italic;
        }

        .logo-sub {
            font-size: 9px;
            color: #7F5E43;
            letter-spacing: 4px;
            text-transform: uppercase;
            margin-top: 2px;
        }

        .divider-fancy {
            text-align: center;
            margin: 10px 0;
            color: #7F5E43;
            font-size: 16px;
            letter-spacing: 8px;
        }

        .title {
            font-size: 38px;
            font-weight: bold;
            color: #5C271A;
            text-align: center;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin: 6px 0;
        }

        .divider-line {
            border: none;
            border-top: 1px solid #7F5E43;
            margin: 10px auto;
            width: 60%;
        }

        /* Cuerpo */
        .body { text-align: center; margin: 10px 0; }

        .granted-to {
            font-size: 12px;
            color: #7F5E43;
            font-style: italic;
            letter-spacing: 1px;
        }

        .name {
            font-size: 26px;
            font-weight: bold;
            color: #1a1a1a;
            margin: 6px 0 10px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .description {
            font-size: 12px;
            color: #555;
            font-style: italic;
            margin: 0 0 4px;
            line-height: 1.6;
        }

        .course-name {
            font-size: 15px;
            font-weight: bold;
            color: #1D483B;
            margin: 4px 0 10px;
            letter-spacing: 1px;
        }

        .meta {
            font-size: 10px;
            color: #7F5E43;
            margin: 2px 0;
            font-style: italic;
        }

        .meta strong { color: #5C271A; font-style: normal; }

        /* Firmas */
        .signatures {
            display: table;
            width: 100%;
            margin-top: 30px;
        }

        .sig-col {
            display: table-cell;
            width: 38%;
            text-align: center;
            padding: 0 10px;
            vertical-align: bottom;
        }

        .sig-line {
            border-top: 1px solid #5C271A;
            padding-top: 5px;
            margin-top: 35px;
        }

        .sig-name {
            font-size: 10px;
            font-weight: bold;
            color: #1a1a1a;
        }

        .sig-role {
            font-size: 9px;
            color: #7F5E43;
            font-style: italic;
        }

        /* Sello central */
        .seal-col {
            display: table-cell;
            width: 24%;
            text-align: center;
            vertical-align: middle;
        }

        .seal-outer {
            width: 75px;
            height: 75px;
            border-radius: 50%;
            border: 3px solid #7F5E43;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #FAF7F2;
        }

        .seal-inner {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 1px solid #5C271A;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .seal-text {
            font-size: 7px;
            font-weight: bold;
            color: #5C271A;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            line-height: 1.8;
            text-align: center;
        }

        /* UUID footer */
        .uuid-footer {
            position: absolute;
            bottom: 22px;
            left: 50px;
            right: 50px;
            text-align: center;
            z-index: 10;
        }

        .uuid-label {
            font-size: 7px;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .uuid-value {
            font-size: 8px;
            color: #7F5E43;
            font-family: 'DejaVu Sans Mono', monospace;
            letter-spacing: 1px;
            margin-top: 2px;
            word-break: break-all;
        }
    </style>
</head>
<body>
<div class="certificate">

    {{-- Bordes decorativos --}}
    <div class="border-outer"></div>
    <div class="border-inner"></div>
    <div class="corner corner-tl"></div>
    <div class="corner corner-tr"></div>
    <div class="corner corner-bl"></div>
    <div class="corner corner-br"></div>

    <div class="content">

        {{-- Header --}}
        <div class="header">
            <p class="logo-text">Cacao Nativa<sup style="font-size:10px">®</sup></p>
            <p class="logo-sub">Plataforma E-Learning Corporativa</p>
            <div class="divider-fancy">— ✦ —</div>
            <h1 class="title">Reconocimiento</h1>
            <hr class="divider-line">
        </div>

        {{-- Cuerpo --}}
        <div class="body">
            <p class="granted-to">Otorgado a</p>
            <p class="name">{{ $certificate->user->name }}</p>

            <p class="description">
                Por haber completado satisfactoriamente el curso:
            </p>
            <p class="course-name">{{ $certificate->course->title }}</p>

            @if($certificate->course->area)
                <p class="meta">Área: <strong>{{ $certificate->course->area }}</strong></p>
            @endif
            <p class="meta">Calificación: <strong>{{ $certificate->score }}%</strong></p>
            <p class="meta" style="font-style:italic; margin-top:4px">
                {{ $certificate->issued_at->translatedFormat('F Y') }}
            </p>
        </div>

        {{-- Firmas --}}
        <div class="signatures">
            <div class="sig-col">
                <div class="sig-line">
                    <p class="sig-name">Lic. Mónica Arce Franco</p>
                    <p class="sig-role">Gerente General</p>
                </div>
            </div>

            <div class="seal-col">
                <div class="seal-outer">
                    <div class="seal-inner">
                        <p class="seal-text">Cacao<br>Nativa<br>——<br>E-Learning</p>
                    </div>
                </div>
            </div>

            <div class="sig-col">
                <div class="sig-line">
                    <p class="sig-name">Lic. Lidia Gómez Pérez</p>
                    <p class="sig-role">Gerente de Zona 1</p>
                </div>
            </div>
        </div>

    </div>

    {{-- UUID --}}
    <div class="uuid-footer">
        <p class="uuid-label">ID de verificación</p>
        <p class="uuid-value">{{ $certificate->uuid }}</p>
    </div>

</div>
</body>
</html>