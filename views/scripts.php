<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<script type="text/javascript" src="<?php echo $config['JS'] .'main.js'; ?>"></script>
<script type="text/javascript" src="<?php echo $config['JS'] .'filter.js'; ?>"></script>
<script type="text/javascript" src="<?php echo $config['JS'] .'validate.js'; ?>"></script>

<!-- Slick slider -->
<script>
$(document).ready(function() {
    $('.slider').slick({
        dots: true,
        infinite: true,
        speed: 500,
        // fade: true,
        cssEase: 'linear',
        delay: 3000,
        autoplay: true,
        arrows: true,
        prevArrow: "<button type='button' class='slick-prev pull-left'><i class='fa fa-angle-left' aria-hidden='true'></i></button>",
        nextArrow: "<button type='button' class='slick-next pull-right'><i class='fa fa-angle-right' aria-hidden='true'></i></button>"
    });
});

// $(document).ready(function() {
//     $('.box-sub-img').slick({
//         dots: true,
//         infinite: true,
//         speed: 500,
//         // fade: true,
//         cssEase: 'linear',
//         delay: 3000,
//         autoplay: true,
//         arrows: true,
//         prevArrow: "<button type='button' class='slick-prev pull-left'><i class='fa fa-angle-left' aria-hidden='true'></i></button>",
//         nextArrow: "<button type='button' class='slick-next pull-right'><i class='fa fa-angle-right' aria-hidden='true'></i></button>"
//     });
// });


function changeImage(e) {
    let thisImageSrc = e.querySelector('img')
    let ProductShowing = document.getElementById('ProductShowing')
    const saveSrc = ProductShowing.src
    ProductShowing.src = thisImageSrc.src
    thisImageSrc.src = saveSrc

    const boxImg = document.querySelectorAll('.box-sub-img .box-img')
    for (let i = 0; i < boxImg.length; i++) {
        boxImg[i].classList.remove('active')
    }
    e.classList.toggle('active')
}
</script>