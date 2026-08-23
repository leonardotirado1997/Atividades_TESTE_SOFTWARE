const tabs = document.querySelectorAll(".tab");
const forms = document.querySelectorAll(".form");
const message = document.getElementById("message");

let usuarios = [
  {
    nome: "Aluno QA",
    email: "aluno@uniandrade.com",
    senha: "123456"
  }
];

function mostrarMensagem(texto, tipo = "") {
  message.textContent = texto;
  message.className = "message " + tipo;
}

tabs.forEach(tab => {
  tab.addEventListener("click", () => {
    tabs.forEach(item => item.classList.remove("active"));
    forms.forEach(form => form.classList.remove("active"));

    tab.classList.add("active");
    document.getElementById(tab.dataset.target).classList.add("active");
    mostrarMensagem("");
  });
});

document.getElementById("login").addEventListener("submit", event => {
  event.preventDefault();

  const email = document.getElementById("loginEmail").value;
  const senha = document.getElementById("loginSenha").value;

  const usuario = usuarios.find(
    item => item.email === email && item.senha === senha
  );

  if (usuario) {
    mostrarMensagem("Login realizado com sucesso!", "success");
  } else {
    mostrarMensagem("E-mail ou senha inválidos.", "error");
  }
});

document.getElementById("cadastro").addEventListener("submit", event => {
  event.preventDefault();

  const nome = document.getElementById("nome").value;
  const email = document.getElementById("cadEmail").value;
  const senha = document.getElementById("cadSenha").value;
  const confirmacao = document.getElementById("confirmSenha").value;

  if (!nome || !email || !senha || !confirmacao) {
    mostrarMensagem("Preencha todos os campos.", "error");
    return;
  }

  if (senha !== confirmacao) {
    mostrarMensagem("As senhas não conferem.", "error");
    return;
  }

  if (usuarios.some(item => item.email === email)) {
    mostrarMensagem("Este e-mail já está cadastrado.", "error");
    return;
  }

  usuarios.push({ nome, email, senha });

  mostrarMensagem("Cadastro realizado com sucesso!", "success");
  event.target.reset();
});

document.getElementById("forgotPassword").addEventListener("click", () => {
  const email = document.getElementById("loginEmail").value;

  if (!email) {
    mostrarMensagem("Informe seu e-mail para recuperar a senha.", "error");
    return;
  }

  mostrarMensagem("Se o e-mail existir, enviaremos instruções de recuperação.", "success");
});
