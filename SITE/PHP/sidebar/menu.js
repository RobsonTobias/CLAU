let arrow = document.querySelectorAll(".arrow");
for (var i = 0; i < arrow.length; i++) {
  arrow[i].addEventListener("click", (e)=>{
 let arrowParent = e.target.parentElement.parentElement;//selecting main parent of arrow
 arrowParent.classList.toggle("showMenu");
  });
}

let sidebar = document.querySelector(".sidebar");
let versionSpan = document.querySelector(".version span");

// Função para atualizar o conteúdo da versão
function updateVersionText(isLargeMenu) {
  if (isLargeMenu) {
    versionSpan.textContent = "Versão 1.0";
  } else {
    versionSpan.textContent = "v 1.0";
  }
}

// Adiciona um ouvinte de evento para o evento "mouseenter"
sidebar.addEventListener("mouseenter", () => {
  sidebar.classList.remove("close");
  updateVersionText(true); // Atualiza o conteúdo para "Versão 1.0"
});

// Adiciona um ouvinte de evento para o evento "mouseleave"
sidebar.addEventListener("mouseleave", () => {
  sidebar.classList.add("close");
  updateVersionText(false); // Atualiza o conteúdo para "v 1.0"
});

