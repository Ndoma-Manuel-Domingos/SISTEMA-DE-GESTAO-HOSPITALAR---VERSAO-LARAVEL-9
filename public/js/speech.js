class SpeechTranscriber {
    constructor() {
        this.recognition = null;
        this.isListening = false;
        this.finalText = "";
        this.onText = null;
        this.onError = null;
        this.onStatus = null;
        this.startTime = null;
    }

    /*Verificar suporte*/
    checkSupport() {
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;

        if (!SpeechRecognition) {
            throw new Error(
                "Este navegador não suporta reconhecimento de voz."
            );
        }
        return SpeechRecognition;
    }

    /*Inicializar*/
    initialize() {
        const SpeechRecognition = this.checkSupport();
        this.recognition = new SpeechRecognition();
        this.recognition.lang = "pt-AO";
        this.recognition.continuous = true;
        this.recognition.interimResults = true;
        this.registerEvents();
    }

    /*Eventos*/
    registerEvents() {
        this.recognition.onstart = () => {
            this.isListening = true;
            this.changeStatus("Transcrição ativa");
        };
        this.recognition.onend = () => {
            if (this.isListening) {
                this.recognition.start();
            }
        };

        this.recognition.onerror = (event) => {
            console.error(event);
            if (this.onError) {
                this.onError(event.error);
            }
        };

        this.recognition.onresult = (event) => {
            let interim = "";
            for (let i = event.resultIndex; i < event.results.length; i++) {
                let text = event.results[i][0].transcript;

                if (event.results[i].isFinal) {
                    this.finalText += text + " ";

                    if (this.onText) {
                        this.onText({
                            texto: this.finalText,
                            inicio: this.getTime(),
                            fim: this.getTime(),
                            momento: new Date()
                        });
                    }
                } else {
                    interim += text;
                }
            }
        };
    }

    getTime() {
        if (!this.startTime) {
            return 0;
        }
        return Math.floor((Date.now() - this.startTime) / 1000);
    }

    /*Iniciar*/
    start() {
        if (this.isListening) {
            return;
        }
        this.startTime = Date.now();
        this.finalText = "";
        this.recognition.start();
    }

    /*Parar*/
    stop() {
        this.isListening = false;
        if (this.recognition) {
            this.recognition.stop();
        }
    }

    /*Estado*/
    changeStatus(text) {
        if (this.onStatus) {
            this.onStatus(text);
        }
    }
}
