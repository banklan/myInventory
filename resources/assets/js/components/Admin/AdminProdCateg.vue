<template>
    <div class="admin_wrap">
       <div class="sidebar">
            <admin-sidebar></admin-sidebar>
        </div>
        <div class="main">
            <div class="breadcrumb"><router-link :to="{name: 'admin'}">Dashboard</router-link> > Categories</div>
            <div class="top_btn">
                <button type="button" class="btn btn-primary" @click="openCreate"><i class="fa fa-plus"></i>Add New Category</button>
            </div>
            <modal name="create" height="auto" :draggable="true" :width="450">
                <div class="modal-header">
                    <h4 class="text-center">New Category </h4>
                    <div v-if="createErr" class="alert alert-danger">
                        {{ createError }}
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="fullname" class="control-label col-md-8">Category Name</label>
                        <div style="clear:both"></div>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="text" v-model="newCateg">
                        </div>
                    </div>
                </div>
                <div class="modal-footer modal_btns">
                    <button class="btn btn-primary" :disabled="loading" @click.prevent="createCateg">
                        <i v-if="loading" class="fa fa-spin fa-spinner"></i>{{ loading ? 'Creating...' : 'Create Category' }}</button>
                    <button class="btn btn-danger" @click.prevent="cancelCreate">Cancel</button>
                </div>
            </modal>
            <modal name="edit-cat" height="auto" :draggable="true" :width="450">
                <div class="modal-header">
                    <h4 class="text-center">Edit Category </h4>
                    <div v-if="createErr" class="alert alert-danger">
                        {{ createError }}
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="fullname" class="control-label col-md-8">Category Name</label>
                        <div style="clear:both"></div>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="text" v-model="editCateg.name">
                        </div>
                    </div>
                </div>
                <div class="modal-footer modal_btns">
                    <!-- <button class="btn btn-primary" @click.prevent="updateCat">Test</button> -->
                    <button class="btn btn-primary" :disabled="loading" @click.prevent="updateCat">
                        <i v-if="loading" class="fa fa-spin fa-spinner"></i>{{ loading ? 'Updating...' : 'Save Updates' }}</button>
                    <button class="btn btn-danger" @click.prevent="cancelEdit">Cancel</button>
                </div>
            </modal>
            <div class="categ_table">
                <h4 class="text-center">All Categories</h4>
                <div v-if="categs.length === 0" class="alert alert-warning">
                    There are no categories to display in your table
                </div>
                <table v-else class="table table-responsive table-bordered table-hover prod">
                    <thead>
                        <tr>
                            <th>Category ID</th>
                            <th>Category Name</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(cat, index) in categs" :key="cat.id">
                            <td>{{ cat.id }}</td>
                            <td>{{ cat.name }}</td>
                            <td>{{ cat.created_at }}</td>
                            <td class="action">
                                <button class="btn btn-primary btn-sm" @click.prevent="editCat(cat)"><i class="fa fa-pencil"></i>Edit</button>
                                <button class="btn btn-danger btn-sm" @click.prevent="delCat(cat, index)"><i class="fa fa-trash"></i>Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            categs: [],
            newCateg: '',
            loading: false,
            createErr: false,
            createError: '',
            editCateg: {
                name: '',
                id: ''
            }
        }
    },
    methods: {
        getCategs(){
            axios.get('/admin_getcategs').then((res) => {
                console.log(res.data)
                this.categs = res.data
            })
        },
        editCat(cat){
            this.$modal.show('edit-cat')
            this.editCateg.name = cat.name
            this.editCateg.id = cat.id
        },
        cancelEdit(){
            this.$modal.hide('edit-cat')
        },
        updateCat(){
            if(this.editCateg !== ''){
                this.loading = true
                axios.post('/admin_updatecateg/' + this.editCateg.id, {
                    categ: this.editCateg.name.trim()
                }).then((res) => {
                    console.log(res.data)
                    this.loading = 
                    this.$modal.hide('edit-cat')
                    this.getCategs();
                    this.$toasted.show('Category Updated!',
                    {
                        type: 'success'
                    })
                }).catch((err) =>{
                    this.loading = false;
                    this.createErr = false;
                    this.createError = 'Create new category failed. Please try again!'
                })
            }else{
                this.createErr = true;
                this.createError = 'The category name cannot be empty'
            }
        },
        delCat(cat, index){
            if(confirm("Are you sure you want to delete this category? It is an irrecoverable action!")){
                axios.post('/admin_delcat/' + cat.id).then((res) =>{
                    this.categs.splice(index, 1);
                    this.$toasted.show('Category deleted!',
                    {
                        type: 'success'
                    })
                })
            }
        },
        openCreate(){
            this.$modal.show('create')
        },
        createCateg(){
            if(this.newCateg !== ''){
                axios.post('/admin_createcateg', {
                    categ: this.newCateg.trim()
                }).then((res) => {
                    this.categs.push(res.data);
                    this.cancelCreate()
                    console.log(res.data)
                    this.$toasted.show('New Category Created!',
                    {
                        type: 'success'
                    })
                }).catch((err) => {
                    this.createErr = true;
                    this.createError = 'Create failed. Please try again'
                })
            }else{
                this.createErr = true;
                this.createError = 'The category name cannot be empty'
            }
            console.log(this.newCateg)
        },
        cancelCreate(){
            this.newCateg = ''
            this.$modal.hide('create')
        },
    },
    mounted() {
        this.getCategs()
    },
}
</script>

<style lang="scss">
    .main{
        .top_btn{
            padding: 2rem;
        }
        .categ_table{
            padding: 2rem;

            h4{
                padding: 1.5rem;
            }

            table.prod{
                th{
                    text-align: center;
                }
                .action{
                    display: flex;
                    justify-content: space-around;
                    align-items: center;
                }
            }
        }
        .form-group{
            padding-bottom: 3.5rem;
        }
    }
    
</style>
