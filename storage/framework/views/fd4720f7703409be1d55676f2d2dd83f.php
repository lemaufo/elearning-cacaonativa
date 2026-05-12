<!DOCTYPE html>
<html lang="es" class="<?php echo e(Cookie::get('flux_appearance') === 'dark' ? 'dark' : ''); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cacao Nativa E-Learning</title>
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('favicon.ico')); ?>">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-white dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 font-sans antialiased relative">
    
    <div class="fixed inset-0 pointer-events-none" aria-hidden="true"
        style="
            background-image:
                linear-gradient(to right, rgba(82,39,26,0.06) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(72,29,16,0.06) 1px, transparent 1px);
            background-size: 40px 40px;
        ">
    </div>
    <div class="fixed inset-0 pointer-events-none dark:block hidden" aria-hidden="true"
        style="
            background-image:
                linear-gradient(to right, rgba(255,255,255,0.04) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255,255,255,0.04) 1px, transparent 1px);
            background-size: 40px 40px;
        ">
    </div>
    
    
    <nav class="sticky top-0 z-50 bg-white/90 dark:bg-zinc-950/90 backdrop-blur border-b border-zinc-200 dark:border-zinc-800">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-14 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-3">
                    <div class="flex aspect-square size-12 items-center justify-center rounded-md">
                        <?php if (isset($component)) { $__componentOriginal159d6670770cb479b1921cea6416c26c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal159d6670770cb479b1921cea6416c26c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-logo-icon','data' => ['class' => 'size-8 fill-current text-white']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-logo-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'size-8 fill-current text-white']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal159d6670770cb479b1921cea6416c26c)): ?>
<?php $attributes = $__attributesOriginal159d6670770cb479b1921cea6416c26c; ?>
<?php unset($__attributesOriginal159d6670770cb479b1921cea6416c26c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal159d6670770cb479b1921cea6416c26c)): ?>
<?php $component = $__componentOriginal159d6670770cb479b1921cea6416c26c; ?>
<?php unset($__componentOriginal159d6670770cb479b1921cea6416c26c); ?>
<?php endif; ?>
                    </div>
                    <div>
                        <p class="font-semibold text-sm leading-tight">Cacao Nativa</p>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 leading-tight">Plataforma E-Learning</p>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(url('/dashboard')); ?>"
                       class="px-4 py-2 rounded-lg text-sm font-medium text-white transition-colors"
                       style="background:#5C271A">
                        Ir al dashboard
                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>"
                       class="px-4 py-2 rounded-lg text-sm font-medium text-white transition-colors"
                       style="background:#5C271A">
                        Iniciar sesión
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </nav>

    
    <section class="max-w-6xl mx-auto px-4 sm:px-6 py-20 text-center">
        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border text-xs font-medium mb-6"
             style="background:#FAF0EB; border-color:#E8C5B5; color:#5C271A">
            <i class="ti ti-award" aria-hidden="true"></i>
            Plataforma corporativa de capacitación
        </div>
        <h1 class="text-4xl sm:text-5xl font-semibold leading-tight max-w-2xl mx-auto mb-5">
            Capacitación digital para tu equipo,
            <span style="color:#5C271A">en un solo lugar</span>
        </h1>
        <p class="text-zinc-500 dark:text-zinc-400 text-lg max-w-xl mx-auto mb-8 leading-relaxed">
            Gestiona cursos, evalúa competencias y emite certificados de forma automática. Todo bajo la identidad de Cacao Nativa.
        </p>
        <div class="flex items-center justify-center gap-3 flex-wrap">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(url('/dashboard')); ?>"
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-medium text-white transition-colors"
                   style="background:#5C271A">
                    Ir a la plataforma <i class="ti ti-arrow-right" aria-hidden="true"></i>
                </a>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>"
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-medium text-white transition-colors"
                   style="background:#5C271A">
                    Acceder a la plataforma <i class="ti ti-arrow-right" aria-hidden="true"></i>
                </a>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            
        </div>
    </section>

    
    

    
    <section class="max-w-6xl mx-auto px-4 sm:px-6 py-10">
        <p class="text-xs font-medium tracking-widest uppercase text-zinc-400 dark:text-zinc-500 mb-2">Funcionalidades</p>
        <h2 class="text-2xl font-semibold mb-10">Todo lo que necesitas para capacitar a tu equipo</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = [
                ['icon' => 'ti-book',           'bg' => '#FAF0EB', 'color' => '#5C271A', 'title' => 'Catálogo de cursos',       'desc' => 'Video, PDF, imágenes y texto. Contenido ilimitado organizado por área responsable.'],
                ['icon' => 'ti-clipboard-check', 'bg' => '#E8F0ED', 'color' => '#1D483B', 'title' => 'Evaluaciones automáticas', 'desc' => 'Exámenes con calificación mínima, límite de intentos y bloqueo automático.'],
                ['icon' => 'ti-certificate',    'bg' => '#E8EFF5', 'color' => '#18405D', 'title' => 'Certificados PDF',          'desc' => 'Emisión automática al aprobar, con sello institucional y validación por UUID.'],
                ['icon' => 'ti-chart-bar',      'bg' => '#F5EDE8', 'color' => '#7F5E43', 'title' => 'Dashboard ejecutivo',       'desc' => 'KPIs en tiempo real, seguimiento por colaborador y exportación de reportes.'],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div class="bg-white z-10 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-5">
                    <div class="w-9 h-9 rounded-lg flex items-center justify-center mb-4"
                         style="background:<?php echo e($feat['bg']); ?>">
                        <i class="ti <?php echo e($feat['icon']); ?> text-lg" style="color:<?php echo e($feat['color']); ?>" aria-hidden="true"></i>
                    </div>
                    <p class="font-medium text-sm mb-1"><?php echo e($feat['title']); ?></p>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400 leading-relaxed"><?php echo e($feat['desc']); ?></p>
                </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    </section>

    
    <section id="como-funciona" class="border-t border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900/50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-20">
            <p class="text-xs font-medium tracking-widest uppercase text-zinc-400 dark:text-zinc-500 mb-2">Flujo de trabajo</p>
            <h2 class="text-2xl font-semibold mb-10">De la creación a la certificación</h2>
            <div class="grid grid-cols-2 sm:grid-cols-5 gap-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = [
                    ['num' => '1', 'title' => 'Carga',        'sub' => 'Editor sube el contenido',    'active' => true],
                    ['num' => '2', 'title' => 'Revisión',      'sub' => 'Validación editorial',        'active' => false],
                    ['num' => '3', 'title' => 'Publicación',   'sub' => 'Admin aprueba el curso',      'active' => false],
                    ['num' => '4', 'title' => 'Capacitación',  'sub' => 'Colaborador aprende',         'active' => false],
                    ['num' => '5', 'title' => 'Certificado',   'sub' => 'Emisión automática PDF',      'active' => false],
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="text-center">
                        <div class="w-10 h-10 rounded-full mx-auto mb-3 flex items-center justify-center text-sm font-medium border
                            <?php echo e($step['active']
                                ? 'text-white border-transparent'
                                : 'text-zinc-500 dark:text-zinc-400 border-zinc-200 dark:border-zinc-700 bg-white z-100 dark:bg-zinc-900'); ?>"
                             style="<?php echo e($step['active'] ? 'background:#5C271A' : ''); ?>">
                            <?php echo e($step['num']); ?>

                        </div>
                        <p class="text-sm font-medium"><?php echo e($step['title']); ?></p>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1 leading-tight"><?php echo e($step['sub']); ?></p>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>
    </section>

    
    

    
    <section class="max-w-6xl mx-auto px-4 sm:px-6 pb-20">
        <div class="rounded-2xl p-10 text-center" style="background:#1D483B">
            <h2 class="text-2xl font-semibold mb-2" style="color:#ACE7D3">Listo para capacitar a tu equipo</h2>
            <p class="text-sm mb-6" style="color:#7FB8A8">Accede a la plataforma y comienza hoy mismo.</p>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(url('/dashboard')); ?>"
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-medium transition-colors z-50"
                   style="background:#FAF7F2; color:#1D483B">
                    Ir a la plataforma <i class="ti ti-arrow-right" aria-hidden="true"></i>
                </a>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>"
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-medium transition-colors z-50"
                   style="background:#FAF7F2; color:#1D483B">
                    Iniciar sesión <i class="ti ti-arrow-right" aria-hidden="true"></i>
                </a>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </section>

    
    <footer class="border-t border-zinc-200 dark:border-zinc-800 bg-white z-100 dark:bg-zinc-900">
        <div class="bg-white max-w-6xl mx-auto px-4 sm:px-6 py-5 flex items-center justify-between flex-wrap gap-3">
            <p class="text-xs text-zinc-400 dark:text-zinc-500">© <?php echo e(date('Y')); ?> Cacao Nativa · Todos los derechos reservados</p>
            <p class="text-xs text-zinc-400 dark:text-zinc-500">
                Desarrollado por <span class="font-medium" style="color:#5C271A">Teknologix</span>
            </p>
        </div>
    </footer>

</body>
</html><?php /**PATH C:\Users\venta\Documents\DESARROLLOS\elerarning-cacaonativa\resources\views/welcome.blade.php ENDPATH**/ ?>