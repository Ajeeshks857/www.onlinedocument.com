<div v-if="showModal" class="modal" style="display: block;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Document Details</h5>
                <button type="button" class="close" @click="closeModal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6>File Names:</h6><br>
                <ul>
                    <li v-for="(document, index) in modalContent" :key="index">
                        <div class="pd-20 card-box height-100-p">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <a :href="'<?=base_url('writable/uploads/')?>' + document.file_path"
                                        target="_blank">{{document.file_name}}</a>
                                </li>
                                <li class="list-group-item">
                                    <template v-if="document.approval_status === 'pending'">
                                        <button type="button" class="btn btn-success" @click="approveDocument(document)">Approve</button>
                                        <button type="button" class="btn btn-danger" @click="confirmReject(document)">Reject</button>
                                    </template>
                                    <span v-else-if="document.approval_status === 'approved'" class="text-success">Approved</span>
                                    <span v-else-if="document.approval_status === 'rejected'" class="text-danger">Rejected</span>
                                </li>
                                <li class="list-group-item" v-if="document.showDescription">
                                    <textarea v-model="document.rejectDescription" class="form-control" placeholder="Enter rejection reason"></textarea>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="closeModal">Close</button>
            </div>
        </div>
    </div>
</div>
