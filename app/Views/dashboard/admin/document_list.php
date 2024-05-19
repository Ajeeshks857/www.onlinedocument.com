<div id="admin-dashboard">
    <?=view('dashboard/admin/document_verify')?>
    <table id="adminDataTable" class="table hover multiple-select-row data-table-export nowrap">
        <thead>
            <tr>
                <th class="table-plus datatable-nosort">File</th>
                <th> Status</th>
                <th>Description</th>
                <th>Status</th>
                <th>Date</th>

            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
    
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="<?=base_url('backend/js/admin-controller.vue.js')?>?v=<?=time()?>"></script>
 <?=$this->renderSection('scripts');?>