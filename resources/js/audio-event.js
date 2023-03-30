// Sélectionnez la balise audio que vous souhaitez observer
const audio = document.querySelector('audio');
const bottomSidebar = document.querySelector('.bottom-sidebar');
console.log(bottomSidebar)

// Créer une instance de MutationObserver avec une fonction de rappel
const observer = new MutationObserver((mutationsList) => {
  for (const mutation of mutationsList) {
    if (mutation.type === 'attributes' && mutation.attributeName === 'src') {
      console.log('L\'attribut "src" de la balise audio a été modifié');
      // Mettre votre code ici pour réagir à la modification de l'attribut
      bottomSidebar.style.height = "auto"
    }
  }
});

// Configurer l'observer pour observer les modifications d'attribut de la balise audio
observer.observe(audio, { attributes: true });
