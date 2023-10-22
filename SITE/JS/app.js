var btnLogin = document.querySelector("#login");
var btnCadastro = document.querySelector("#senha");

var body = document.querySelector("body");

btnCadastro.addEventListener("click", function() {
    body.className = "senha-js";
});

btnLogin.addEventListener("click", function() {
    body.className = "login-js";
});

// Lista de URLs das suas imagens de fundo
const imagensDeFundo = [
  'IMAGE/01.jpg',
  'IMAGE/02.jpg',
  'IMAGE/03.jpg',
  'IMAGE/04.jpg',
  'IMAGE/05.jpg',
  'IMAGE/06.jpg',
  'IMAGE/07.jpg',
// Adicione mais URLs de imagens conforme necessário
];

// Função para escolher uma imagem aleatória do array e aplicá-la como fundo
function alterarImagemDeFundo() {
  const indiceImagemAleatoria = Math.floor(Math.random() * imagensDeFundo.length);
  const urlImagemAleatoria = imagensDeFundo[indiceImagemAleatoria];
  document.body.style.backgroundImage = `linear-gradient(90deg, rgba(110,199,125,0.7) 0%, rgba(64,185,225,0.7) 100%),url(${urlImagemAleatoria})`;
}

// Chama a função para alterar a imagem de fundo quando a página é carregada
window.onload = alterarImagemDeFundo;