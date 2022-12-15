let front = document.getElementsByClassName('front');
function func1() {
    document.getElementsByClassName('front')[0].classList.toggle('rotate');
    document.getElementsByClassName('back')[0].classList.toggle('rotate2');
}

front[0].addEventListener( "click" , func1
);
let back = document.getElementsByClassName('back');
back[0].addEventListener( "click" , func1
);

let links = document.querySelectorAll('.no_click');
links.forEach((userItem) => {
    userItem.addEventListener("click", function(event){
        event.stopPropagation();
    });
});


function playSound() {
    greetings = document.createElement("audio");
    let sound = document.getElementById('sound');
    greetings.autoplay = true
    console.log(sound.value);
    greetings.src = sound.value;
}


let soundButton = document.getElementsByClassName('ll-sets-words__sound');

soundButton[0].addEventListener( "click" , playSound);
