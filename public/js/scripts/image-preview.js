class ImagePreview {
    constructor() {
        this.previewContainer = document.getElementById('imagePreview');
        this.fileInput = document.querySelector('input[type="file"][accept="image/*"]');
        this.maxFiles = 5;
        this.maxSize = 2 * 1024 * 1024;
        this.init();
    }

    init() {
        if (this.fileInput && this.previewContainer) {
            this.setupEventListeners();
        }
    }

    setupEventListeners() {
        this.fileInput.addEventListener('change', (e) => {
            this.handleFileSelection(e.target.files);
        });

        this.previewContainer.addEventListener('dragover', (e) => {
            e.preventDefault();
            this.previewContainer.classList.add('drag-over');
        });

        this.previewContainer.addEventListener('dragleave', () => {
            this.previewContainer.classList.remove('drag-over');
        });

        this.previewContainer.addEventListener('drop', (e) => {
            e.preventDefault();
            this.previewContainer.classList.remove('drag-over');
            this.handleFileSelection(e.dataTransfer.files);
        });
    }

    handleFileSelection(files) {
        const validFiles = Array.from(files).slice(0, this.maxFiles);

        if (!this.fileInput.multiple) {
            this.previewContainer.innerHTML = '';
        }

        validFiles.forEach(file => {
            if (this.validateFile(file)) {
                this.createPreview(file);
            }
        });
    }

    validateFile(file) {
        if (!file.type.startsWith('image/')) {
            this.showError('Можно загружать только изображения');
            return false;
        }

        if (file.size > this.maxSize) {
            this.showError(`Файл слишком большой. Максимальный размер: ${this.maxSize / 1024 / 1024}MB`);
            return false;
        }

        return true;
    }

    createPreview(file) {
        const reader = new FileReader();

        reader.onload = (e) => {
            const previewItem = document.createElement('div');
            previewItem.className = 'preview-item';
            previewItem.innerHTML = `
                <img src="${e.target.result}" alt="Preview" class="preview-image">
                <button type="button" class="preview-remove" aria-label="Удалить изображение">×</button>
            `;

            const removeBtn = previewItem.querySelector('.preview-remove');
            removeBtn.addEventListener('click', () => {
                previewItem.remove();
                this.updateFileInput();
            });

            this.previewContainer.appendChild(previewItem);
        };

        reader.readAsDataURL(file);
    }

    updateFileInput() {
    }

    showError(message) {
        alert(message);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new ImagePreview();
});
