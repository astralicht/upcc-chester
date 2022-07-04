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

function fadeInOut(element) {
    element.style.display = "block";
    setTimeout(() => {
        element.style.opacity = "1"
    }, 100);

    setTimeout(() => {
        element.style.opacity = "0"
        setTimeout(() => {
            element.style.display = "none";
        }, 150);
    }, 5000);
}

function fadeInOutFlex(element) {
    element.style.display = "flex";
    setTimeout(() => {
        element.style.opacity = "1"
    }, 100);

    setTimeout(() => {
        element.style.opacity = "0"
        setTimeout(() => {
            element.style.display = "none";
        }, 150);
    }, 5000);
}