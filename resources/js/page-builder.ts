interface Block {
    // Define the structure of a block object if needed
}

interface PageBuilderData {
    blocks: Block[];
    init(): void;
    handleDrop(event: DragEvent): void;
    handleDragOver(event: DragEvent): void;
    handleDragLeave(event: DragEvent): void;
}

document.addEventListener('alpine:init', () => {
    Alpine.data('pageBuilder', (): PageBuilderData => ({
        blocks: [],

        init() {
            // Initialize any necessary data or perform any setup tasks
        },

        handleDrop(event: DragEvent) {
            event.preventDefault();
            const data = event.dataTransfer?.getData('text/plain');
            if (data === 'block') {
                this.blocks.push(data);
            }
            (event.target as HTMLElement).classList.remove('bg-blue-100');
        },

        handleDragOver(event: DragEvent) {
            event.preventDefault();
            (event.target as HTMLElement).classList.add('bg-blue-100');
        },

        handleDragLeave(event: DragEvent) {
            (event.target as HTMLElement).classList.remove('bg-blue-100');
        },
    }));
});
