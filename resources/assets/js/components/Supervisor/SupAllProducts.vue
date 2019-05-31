<template>
   <div class="supervisor_wrap">
        <supervisor-nav></supervisor-nav>
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="sup_main">
                        <div class="top_strip">
                            <div class="select_cat">
                                <select class="form-control" v-model="selCat">
                                    <option selected disabled value="">- Select a category -</option>
                                    <option v-for="cat in categs" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                                </select>
                                <button type="button" class="btn btn-primary" @click="selCatProds"><i class="fa fa-filter"></i>&nbsp; Filter</button>
                            </div>
                            <span></span>
                             <div class="input-group">
                                <input type="text" class="form-control" v-model="q" @keyup.enter="searchProduct" placeholder="Type to search for stock..">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button" @click.prevent="searchProduct"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </div>
                        <div class="stock_table">
                            <h4 class="text-center">All Products - {{ products.length }}</h4> 
                            <table class="table table-responsive table-hover table-condensed table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Product Name</th>
                                        <th>Category</th>
                                        <th>Size</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="prod in products" :key="prod.id">
                                        <td>{{ prod.id }}</td>
                                        <td>{{ prod.name }}</td>
                                        <td>{{ prod.category.name }}</td>
                                        <td>{{ prod.size }}</td>
                                        <td class="action"><button class="btn btn-primary btn-sm" type="button" @click="viewProduct(prod)">View <i class="fa fa-eye"></i></button>
                                            <button class="btn btn-default btn-sm" type="button">Edit <i class="fa fa-pencil"></i></button>
                                            <button class="btn btn-danger btn-sm" type="button">Delete <i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div> 
                    </div>
                </div>
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
            selCat: null,
            q: ''
        }
    },
    methods: {
        getProducts(){
            axios.get('/sup_getallproducts').then((res) => {
                this.products = res.data
            })
        },
        getCategs(){
            axios.get('/getcategs').then((res) => {
                this.categs = res.data
            })
        },
        selCatProds(){
            axios.get('/sup_getproductsfromcateg/' + this.selCat).then((res) => {
                this.products = res.data
            })
        },
        searchProduct(){
            if(this.q.trim() !== ''){
                axios.post('/sup_searchproduct', {
                    q: this.q.trim()
                }).then((res) => {
                    this.$router.push({name: 'SupProdsSearch', query:{q: this.q}, params:{result: res.data}})
                    localStorage.setItem('SupProdsSearch', JSON.stringify(res.data))
                })
            }
        },
        viewProduct(prod){
            this.$router.push({path: '/supervisor/product/' + prod.id})
        }
    },
    mounted() {
        this.getProducts()

        this.getCategs()
    },
}
</script>

<style scoped>
   
</style>

