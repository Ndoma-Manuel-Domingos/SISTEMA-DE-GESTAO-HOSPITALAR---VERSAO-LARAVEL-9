class Ajax {
    constructor() {
        this.csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    }

    async uploadAudio(data) {
        try {
            let response = await fetch("/consulta/audio/upload", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": this.csrf
                },
                body: data
            });
            if (!response.ok) {
                throw new Error(
                    "Falha no envio do áudio"
                );
            }
            return await response.json();
        } catch (error) {
            throw error;
        }
    }


    async saveTranscription(data) {
        let response = await fetch("/consulta/transcricao", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector(
                        'meta[name="csrf-token"]'
                    )
                    .content,
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        });
        return await response.json();
    }

}
