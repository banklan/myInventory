<template>
    <div class="admin_wrap">
       <div class="sidebar">
            <admin-sidebar></admin-sidebar>
        </div>
        <div class="main">
            <div class="breadcrumb"><router-link :to="{name: 'admin'}">Dashboard</router-link> > Products</div>
            <div class="top_btn">
                <button type="button" class="btn btn-primary" @click="openCreate"><i class="fa fa-plus"></i>Add New Product</button>
            </div>
            <modal name="create" height="auto" :draggable="true" :width="550">
                <div class="modal-header">
                    <h4 class="text-center">New Product </h4>
                    <div v-if="createErr" class="alert alert-danger">
                        {{ createProdErr }}
                    </div>
                </div>
                <div class="modal-body form-horizontal">
                    <div class="form-group">
                        <label for="name" class="control-label col-md-4">Product Name</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="name" v-model="newProd.name" v-validate.disable="'required|max:40'" data-vv-as="Product Name"/>
                            <div v-show="errors.has('name')" class="alert alert-danger">
                                <div class="validation">
                                    {{ errors.first('name') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="category" class="control-label col-md-4">Product Category</label>
                        <div class="col-md-8">
                            <select class="form-control" name="category" v-model="newProd.cat" v-validate.disable="'required'"> 
                                <option v-for="cat in categs" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                            </select>
                            <div v-show="errors.has('category')" class="">
                                <div class="validation alert alert-danger">
                                    {{ errors.first('category') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="size" class="control-label col-md-4">Choose Size</label>
                        <div class="col-md-8">
                            <select class="form-control" name="size" v-model="newProd.size" v-validate.disable="'required'">
                                <option value="Small">Small</option>
                                <option value="Medium">Medium</option>
                                <option value="Big">Big</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cost" class="control-label col-md-4">Product Cost Price(&#8358;)</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="cost" v-model="newProd.cost" v-validate.disable="'required|decimal:2'" data-vv-as="Cost Price">
                            <div v-show="errors.has('cost')" class="alert alert-danger">
                                <div class="validation">
                                    {{ errors.first('cost') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="selling" class="control-label col-md-4">Product Selling Price(&#8358;)</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="selling" v-model="newProd.selling" v-validate.disable="'required|decimal:2'" data-vv-as="Selling Price">
                            <div v-show="errors.has('selling')" class="alert alert-danger">
                                <div class="validation">
                                    {{ errors.first('selling') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer modal_btns">
                    <button class="btn btn-primary" :disabled="loading" @click.prevent="createProd">
                        <i v-if="loading" class="fa fa-spin fa-spinner"></i>{{ loading ? 'Creating...' : 'Create Product' }}</button>
                    <button class="btn btn-danger" @click.prevent="cancelCreate">Cancel</button>
                </div>
            </modal>
            <div class="categ_table">
                <h4 class="text-center">All Products <span class="badge">{{ products.length }}</span></h4>
                <div v-if="products.length === 0" class="alert alert-warning">
                    There are no products to display in your table
                </div>
                <table v-else class="table table-responsive table-bordered table-hover prod">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(prod, index) in products" :key="prod.id">
                            <td>{{ prod.id }}</td>
                            <td>{{ prod.name }}</td>
                            <td>{{ prod.category && prod.category.name }}</td>
                            <td>{{ prod.created_at }}</td>
                            <td class="action">
                                <button class="btn btn-primary btn-sm" @click.prevent="viewProd(prod.id)"><i class="fa fa-pencil"></i>View</button>
                                <button class="btn btn-danger btn-sm" @click.prevent="delProd(prod, index)"><i class="fa fa-trash"></i>Delete</button>
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
            products: [],
            categs: [],
            newProd: {
                name: '',
                cat: '',
                cost: null,
                selling: null,
                size: ''
            },
            loading: false,
            createErr: false,
            createProdErr: '',
            cat_name: ''
        }
    },
    methods: {
        getProducts(){
            axios.get('/admin_getproducts').then((res)=> {
                this.products = res.data
            })
        },
        getCategs(){
            axios.get('/admin_getcategs').then((res) => {
                this.categs = res.data
            })
        },
        cancelEdit(){
            this.$modal.hide('edit-prod')
        },
        delProd(prod, index){
            if(confirm("Are you sure you want to delete this product? It is an irrecoverable action!")){
                axios.post('/admin_delprod/' + prod.id).then((res) => {
                    console.log(res.data)
                    this.products.splice(index, 1);
                    this.$toasted.show('Product deleted!',
                    {
                        type: 'success'
                    })
                })
            }
        },
        viewProd(prod){
            this.$router.push({path: '/admin/products/product/'+ prod})
        },
        openCreate(){
            this.$modal.show('create')
        },
        createProd(){
            this.$validator.validateAll().then(() =>{
                if(!this.errors.any()){
                    this.loading = true
                    axios.post('/admin_createproduct', {
                        name: this.newProd.name.trim(),
                        cat: this.newProd.cat,
                        cost: this.newProd.cost,
                        selling: this.newProd.selling,
                        size: this.newProd.size
                    }).then((res) => {
                        this.loading = false
                        this.cancelCreate()
                        this.products.push(res.data)
                        this.$toasted.show('Product created!',
                        {
                            type: 'success'
                        })
                    })
                }
            })
        },
        cancelCreate(){
            this.newProd = ''
            this.$modal.hide('create')
        },
    },
    mounted() {
        this.getCategs()
        this.getProducts()
    },
}
</script>

<style lang="scss">
    table td.action{
        display: flex;
        justify-content: space-around;
        align-items: center;
    }
</style>
