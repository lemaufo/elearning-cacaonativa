<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            background: #FAF7F2;
            width: 100%;
            height: 100%;
        }

        .page {
            width: 100%;
            height: 548px;
            background: #FAF7F2;
            position: relative;
            overflow: hidden;
        }

        /* Banda superior café */
        .header-band {
            background-color: #5C271A;
            width: 100%;
            height: 110px;
            position: relative;
            text-align: center;
            padding-top: 15px;
        }

        .header-band img {
            height: 70px;
            width: auto;
            display: inline-block;
        }

        .header-band-sub {
            font-size: 8px;
            color: #FBEBB8;
            letter-spacing: 4px;
            text-transform: uppercase;
            margin-top: 4px;
        }

        /* Bordes decorativos */
        .border-outer {
            position: absolute;
            top: 110px;
            left: 8px;
            right: 8px;
            bottom: 8px;
            border: 2px solid #7F5E43;
        }

        .border-inner {
            position: absolute;
            top: 116px;
            left: 14px;
            right: 14px;
            bottom: 14px;
            border: 1px solid #ACE7D3;
        }

        /* Esquinas */
        .corner {
            position: absolute;
            width: 35px;
            height: 35px;
            z-index: 10;
        }
        .c-tl { top: 118px; left: 18px; border-top: 3px solid #5C271A; border-left: 3px solid #5C271A; }
        .c-tr { top: 118px; right: 18px; border-top: 3px solid #5C271A; border-right: 3px solid #5C271A; }
        .c-bl { bottom: 18px; left: 18px; border-bottom: 3px solid #5C271A; border-left: 3px solid #5C271A; }
        .c-br { bottom: 18px; right: 18px; border-bottom: 3px solid #5C271A; border-right: 3px solid #5C271A; }

        /* Contenido */
        .content {
            position: relative;
            z-index: 5;
            text-align: center;
            padding: 18px 80px 0;
        }

        .title {
            font-size: 34px;
            font-weight: bold;
            color: #5C271A;
            letter-spacing: 4px;
            text-transform: uppercase;
            margin-bottom: 2px;
        }

        .divider-ornament {
            color: #7F5E43;
            font-size: 14px;
            letter-spacing: 10px;
            margin: 6px 0;
        }

        .divider-line {
            border: none;
            border-top: 1px solid #7F5E43;
            width: 55%;
            margin: 8px auto;
        }

        .granted-to {
            font-size: 11px;
            color: #7F5E43;
            font-style: italic;
            letter-spacing: 2px;
            margin-bottom: 4px;
        }

        .name {
            font-size: 24px;
            font-weight: bold;
            color: #1a1a1a;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 4px 0 8px;
        }

        .description {
            font-size: 11px;
            color: #555;
            font-style: italic;
            line-height: 1.6;
            margin-bottom: 3px;
        }

        .course-name {
            font-size: 15px;
            font-weight: bold;
            color: #1D483B;
            letter-spacing: 1px;
            margin: 3px 0 6px;
        }

        .meta {
            font-size: 10px;
            color: #7F5E43;
            font-style: italic;
            margin: 1px 0;
        }

        .meta strong {
            color: #5C271A;
            font-style: normal;
        }

        /* Firmas */
        .signatures {
            display: table;
            width: 100%;
            margin-top: 22px;
            padding: 0 60px;
        }

        .sig-col {
            display: table-cell;
            width: 35%;
            text-align: center;
            vertical-align: bottom;
            padding: 0 10px;
        }

        .sig-line {
            border-top: 1px solid #5C271A;
            padding-top: 5px;
            margin-top: 30px;
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

        .seal-col {
            display: table-cell;
            width: 30%;
            text-align: center;
            vertical-align: middle;
        }

        .seal-outer {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            border: 3px solid #7F5E43;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #FAF7F2;
        }

        .seal-inner {
            width: 58px;
            height: 58px;
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

        /* UUID */
        .uuid-section {
            position: absolute;
            bottom: 18px;
            left: 0;
            right: 0;
            text-align: center;
            z-index: 10;
        }

        .uuid-label {
            font-size: 7px;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .uuid-value {
            font-size: 8.5px;
            color: #7F5E43;
            font-family: 'DejaVu Sans Mono', monospace;
            letter-spacing: 1px;
            margin-top: 2px;
        }
    </style>
</head>
<body>
<div class="page">

    
    <div class="header-band">
        <img src="data:image/png;base64,<?php echo e($logoBase64); ?>" alt="Cacao Nativa">
        <p class="header-band-sub">Plataforma E-Learning Corporativa</p>
    </div>

    
    <div class="border-outer"></div>
    <div class="border-inner"></div>
    <div class="corner c-tl"></div>
    <div class="corner c-tr"></div>
    <div class="corner c-bl"></div>
    <div class="corner c-br"></div>

    
    <div class="content">
        <h1 class="title">Reconocimiento</h1>
        <div class="divider-ornament">— ✦ —</div>
        <hr class="divider-line">

        <p class="granted-to">Otorgado a</p>
        <p class="name"><?php echo e($certificate->user->name); ?></p>

        <p class="description">Por haber completado satisfactoriamente el curso:</p>
        <p class="course-name"><?php echo e($certificate->course->title); ?></p>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($certificate->course->area): ?>
            <p class="meta">Área: <strong><?php echo e($certificate->course->area); ?></strong></p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <p class="meta">Calificación: <strong><?php echo e($certificate->score); ?>%</strong> &nbsp;|&nbsp; <?php echo e($certificate->issued_at->translatedFormat('F Y')); ?></p>
    </div>

    
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

    
    <div class="uuid-section">
        <p class="uuid-label">ID de verificación</p>
        <p class="uuid-value"><?php echo e($certificate->uuid); ?></p>
    </div>

</div>
</body>
</html><?php /**PATH C:\Users\venta\Documents\DESARROLLOS\elerarning-cacaonativa\resources\views/pdf/certificate.blade.php ENDPATH**/ ?>