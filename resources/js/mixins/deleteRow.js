const DeleteRow={
    data() {
        return {
            current_row: null,
            loading: true,
            delete_dialog: false,
            deleteConfirmLoading: false,
        }
    },
    methods: {
        confirmDelete(item) {
            this.current_row = item
            this.delete_dialog = true
        },
        cancelDelete() {
            this.delete_dialog = false
            this.current_row = null
        },
    }
}

export default DeleteRow