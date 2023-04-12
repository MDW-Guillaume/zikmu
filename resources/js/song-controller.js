let pauseBtn = document.getElementById('playerPause')
let resumeBtn = document.getElementById('playerPlay')
var player = document.getElementById("audioplayer"); // Get audio element

// Player pause

pauseBtn.addEventListener('click', function(){
    player.pause()
    pauseBtn.style.display = 'none'
    resumeBtn.style.display = 'block'
})

// Player resume
var player = document.getElementById("audioplayer"); // Get audio element

resumeBtn.addEventListener('click', function(){
    player.play()
    pauseBtn.style.display = 'block'
    resumeBtn.style.display = 'none'
})

