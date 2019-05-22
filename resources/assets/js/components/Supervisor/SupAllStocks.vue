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
                                <button type="button" class="btn btn-primary" @click="selCatStocks"><i class="fa fa-filter"></i>&nbsp; Filter</button>
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
                            <h4>All Stock</h4> 
                            <table class="table table-responsive table-hover table-condensed table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Product Name</th>
                                        <th>Category</th>
                                        <th>Size</th>
                                        <th>Stock Balance</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="prod in products" :key="prod.id">
                                        <td>{{ prod.id }}</td>
                                        <td>{{ prod.name }}</td>
                                        <td>{{ prod.category.name }}</td>
                                        <td>{{ prod.size }}</td>
                                        <td>{{ prod.totalUnits }}</td>
                                        <td><router-link :to="{path: '/supervisor/add_stock/' + prod.id}" class="btn btn-success">Add Stock</router-link></td>
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
    export default{
        data() {
            return {
                products: [],
                q: '',
                categs: [],
                selCat: null
            }
        },
        methods: {
            getCats(){
                axios.get('/getcategs').then((res) => {
                    this.categs = res.data
                })
            },
            getAllProducts(){
                axios.get('/sup_getallproducts').then((res) => {
                    this.products = res.data
                    // console.log(res.data)
                    let rez = res.data
                    this.getTotalUnits(rez)
                })
            },
            selCatStocks(){
                axios.get('/sup_getproductsfromcateg/' + this.selCat).then((res) => {
                    this.products = res.data
                    this.getTotalUnits(res.data)
                })
            },
            getTotalUnits(rez){
                for (let i = 0; i < rez.length; i++) {
                    let stocks = rez[i].stocks
                    for(let j = 0; j < stocks.length; j++){
                        let totalUnits = stocks.map(item=>item.total_units).reduce((prev, next) => parseFloat(prev) + parseFloat(next))
                        // console.log(totalUnits)
                        rez[i].totalUnits = totalUnits
                    }
                }
            },
            searchProduct(){
                if(this.q.trim() !== ''){
                    axios.post('/sup_searchproduct', {
                        q: this.q.trim()
                    }).then((res) => {
                       this.$router.push({name: 'SupProductSearchResult', query:{q: this.q}, params:{result: res.data}})
                       localStorage.setItem('SupProdsearchResult', JSON.stringify(res.data))
                    })
                }
            }
        },
        mounted() {
            this.getCats();

            this.getAllProducts()
        },
    }
</script>

<style lang="scss" scoped>
.supervisor_wrap .top_strip{
    width: 100%;
    height: 4rem;
    display: flex;
    justify-content: space-around;
    align-items: center;
    padding: 4rem 1rem; 

    .select_cat{
        flex: 0 1 40%;
        display: flex;
        justify-content: space-around;

        select{
            flex: 0 1 60%;
        }

        button{
            flex: 0 1 30%;
        }
    }
    span{
        flex: 0 1 20%;
    }
    .input-group{
        flex: 0 1 40%;
    }
}
.stock_table{
    margin-top: 2rem;
    thead th{
        text-align: center;
    }
    td:last-child{
        display: flex;
        justify-content: center;
        align-items: center;
    }
}
.modal-body label{
    font-size: 14px;
}
 
</style>