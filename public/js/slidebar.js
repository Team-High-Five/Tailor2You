let nextDom = document.getElementById('next');
let prevDom = document.getElementById('prev');

let sliderDom = document.querySelector('.slider');
let SliderDom = sliderDom.querySelector('.slider .list');
let thumbnailBorderDom = document.querySelector('.slider .thumbnail');
let thumbnailItemsDom = thumbnailBorderDom.querySelectorAll('.item');
let timeDom = document.querySelector('.slider .time');

let timeRunning = 3000;
let timeAutoNext = 7000;
let runTimeOut;
let runNextAuto;

// Update active thumbnail
function updateActiveThumbnail() {
    // Remove active class from all thumbnails
    thumbnailItemsDom.forEach(item => {
        item.classList.remove('active');
    });
    // Add active class to the first visible thumbnail
    let firstVisibleThumbnail = thumbnailBorderDom.querySelector('.item');
    if (firstVisibleThumbnail) {
        firstVisibleThumbnail.classList.add('active');
    }
}

nextDom.onclick = function () {
    showSlider('next');
}

prevDom.onclick = function () {
    showSlider('prev');
}

function showSlider(type) {
    let SliderItemsDom = SliderDom.querySelectorAll('.list .item');
    let thumbnailItemsDom = document.querySelectorAll('.thumbnail .item');

    if (type === 'next') {
        // Move first item to the end
        SliderDom.appendChild(SliderItemsDom[0]);
        thumbnailBorderDom.appendChild(thumbnailItemsDom[0]);
        sliderDom.classList.add('next');
    } else {
        // Move last item to the beginning
        let lastSlideIndex = SliderItemsDom.length - 1;
        let lastThumbnailIndex = thumbnailItemsDom.length - 1;

        SliderDom.prepend(SliderItemsDom[lastSlideIndex]);
        thumbnailBorderDom.prepend(thumbnailItemsDom[lastThumbnailIndex]);
        sliderDom.classList.add('prev');
    }

    // Update active thumbnail after slide
    updateActiveThumbnail();

    clearTimeout(runTimeOut);
    runTimeOut = setTimeout(() => {
        sliderDom.classList.remove('next');
        sliderDom.classList.remove('prev');
    }, timeRunning);

    clearTimeout(runNextAuto);
    runNextAuto = setTimeout(() => {
        nextDom.click();
    }, timeAutoNext);
}

// Initialize active state
updateActiveThumbnail();

// Add click handlers for thumbnails
thumbnailItemsDom.forEach((item, index) => {
    item.onclick = function () {
        // Calculate how many slides to move
        let currentIndex = Array.from(thumbnailItemsDom).indexOf(thumbnailBorderDom.querySelector('.active'));
        let clickedIndex = Array.from(thumbnailItemsDom).indexOf(item);
        let slidesToMove = clickedIndex - currentIndex;

        // Move slides
        if (slidesToMove > 0) {
            for (let i = 0; i < slidesToMove; i++) {
                nextDom.click();
            }
        } else if (slidesToMove < 0) {
            for (let i = 0; i < Math.abs(slidesToMove); i++) {
                prevDom.click();
            }
        }
    }
});

// Auto slide functionality
runNextAuto = setTimeout(() => {
    nextDom.click();
}, timeAutoNext);