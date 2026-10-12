class AudioRecorder {
    constructor() {
        this.mediaStream = null;
        this.mediaRecorder = null;
        this.isRecording = false;
        this.mimeType = null;
        this.segmentTime = 10000; // 10 segundos
        this.segmentNumber = 1;
        this.audioQueue = [];
        this.onSegmentCreated = null;
        this.onError = null;
        this.onStatusChange = null;
    }

    /*Verificar suporte do navegador*/

    checkSupport() {
        if (!navigator.mediaDevices) {
            throw new Error(
                "Este navegador não suporta acesso ao microfone."
            );
        }
        if (!navigator.mediaDevices.getUserMedia) {
            throw new Error(
                "Microfone não disponível neste navegador."
            );
        }
        if (typeof MediaRecorder === "undefined") {
            throw new Error(
                "Gravação de áudio não suportada."
            );
        }
        return true;
    }

    /*Escolher formato de áudio*/

    getSupportedMimeType() {
        const formats = [
            "audio/webm;codecs=opus",
            "audio/webm",
            "audio/mp4",
            "audio/ogg"
        ];

        for (let format of formats) {
            if (MediaRecorder.isTypeSupported(format)) {
                return format;
            }
        }
        return "";
    }

    /*Abrir microfone*/


    async initialize() {
        try {
            this.checkSupport();
            this.mediaStream = await navigator.mediaDevices.getUserMedia({
                audio: {
                    echoCancellation: true,
                    noiseSuppression: true,
                    autoGainControl: true,
                    channelCount: 1
                }
            });

            this.mimeType = this.getSupportedMimeType();

            const options = {};

            if (this.mimeType) {
                options.mimeType = this.mimeType;
            }

            this.mediaRecorder = new MediaRecorder(
                this.mediaStream,
                options
            );

            this.registerEvents();

            this.changeStatus("Microfone preparado");
        } catch (error) {
            this.handleError(error);
        }
    }

    /*Eventos do MediaRecorder*/

    registerEvents() {
        this.mediaRecorder.onstart = () => {
            this.changeStatus("Gravação iniciada");
        };

        this.mediaRecorder.ondataavailable = async (event) => {
            if (event.data && event.data.size > 0) {
                const segment = await this.createSegment(
                    event.data
                );
                this.audioQueue.push(segment);
                if (this.onSegmentCreated) {
                    this.onSegmentCreated(segment);
                }
            }
        };

        this.mediaRecorder.onerror = (event) => {
            this.handleError(event.error);
        };

        this.mediaRecorder.onstop = () => {
            this.changeStatus("Gravação parada");
        };
    }

    /*Criar segmento*/
    async createSegment(blob) {
        const buffer = await blob.arrayBuffer();
        const hash = await this.generateHash(buffer);
        return {
            uuid: this.generateUUID(),
            number: this.segmentNumber++,
            blob: blob,
            size: blob.size,
            mime: this.mimeType,
            hash: hash,
            createdAt: new Date()
        };
    }

    /*Gerar UUID*/
    generateUUID() {
        if (crypto.randomUUID) {
            return crypto.randomUUID();
        }
        return Date.now() + "-" + Math.random().toString(36).substring(2);
    }

    /*Hash SHA-256*/

    async generateHash(buffer) {
        const hashBuffer = await crypto.subtle.digest("SHA-256", buffer);

        const hashArray = Array.from(
            new Uint8Array(hashBuffer)
        );
        return hashArray.map(byte => byte.toString(16).padStart(2, "0")).join("");
    }

    /*Iniciar gravação*/


    start() {
        if (this.isRecording) {
            return;
        }
        if (!this.mediaRecorder) {
            throw new Error(
                "Gravador não inicializado."
            );
        }
        this.mediaRecorder.start(
            this.segmentTime
        );

        this.isRecording = true;
        this.changeStatus("Gravando");
    }

    /*Parar gravação*/


    stop() {
        if (!this.isRecording) {
            return;
        }

        this.mediaRecorder.stop();
        this.isRecording = false;
        this.changeStatus("Parado");
    }

    /*Obter segmentos pendentes*/

    getQueue() {
        return this.audioQueue;
    }

    /*Limpar segmentos enviados*/

    removeSegment(uuid) {
        this.audioQueue = this.audioQueue.filter(item =>
            item.uuid !== uuid
        );
    }

    /*Estado*/
    changeStatus(message) {
        if (this.onStatusChange) {
            this.onStatusChange(
                message
            );
        }
    }

    /*Erros*/

    handleError(error) {
        console.error(
            error
        );

        if (this.onError) {
            this.onError(
                error.message
            );
        }
    }

    /*Fechar microfone*/

    destroy() {
        if (this.mediaStream) {
            this.mediaStream.getTracks().forEach(
                track => track.stop()
            );
        }

        this.mediaRecorder = null;
        this.mediaStream = null;
    }
}
