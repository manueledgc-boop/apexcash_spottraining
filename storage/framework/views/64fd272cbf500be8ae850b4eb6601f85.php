<title><?php echo e($title ?? config('seo.title')); ?></title>

<meta name="description" content="<?php echo e($description ?? config('seo.description')); ?>">

<meta property="og:type" content="website">
<meta property="og:site_name" content="<?php echo e(config('seo.site_name')); ?>">
<meta property="og:title" content="<?php echo e($title ?? config('seo.title')); ?>">
<meta property="og:description" content="<?php echo e($description ?? config('seo.description')); ?>">
<meta property="og:image" content="<?php echo e(asset($image ?? config('seo.image'))); ?>">
<meta property="og:url" content="<?php echo e(url()->current()); ?>">

<meta name="twitter:card" content="<?php echo e(config('seo.twitter_card')); ?>">
<meta name="twitter:title" content="<?php echo e($title ?? config('seo.title')); ?>">
<meta name="twitter:description" content="<?php echo e($description ?? config('seo.description')); ?>">
<meta name="twitter:image" content="<?php echo e(asset($image ?? config('seo.image'))); ?>"><?php /**PATH C:\laragon\www\apexcash\resources\views/partials/seo.blade.php ENDPATH**/ ?>