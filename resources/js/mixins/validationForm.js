export default {
    data: () => ({
        form: {},
        errors: {},
        loading: false
    }),

    methods: {
        hasErrors() {
            return Object.keys(this.errors).find(i => this.errors[i])
        },
        reset() {
            for (var field in this.form) {
              this.form[field] = ''
            }
        }
    }
}
