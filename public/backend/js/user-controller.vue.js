new Vue({
    el: '#user-details',
    data: {
        formData: {
            text: '',
            email: '',
            phone: '',
            address: '',
            files: [],
        },
        errors: {
            text: '',
            email: '',
            phone: '',
            address: '',
            file: '',
        }
    },
    methods: {
        handleFileUpload(event) {
            this.formData.files = Array.from(event.target.files);
        },

        validatePhone() {
            const phoneRegex = /^\d{10}$/;
            if (!phoneRegex.test(this.formData.phone)) {
                this.errors.phone = 'Phone number must be exactly 10 digits';
            } else {
                this.errors.phone = '';
            }
        },
        validateForm() {
            this.errors = {};
            let isValid = true;
            if (!this.formData.text) {
                this.errors.text = 'Text is required';
                isValid = false;
            }
            if (!this.formData.email) {
                this.errors.email = 'Email is required';
                isValid = false;
            }

            return isValid;
        },
        submitForm() {
            if (!this.validateForm()) {
                this.showSwalError('Please fill the details in the form');
                return;
            }

            const formData = new FormData();
            formData.append('text', this.formData.text);
            formData.append('email', this.formData.email);
            formData.append('phone', this.formData.phone);
            formData.append('address', this.formData.address);

            this.formData.files.forEach((file, index) => {
                formData.append(`files[${index}]`, file);
            });


            for (let pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }

            axios.post('/v1/api/user/create-details', formData)
                .then(response => {
                    console.log(response.data);
                    this.showSwalSuccess('Form submitted successfully!');
                    this.resetForm();
                })
                .catch(error => {
                    console.error(error);
                    if (error.response && error.response.status === 400 && error.response.data && error.response.data.messages) {
                        const errorMessages = error.response.data.messages;
                        let errorMessage = '';
                        for (const key in errorMessages) {
                            if (errorMessages.hasOwnProperty(key)) {
                                errorMessage += `${errorMessages[key]}\n`;
                            }
                        }
                        this.showSwalError(errorMessage);
                    } else {
                        this.showSwalError('An error occurred while submitting the form. Please try again.');
                    }
                });
        },

        cancelForm() {
            this.resetForm();
        },
        resetForm() {
            this.formData = {
                text: '',
                email: '',
                phone: '',
                address: '',
                files: [],
            };
            this.$refs.fileInput.value = '';
            this.errors = {};
        },
        showSwalSuccess(message) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: message,
                showConfirmButton: false,
                timer: 1500
            });
        },
        showSwalError(message) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: message,
            });
        },
        loadListData() {
            axios.get('/v1/api/user/get-details')
                .then(response => {
                    const data = response.data.data;
                    $('#userDataTable tbody').empty();
                    data.forEach(rowData => {
                        $('#userDataTable tbody').append(`<tr>
                    <td>${rowData.file_name}</td>
                    <td>${rowData.approval_status}</td>
                    <td> ${rowData.description} </td>
                    <td>${rowData.created_at}</td>
                </tr>`);
                    });

                    $('#userDataTable').DataTable();
                })
                .catch(error => {
                    console.error('Error loading data:', error);
                });
        },
    


    }
});