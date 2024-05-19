<!-- horizontal Basic Forms Start -->
<div class="pd-20 card-box mb-30" id="user-details">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#form-tab">Upload Documents</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#list-tab" @click="loadListData" >Document List</a>
        </li>
    </ul>
    <br>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="form-tab">
            <div class="clearfix">
                <div class="pull-left">
                    <h4 class="text-blue h4">Basic Details</h4>
                    <p class="mb-30">Please fill the details</p>
                </div>

            </div>
            <form @submit.prevent="submitForm">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Name</label>
                            <input v-model="formData.text" class="form-control" type="text"
                                placeholder="Johnny Brown" />
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input v-model="formData.email" class="form-control" type="email" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Phone</label>
                            <input v-model="formData.phone" @change="validatePhone" class="form-control" type="tel" />
                            <span v-if="errors.phone" class="text-danger">{{ errors.phone }}</span>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea v-model="formData.address" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>File</label>
                    <input type="file" ref="fileInput" multiple @change="handleFileUpload" />
                </div>
                <!-- Submit and Cancel Buttons -->
                <div class="clearfix">
                    <button type="submit" class="btn btn-primary float-right">Submit</button>
                    <button type="button" class="btn btn-secondary float-right mx-2" @click="cancelForm">Cancel</button>
                </div>
            </form>
        </div>
        <div class="tab-pane fade" id="list-tab">
            <!-- Place your list content here -->
            <div class="pd-20">
                <h4 class="text-blue h4">List</h4>
                <?=view('dashboard/user/document_list')?>
            </div>
        </div>
    </div>
</div>
<!-- horizontal Basic Forms End -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="<?=base_url('backend/js/user-controller.vue.js')?>?v=<?=time()?>"></script>