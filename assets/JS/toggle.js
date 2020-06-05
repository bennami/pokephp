
//things we need from html
let pokeIcon = document.querySelector('.pokeIcon');
let pokeName = document.querySelector('.pokeName');
let pokeDescription = document.querySelector('.description');
let evolutionIcon = document.querySelector('.evolutionIcon');
let evolutionName = document.querySelector('.evolutionName');
let evolutionDiv = document.querySelector('.carouselEvolutions');
let descriptionDiv = document.querySelector('.Descriptionbox');
let movesDiv = document.querySelector('.movesList');

evolutionDiv.style.display = 'none';
movesDiv.style.display = 'none';

//search click event

//toggle through info with buttons
let descriptionCount = 0;
document.getElementById('nextbtn').addEventListener('click', function (
) {
    if(descriptionCount === 0){
        descriptionCount++;
        descriptionDiv.style.display = 'none';
        evolutionDiv.style.display = 'none';
        movesDiv.style.display = 'block';
    }else if(descriptionCount === 1){
        descriptionCount++;
        descriptionDiv.style.display = 'none';
        evolutionDiv.style.display = 'block';
        movesDiv.style.display = 'none';
    }else {
        descriptionCount = 0;
        descriptionDiv.style.display = 'block';
        evolutionDiv.style.display = 'none';
        movesDiv.style.display = 'none';
    }
});
document.getElementById('previousbtn').addEventListener('click', function (
) {
    if(descriptionCount === 0){
        descriptionCount= 2;
        descriptionDiv.style.display = 'none';
        evolutionDiv.style.display = 'block';
        movesDiv.style.display = 'none';
    }else if(descriptionCount === 2){
        descriptionCount--;
        descriptionDiv.style.display = 'none';
        evolutionDiv.style.display = 'none';
        movesDiv.style.display = 'block';
    }else {
        descriptionCount --;
        descriptionDiv.style.display = 'block';
        evolutionDiv.style.display = 'none';
        movesDiv.style.display = 'none';
    }
});


///////evolutions slider
let sliderImgs = document.querySelectorAll(".imgSlide");
let arrowRight =document.querySelector(".prev");
let arrowLeft =  document.querySelector(".next");
let current = 0;


//hide all images
function reset() {
    for(let i  = 0; i< sliderImgs.length;i++){
        sliderImgs[i].style.display="none"
    }
}

//call the reset, and only show first one
function startSlide() {
    //first you hide them all
    reset();
    //then, show the first image
    sliderImgs[0].style.display = 'block';
}

//show prev
function  slideLeft() {
    reset();
    sliderImgs[current -1].style.display ="block";
    current --;
}

//show next
function  slideRight() {
    reset();
    sliderImgs[current +1].style.display ="block";
    current ++;
}

arrowLeft.addEventListener("click", function () {
    if(current === 0){
        current =  sliderImgs.length;
    }
    slideLeft();
});

arrowRight.addEventListener("click", function () {
    if(current === sliderImgs.length -1){
        current = -1;
    }
    slideRight();
});

startSlide();

