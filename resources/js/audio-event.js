// Sélectionnez la balise audio que vous souhaitez observer
const audio = document.getElementById("audioplayer")
const bottomSidebar = document.querySelector('.bottom-sidebar');
let trackTime = document.getElementById('musicDuration')
let timeSlider = document.getElementById('timeSlider')
let trackCurrentTime = document.getElementById('musicCurrentTime')
console.log(bottomSidebar)

// Créer une instance de MutationObserver avec une fonction de rappel
const observer = new MutationObserver((mutationsList) => {
    for (const mutation of mutationsList) {
        if (mutation.type === 'attributes' && mutation.attributeName === 'src' && audio.getAttribute('src')) {
            console.log('L\'attribut "src" de la balise audio a été modifié');
            // Mettre votre code ici pour réagir à la modification de l'attribut
            bottomSidebar.style.height = "auto"

            // Crée un format de retour avec minutes et secondes.
            function buildDuration(duration) {
                let minutes = Math.floor(duration / 60)
                let reste = duration % 60
                let secondes = Math.floor(reste)
                secondes = String(secondes).padStart(2, "0")
                return minutes + ":" + secondes
            }

            // Définit la position exacte de la lecture
            function setTrackCurrentTime(){
                let trackMaxTime = buildDuration(audio.currentTime)
                trackCurrentTime.textContent = trackMaxTime
            }

            // Définit l'attribut max dans le slider du lecteur
            function setTrackMaxTime(){
                trackTime.textContent = buildDuration(audio.duration)
                timeSlider.setAttribute('max', audio.duration)
            }

            // Permet de faire glisser le slider du temps de la musique
            function updateSlider(){
                let actualTime = audio.currentTime
                timeSlider.value = actualTime
            }

            // Joue le son à partir du temps séléctionné dans le slider
            function setSelectedTime(){
                let selectedTime = parseFloat(timeSlider.value)
                console.log(typeof(selectedTime))
                console.log(typeof(audio.currentTime))
                console.log(audio.currentTime)
                audio.currentTime = selectedTime
                // audio.currentTime = parseFloat(selectedTime.toFixed(6))
                console.log(typeof(parseFloat(selectedTime.toFixed(6))))
                console.log(parseFloat(selectedTime.toFixed(6)))
                console.log(audio.currentTime)
            }

            audio.addEventListener('loadeddata', function () {
                setTrackMaxTime()
                setInterval(updateSlider, 50);

            })

            audio.addEventListener('timeupdate', function(){
                setTrackCurrentTime()
            })

            timeSlider.addEventListener('change', function(){
                console.log('je passe dans le input')
                audio.pause()
                setSelectedTime()
                audio.play()
                audio.addEventListener('timeupdate', function(){
                    setTrackCurrentTime()
                })
            })


            // function timeTracker(seconds = -1) {
            //     console.log("seconds", seconds)
            //     timeSlider.getAttribute('max')
            //     console.log(audio.currentTime)
            //     if(typeof(seconds) == 'object'){
            //         console.log(' audio-event / je rentre dans l\'objet')
            //         console.log(timeSlider.value)
            //         timeSlider.value = audio.currentTime
            //     }else{
            //         console.log(seconds)
            //         timeSlider.value = seconds
            //         console.log(timeSlider.value)
            //         // debugger;
            //     }
            //     trackCurrentTime.textContent = buildDuration(audio.currentTime)
            // }

            // // audio.addEventListener('timeupdate', timeTracker)

            // // setInterval(timeTracker, 50);

            // timeSlider.addEventListener('input', function () {
            //     console.log('la')
            //     // console.log(this.value)
            //     let selectedTime = parseFloat(timeSlider.value)
            //     // console.log(typeof(audio.currentTime))
            //     audio.currentTime = 10;
            //     timeTracker(selectedTime);
            //     // console.log(audio.currentTime)
            // });

            // audio.addEventListener("ended", function(){console.log('Je coupe la')});
        }
    }
});

// Configurer l'observer pour observer les modifications d'attribut de la balise audio
observer.observe(audio, { attributes: true });
