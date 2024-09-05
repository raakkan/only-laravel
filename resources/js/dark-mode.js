document.addEventListener('alpine:init', () => {
    Alpine.store('darkMode', {

        on: Alpine.$persist(false).as('darkModeOn'),

        toggle() {
            this.on = !this.on
        },
        off() {
            this.on = false
        }
    })
}) 