new Vue({
    el: '#admin-dashboard',
    data: {
        selectedId: null,
        showModal: false,
        modalContent: [],
    },

    methods: {
        loadListData() {
            axios.get('/v1/api/admin/get-documents-request')
                .then(response => {
                    const data = response.data.data;
                    $('#adminDataTable tbody').empty();
                    data.forEach(rowData => {
                        $('#adminDataTable tbody').append(`<tr>
                            <td>${rowData.text}</td>
                            <td>${rowData.email}</td>
                            <td>${rowData.phone}</td>
                            <td>${rowData.address}</td>
                            <td>${rowData.address}</td>
                            <td>${rowData.created_at}</td>
                            <td>
                                <button onclick="document.getElementById('admin-dashboard').__vue__.handleActionButtonClick(${rowData.id})" class="action-button btn btn-secondary btn-sm" data-id="${rowData.id}">
                                    <i class="icon-copy fa fa-eye" aria-hidden="true"></i>
                                </button>
                            </td>
                        </tr>`);
                    });

                    $('#adminDataTable').DataTable();
                })
                .catch(error => {
                    console.error('Error loading data:', error);
                });
        },
        handleActionButtonClick(id) {
            this.selectedId = id;

            const formData = new FormData();
            formData.append('form_submission_id', this.selectedId);
            console.log('Sending form_submission_id:', this.selectedId);

            axios.post('/v1/api/admin/get-user-documents', formData)
                .then(response => {
                    this.modalContent = response.data.data.map(doc => ({
                        ...doc,
                        showDescription: false
                    }));
                    //this.modalContent = response.data.data;
                    console.log('Action successful:', this.modalContent);
                    this.showModal = true;
                })
                .catch(error => {
                    console.error('Error performing action:', error);
                });
        },
        approveDocument(document) {
            const formData = new FormData();
            formData.append('type', 'approve');
            formData.append('user_id', document.user_id);
            formData.append('id', document.id);

            axios.post('/v1/api/admin/action', formData)
                .then(response => {
                    console.log('Document approved:', response.data);
                    Swal.fire("Success", response.data.message, "success");
                    this.loadListData();
                    this.showModal = false;
                })
                .catch(error => {
                    console.error('Error approving document:', error);
                    Swal.fire("Error", error.message || "Failed to approve document", "error");
                });
        },

        rejectDocument(document) {
            const formData = new FormData();
            formData.append('type', 'reject');
            formData.append('user_id', document.user_id);
            formData.append('id', document.id);
            formData.append('description', document.rejectDescription); // Include rejection reason

            axios.post('/v1/api/admin/action', formData)
                .then(response => {
                    console.log('Document rejected:', response.data);
                    Swal.fire("Success", response.data.message, "success");
                    this.loadListData();
                    this.showModal = false;
                    // Reset rejection description and flag
                    document.rejectDescription = ''; // Clear rejection reason
                    document.showDescription = false; // Hide description box
                })
                .catch(error => {
                    console.error('Error rejecting document:', error);
                    Swal.fire("Error", error.message || "Failed to reject document", "error");
                });
        },

        confirmReject(document) {
            document.showDescription = !document.showDescription;
            Swal.fire({
                title: 'Are you sure you want to reject this document?',
                input: 'textarea',
                inputPlaceholder: 'Enter rejection reason...',
                showCancelButton: true,
                confirmButtonText: 'Reject',
                cancelButtonText: 'Cancel',
                preConfirm: (reason) => {
                    if (!reason) {
                        Swal.showValidationMessage('Rejection reason is required');
                    } else {
                        // Include rejection reason in FormData
                        const formData = new FormData();
                        formData.append('type', 'reject');
                        formData.append('user_id', document.user_id);
                        formData.append('id', document.id);
                        formData.append('description', reason); // Include rejection reason

                        // Make the API call to reject the document
                        axios.post('/v1/api/admin/action', formData)
                            .then(response => {
                                console.log('Document rejected:', response.data);
                                Swal.fire("Success", response.data.message, "success");
                                this.loadListData();
                                this.showModal = false;
                                // Reset rejection description and flag
                                document.rejectDescription = ''; // Clear rejection reason
                                document.showDescription = false; // Hide description box
                            })
                            .catch(error => {
                                console.error('Error rejecting document:', error);
                                Swal.fire("Error", error.message || "Failed to reject document", "error");
                            });
                    }
                }
            });
        },

        closeModal() {
            this.showModal = false;
            this.modalContent = [];
        }
    },
    mounted() {
        this.loadListData();
    }
});