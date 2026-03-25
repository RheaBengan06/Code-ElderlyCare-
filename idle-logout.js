const idleLimit = 10 * 60 * 1000; 

let idleTime = 0;

function resetTimer() {
    idleTime = 0;
}

window.onload = resetTimer;
document.onmousemove = resetTimer;
document.onkeypress = resetTimer;
document.onscroll = resetTimer;
document.onclick = resetTimer;

setInterval(() => {
    idleTime += 1000;
    if (idleTime >= idleLimit) {
        alert("You have been inactive for 1 minute. You will be logged out automatically.");
        window.location.href = "/elderlycare/logout.php";
    }
}, 1000);


///<script src="/elderlycare/idle-logout.js"></script>