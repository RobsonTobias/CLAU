const buttonsComponent = document.querySelector('.buttons');
const buttonsToggle = document.querySelector('.buttons__toggle');

// Função para adicionar classe ativa
function addActiveClass() {
  buttonsToggle.classList.add('buttons__toggle--active');
  buttonsComponent.classList.add('buttons--active');
  document.activeElement.blur();
}

// Função para remover classe ativa
function removeActiveClass() {
  buttonsToggle.classList.remove('buttons__toggle--active');
  buttonsComponent.classList.remove('buttons--active');
}

// Abrir e fechar os icones de redes sociais
buttonsToggle.addEventListener('click', function(event) {
  event.stopPropagation(); // Impedir que o clique se propague para o documento
  if (buttonsToggle.classList.contains('buttons__toggle--active')) {
    removeActiveClass();
  } else {
    addActiveClass();
  }
});

// Fecha o os icones de redes sociais quando se clica em qualquer outra parte da página
document.addEventListener('click', function(event) {
  if (!buttonsComponent.contains(event.target)) {
    removeActiveClass();
  }
});