

<div <?php echo e($attributes->merge(['class' => 'flex items-center justify-center'])); ?>>
    
    <!-- Icono modo claro -->
    <img
        src="<?php echo e(asset('images/Logo Cacao Nativa.png')); ?>"
        alt="Cacao Nativa"
        class="h-full w-auto object-contain dark:hidden"
    >

    <!-- Icono modo oscuro -->
    <img
        src="<?php echo e(asset('images/Logo Blanco Cacao Nativa.png')); ?>"
        alt="Cacao Nativa"
        class="hidden h-full w-auto object-contain dark:block"
    >

</div>
<?php /**PATH C:\Users\venta\Documents\DESARROLLOS\elerarning-cacaonativa\resources\views/components/app-logo-icon.blade.php ENDPATH**/ ?>