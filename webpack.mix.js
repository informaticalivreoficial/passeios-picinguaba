const mix = require('laravel-mix');

mix
 //WEB
 .styles([
     'resources/views/web/css/bootstrap.min.css'
 ], 'public/frontend/assets/css/bootstrap.min.css') 
 
 .styles([
     'resources/views/web/css/owl.carousel.min.css'
 ], 'public/frontend/assets/css/owl.carousel.min.css') 

 .styles([
     'resources/views/web/css/flaticon.css'
 ], 'public/frontend/assets/css/flaticon.css') 

 .styles([
     'resources/views/web/css/slicknav.css'
 ], 'public/frontend/assets/css/slicknav.css') 

 .styles([
     'resources/views/web/css/animate.min.css'
 ], 'public/frontend/assets/css/animate.min.css') 

 .styles([
     'resources/views/web/css/magnific-popup.css'
 ], 'public/frontend/assets/css/magnific-popup.css') 

 .styles([
     'resources/views/web/css/fontawesome-all.min.css'
 ], 'public/frontend/assets/css/fontawesome-all.min.css') 

 .styles([
     'resources/views/web/css/themify-icons.css'
 ], 'public/frontend/assets/css/themify-icons.css') 

 .styles([
     'resources/views/web/css/slick.css'
 ], 'public/frontend/assets/css/slick.css') 

 .styles([
     'resources/views/web/css/nice-select.css'
 ], 'public/frontend/assets/css/nice-select.css') 

 .styles([
     'resources/views/web/css/style.css'
 ], 'public/frontend/assets/css/style.css') 
  
.copyDirectory('resources/views/web/fonts','public/frontend/assets/fonts')
.copyDirectory('resources/views/web/images','public/frontend/assets/images')

.scripts([
    'resources/views/web/js/vendor/modernizr-3.5.0.min.js'
], 'public/frontend/assets/js/vendor/modernizr-3.5.0.min.js')

.scripts([
    'resources/views/web/js/vendor/jquery-1.12.4.min.js'
], 'public/frontend/assets/js/vendor/jquery-1.12.4.min.js')
 
.scripts([
    'resources/views/web/js/popper.min.js'
], 'public/frontend/assets/js/popper.min.js')
 
.scripts([
    'resources/views/web/js/bootstrap.min.js'
], 'public/frontend/assets/js/bootstrap.min.js')
 
.scripts([
    'resources/views/web/js/jquery.slicknav.min.js'
], 'public/frontend/assets/js/jquery.slicknav.min.js')
 
.scripts([
    'resources/views/web/js/owl.carousel.min.js'
], 'public/frontend/assets/js/owl.carousel.min.js')
 
.scripts([
    'resources/views/web/js/slick.min.js'
], 'public/frontend/assets/js/slick.min.js')
 
.scripts([
    'resources/views/web/js/wow.min.js'
], 'public/frontend/assets/js/wow.min.js')
 
.scripts([
    'resources/views/web/js/animated.headline.js'
], 'public/frontend/assets/js/animated.headline.js')
 
.scripts([
    'resources/views/web/js/jquery.magnific-popup.js'
], 'public/frontend/assets/js/jquery.magnific-popup.js')
 
.scripts([
    'resources/views/web/js/jquery.scrollUp.min.js'
], 'public/frontend/assets/js/jquery.scrollUp.min.js')
 
.scripts([
    'resources/views/web/js/jquery.nice-select.min.js'
], 'public/frontend/assets/js/jquery.nice-select.min.js')
 
.scripts([
    'resources/views/web/js/jquery.sticky.js'
], 'public/frontend/assets/js/jquery.sticky.js')
 
.scripts([
    'resources/views/web/js/plugins.js'
], 'public/frontend/assets/js/plugins.js')
 
.scripts([
    'resources/views/web/js/main.js'
], 'public/frontend/assets/js/main.js')
 
 .options({
     processCssUrls: false
 })
 
 .version()
     
;