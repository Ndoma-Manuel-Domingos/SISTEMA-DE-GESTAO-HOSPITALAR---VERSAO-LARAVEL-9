let audioRecorder;
let uploader;
let speech;
let ajax;

// Elementos da página
const textarea = document.getElementById("queixa");
const consultaID = document.getElementById("consulta_id").value;

const btnGravar = document.getElementById("btnGravar");
const btnParar = document.getElementById("btnParar");

const estado = document.getElementById("estado");
const cronometro = document.getElementById("cronometro");
const microfone = document.getElementById("microfone");
const sync = document.getElementById("sync");
const internet = document.getElementById("internet");
const segmentos = document.getElementById("segmentos");
const uploadProgress = document.getElementById("uploadProgress");

let segundos = 0;
let timer = null;

// =============================
// Inicialização
// =============================
window.addEventListener("load", async () => {
    try {

        audioRecorder = new AudioRecorder();
        uploader = new AudioUploadManager();
        speech = new SpeechTranscriber();
        ajax = new Ajax();

        // Inicializa o transcritor
        speech.initialize();

        // -------------------------
        // Eventos do gravador
        // -------------------------
        audioRecorder.onStatusChange = function (status) {
            atualizarEstado(status);
        };

        audioRecorder.onError = function (erro) {
            alert(erro);
        };

        audioRecorder.onSegmentCreated = function (segment) {

            atualizarSegmentos(segment.number);

            console.log("Novo segmento:", segment);

            // Adiciona à fila de upload
            uploader.add(segment);

        };

        // -------------------------
        // Eventos da transcrição
        // -------------------------
        speech.onText = async function (data) {

            textarea.value = data.texto;
            textarea.scrollTop = textarea.scrollHeight;

            try {

                await ajax.saveTranscription({
                    consulta_id: consultaID,
                    texto: data.texto,
                    tipo: "paciente",
                    inicio_segundo: data.inicio,
                    fim_segundo: data.fim,
                    segmento_audio: null
                });

            } catch (e) {
                console.error("Erro ao gravar transcrição:", e);
            }

        };

        speech.onStatus = function (status) {
            console.log("Speech:", status);
        };

        // Inicializa o gravador
        await audioRecorder.initialize();

        textarea.focus();

        atualizarEstado("Pronto");
        atualizarMicrofone("🔴 Desligado");

    } catch (erro) {
        console.error(erro);
        console.error(erro);

        alert(erro.message);
        alert("Erro ao inicializar o gravador.");
    }
});

// =============================
// Cronómetro
// =============================
function iniciarCronometro() {

    segundos = 0;

    cronometro.innerHTML = "00:00:00";

    timer = setInterval(() => {

        segundos++;

        const h = Math.floor(segundos / 3600);
        const m = Math.floor((segundos % 3600) / 60);
        const s = segundos % 60;

        cronometro.innerHTML =
            String(h).padStart(2, "0") + ":" +
            String(m).padStart(2, "0") + ":" +
            String(s).padStart(2, "0");

    }, 1000);

}

function pararCronometro() {

    clearInterval(timer);
    timer = null;

}

// =============================
// Estado da Internet
// =============================
window.addEventListener("online", () => {
    internet.innerHTML = "🟢 Online";
    internet.style.color = "green";
});

window.addEventListener("offline", () => {
    internet.innerHTML = "🔴 Offline";
    internet.style.color = "red";
});

// =============================
// Atualização da Interface
// =============================
function atualizarEstado(texto) {
    estado.innerHTML = texto;
}

function atualizarMicrofone(texto) {
    microfone.innerHTML = texto;
}

function atualizarSync(texto, cor) {
    sync.innerHTML = texto;
    sync.style.color = cor;
}

function atualizarSegmentos(total) {
    segmentos.innerHTML = total;
}

function atualizarUpload(percent) {
    uploadProgress.style.width = percent + "%";
    uploadProgress.innerHTML = percent + "%";
}

// =============================
// Botão Gravar
// =============================
btnGravar.onclick = async function () {

    try {

        await audioRecorder.start();
        speech.start();

        iniciarCronometro();

        atualizarEstado("🎤 Gravando e transcrevendo");
        atualizarMicrofone("🟢 Ativo");

        btnGravar.disabled = true;
        btnParar.disabled = false;

        btnGravar.classList.add("gravando");

    } catch (erro) {

        alert(erro.message);

    }

};

// =============================
// Botão Parar
// =============================
btnParar.onclick = function () {

    audioRecorder.stop();
    speech.stop();

    pararCronometro();

    atualizarEstado("Consulta finalizada");
    atualizarMicrofone("🔴 Desligado");

    btnGravar.disabled = false;
    btnParar.disabled = true;

    btnGravar.classList.remove("gravando");

};
