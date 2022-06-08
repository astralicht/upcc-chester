function fadeIn(element) {
    element.style.display = "block";
    setTimeout(() => {
        element.style.opacity = "1"
    }, 100);
}

function fadeInFlex(element) {
    element.style.display = "flex";
    setTimeout(() => {
        element.style.opacity = "1"
    }, 100);
}

function fadeOut(element) {
    element.style.opacity = "0"
    setTimeout(() => {
        element.style.display = "none";
    }, 150);
}