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