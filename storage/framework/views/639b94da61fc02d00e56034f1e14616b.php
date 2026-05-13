<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @page {
            margin: 0;
            size: landscape;
        }

        body {
            margin: 0;
            padding: 0;
            width: 279.4mm;
            height: 215.9mm;
            overflow: hidden;
            font-family: 'Times New Roman', Times, Georgia, serif;
        }

        /* ── Logo top ── */
        div.logo-top {
            position: fixed;
            top: 18mm;
            /* Un poco más arriba como en la imagen 1 */
            left: 0;
            width: 279.4mm;
            text-align: center;
        }

        div.logo-top .brand-label {
            font-size: 18pt;
            /* Más grande y negrita */
            font-weight: bold;
            color: #63422E;
            /* Café oscuro cálido */
            letter-spacing: 0.5px;
            margin-top: -2mm;
        }

        /* ── Cuerpo ── */
        div.cert-body {
            position: fixed;
            top: 68mm;
            /* Ajustado para centrar mejor el bloque de texto */
            left: 15mm;
            width: 249.4mm;
            text-align: center;
        }

        .title {
            font-size: 58pt;
            /* Aumentado ligeramente */
            font-weight: bold;
            color: #63422E;
            /* Color café coherente */
            letter-spacing: 4px;
            text-transform: uppercase;
            line-height: 1;
            margin-bottom: 2mm;
        }

        /* Quitamos el divider según la imagen 1 */
        .divider {
            display: none;
        }

        .otorgado {
            font-size: 18pt;
            font-style: italic;
            color: #2D1A12;
            /* Casi negro para contraste */
            margin-bottom: 5mm;
        }

        .recipient {
            font-size: 38pt;
            /* Mucho más grande como en la imagen 1 */
            font-weight: bold;
            color: #1A1A1A;
            /* Negro suave para que resalte */
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 6mm;
        }

        .description {
            font-size: 15pt;
            font-style: italic;
            color: #2D1A12;
            line-height: 1.4;
            margin-bottom: 6mm;
        }

        .date {
            font-size: 18pt;
            font-style: normal;
            /* No itálica según imagen 1 */
            color: #63422E;
            font-weight: normal;
        }

        /* ── Firmas ── */
        div.signatures {
            position: fixed;
            top: 175mm;
            left: 15mm;
            width: 249.4mm;
            text-align: center;
        }

        table.sig-table {
            width: 100%;
            border-collapse: collapse;
        }

        table.sig-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 0 10mm;
        }

        .sig-line {
            width: 50mm;
            border: none;
            border-top: 2px solid #63422E;
            /* Línea más gruesa y café */
            margin: 0 auto 3mm auto;
        }

        .sig-name {
            font-size: 11pt;
            font-weight: bold;
            color: #1A1A1A;
            margin-bottom: 1mm;
        }

        .sig-role {
            font-size: 10pt;
            color: #63422E;
        }
    </style>
</head>

<body>

    <?php
        // $texturePath = 'file://' . public_path('images/fondo.png');
        // $selloPath = 'file://' . public_path('images/sello.png');
        // $certificadoPath = 'file://' . public_path('images/Logo Certificado.png');

        $meses = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre',
        ];

        $issuedAt = $certificate->issued_at instanceof \Carbon\Carbon
            ? $certificate->issued_at
            : \Carbon\Carbon::parse($certificate->issued_at);

        // Definición de las variables que causaban el error
        $fechaTexto = $issuedAt->day . ' de ' . $meses[$issuedAt->month] . ' de ' . $issuedAt->year;
        $userName = mb_strtoupper($certificate->user->name);
        $courseName = $certificate->course->title;
    ?>

    
    <div style="position: fixed; top: 0; left: 0; width: 279.4mm; height: 215.9mm; z-index: 0;">
        <img src="data:<?php echo e($fondoMime); ?>;base64,<?php echo e($fondoBase64); ?>" alt="" style="width: 279.4mm; height: 215.9mm; display: block;">
    </div>

    
    <div class="logo-top">
        <img src="data:<?php echo e($certificadoMime); ?>;base64,<?php echo e($certificadoBase64); ?>" alt="Cacao Nativa" style="width:70mm; height:auto;">
    </div>

    
    <div class="cert-body">
        <div class="title">RECONOCIMIENTO</div>
        <div class="otorgado">Otorgado a</div>
        <div class="recipient"><?php echo e($userName); ?></div>
        <div class="description">
            Por haber completado satisfactoriamente el curso:<br>
            <strong style="font-size: 17pt; color: #63422E; font-style: normal;"><?php echo e($courseName); ?></strong>
        </div>
        <div style="font-size: 13pt; color: #2D1A12; font-style: italic; margin-bottom: 4mm;">
            Calificación obtenida: <strong style="color: #63422E; font-style: normal;"><?php echo e($certificate->score); ?>%</strong>
        </div>
        <div class="date"><?php echo e($fechaTexto); ?></div>
    </div>

    
    <div style="position:fixed; top:108mm; left:15mm; z-index: 10;">
        <img src="data:<?php echo e($selloMime); ?>;base64,<?php echo e($selloBase64); ?>" alt="Sello oficial" style="width: 60mm; height:auto;">
    </div>

    
    <div class="signatures">
        <table class="sig-table" border="0">
            <tr>
                <td>
                    <hr class="sig-line">
                    <div class="sig-name">Lic. Mónica Arce Franco</div>
                    <div class="sig-role">Gerente General</div>
                </td>
                <td>
                    <hr class="sig-line">
                    <div class="sig-name">Lic. Lidia Gómez Pérez</div>
                    <div class="sig-role">Gerente de Zona 1</div>
                </td>
            </tr>
        </table>
    </div>

    
    <div style="position: fixed; bottom: 4mm; left: 0; width: 279.4mm; text-align: center; z-index: 20;">
        <p style="font-size: 6.5pt; color: #7F5E43; font-family: 'Courier New', monospace; letter-spacing: 0.8px;">
            ID de verificación: <?php echo e($certificate->uuid); ?>

        </p>
    </div>

</body>

</html><?php /**PATH C:\Users\venta\Documents\DESARROLLOS\elerarning-cacaonativa\resources\views/pdf/certificate.blade.php ENDPATH**/ ?>