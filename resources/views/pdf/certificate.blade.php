<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            background: #ffffff;
            color: #1a1a1a;
            width: 100%;
            height: 100%;
        }

        .certificate {
            width: 100%;
            min-height: 540px;
            padding: 50px 70px;
            border: 12px solid #D97706;
            position: relative;
        }

        .corner {
            position: absolute;
            width: 60px;
            height: 60px;
            border-color: #92400E;
            border-style: solid;
        }
        .corner-tl { top: 10px; left: 10px; border-width: 3px 0 0 3px; }
        .corner-tr { top: 10px; right: 10px; border-width: 3px 3px 0 0; }
        .corner-bl { bottom: 10px; left: 10px; border-width: 0 0 3px 3px; }
        .corner-br { bottom: 10px; right: 10px; border-width: 0 3px 3px 0; }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .company {
            font-size: 13px;
            font-weight: bold;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #D97706;
        }

        .title {
            font-size: 36px;
            font-weight: bold;
            color: #1a1a1a;
            margin: 8px 0;
            letter-spacing: 1px;
        }

        .subtitle {
            font-size: 13px;
            color: #6b7280;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .divider {
            border: none;
            border-top: 1px solid #D97706;
            margin: 20px auto;
            width: 80%;
        }

        .body {
            text-align: center;
            margin: 20px 0;
        }

        .granted-to {
            font-size: 13px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .name {
            font-size: 32px;
            font-weight: bold;
            color: #1a1a1a;
            margin: 8px 0;
            border-bottom: 2px solid #D97706;
            display: inline-block;
            padding-bottom: 4px;
            min-width: 300px;
        }

        .description {
            font-size: 14px;
            color: #374151;
            margin: 16px 0 8px;
        }

        .course-name {
            font-size: 20px;
            font-weight: bold;
            color: #D97706;
            margin: 4px 0 16px;
        }

        .meta {
            font-size: 12px;
            color: #6b7280;
            margin: 4px 0;
        }

        .signatures {
            display: table;
            width: 100%;
            margin-top: 40px;
        }

        .sig-col {
            display: table-cell;
            width: 33%;
            text-align: center;
            padding: 0 20px;
            vertical-align: bottom;
        }

        .sig-line {
            border-top: 1px solid #374151;
            padding-top: 6px;
            margin-top: 40px;
        }

        .sig-name {
            font-size: 12px;
            font-weight: bold;
            color: #1a1a1a;
        }

        .sig-role {
            font-size: 11px;
            color: #6b7280;
        }

        .seal {
            display: table-cell;
            width: 33%;
            text-align: center;
            vertical-align: middle;
        }

        .seal-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 3px solid #D97706;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .seal-text {
            font-size: 9px;
            font-weight: bold;
            color: #D97706;
            text-transform: uppercase;
            letter-spacing: 1px;
            line-height: 1.4;
        }

        .uuid {
            position: absolute;
            bottom: 18px;
            right: 80px;
            font-size: 8px;
            color: #9ca3af;
        }
    </style>
</head>
<body>
<div class="certificate">
    <div class="corner corner-tl"></div>
    <div class="corner corner-tr"></div>
    <div class="corner corner-bl"></div>
    <div class="corner corner-br"></div>

    <div class="header">
        <p class="company">Cacao Nativa</p>
        <h1 class="title">Certificado de Aprobación</h1>
        <p class="subtitle">Plataforma E-Learning Corporativa</p>
    </div>

    <hr class="divider">

    <div class="body">
        <p class="granted-to">Se otorga a:</p>
        <p class="name">{{ $certificate->user->name }}</p>

        <p class="description">Por haber completado satisfactoriamente el curso:</p>
        <p class="course-name">{{ $certificate->course->title }}</p>

        @if($certificate->course->area)
            <p class="meta">Área: {{ $certificate->course->area }}</p>
        @endif

        <p class="meta">Calificación obtenida: <strong>{{ $certificate->score }}%</strong></p>
        <p class="meta">Fecha de emisión: {{ $certificate->issued_at->translatedFormat('d \d\e F \d\e Y') }}</p>
    </div>

    <div class="signatures">
        <div class="sig-col">
            <div class="sig-line">
                <p class="sig-name">Director de Operaciones</p>
                <p class="sig-role">Cacao Nativa</p>
            </div>
        </div>
        <div class="seal">
            <div class="seal-circle">
                <p class="seal-text">Cacao<br>Nativa<br>E-Learning</p>
            </div>
        </div>
        <div class="sig-col">
            <div class="sig-line">
                <p class="sig-name">Recursos Humanos</p>
                <p class="sig-role">Cacao Nativa</p>
            </div>
        </div>
    </div>

    <p class="uuid">ID: {{ $certificate->uuid }}</p>
</div>
</body>
</html>