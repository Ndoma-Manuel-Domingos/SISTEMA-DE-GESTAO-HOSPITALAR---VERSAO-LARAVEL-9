class AudioUploadManager {
    constructor() {
        this.ajax = new Ajax();
        this.queue = [];
        this.uploading = false;
        this.maxRetry = 5;
    }

    add(segment) {
        this.queue.push({
            data: segment,
            retry: 0
        });
        this.process();
    }

    async process() {
        if (this.uploading) {
            return;
        }

        if (this.queue.length === 0) {
            return;
        }
        this.uploading = true;

        let item = this.queue[0];

        try {
            await this.send(item.data);
            this.queue.shift();
        } catch (error) {
            item.retry++;
            console.error("Erro upload", error);

            if (item.retry >= this.maxRetry) {
                this.queue.shift();
                alert("Não foi possível guardar um segmento de áudio.");
            }
        }
        this.uploading = false;
        this.process();
    }

    async send(segment) {
        let form =
            new FormData();

        form.append("consulta_id", consultaID);
        form.append("segment", segment.number);
        form.append("uuid", segment.uuid);
        form.append("hash", segment.hash);
        form.append("mime", segment.mime);
        form.append("audio", segment.blob, "segment.webm");

        let result = await this.ajax.uploadAudio(
            form
        );

        if (result.success) {
            atualizarSync("✔ Áudio guardado", "green");
        }
    }
}
