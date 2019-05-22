<template>
    <div class="supervisor_wrap">
        <supervisor-nav></supervisor-nav>
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="sup_main">
                        <div class="top_strip">
                            <router-link :to="{name: 'SupAllStocks'}"><i class="fa fa-arrow-left"></i> Back</router-link>
                            <h4>Add new  - {{ prod.name }} / {{ prod.size }}</h4> 
                        </div>
                        <div class="form_wrap form-horizontal">
                            <div class="form-group">
                                <label for="unitPrice" class="control-label col-md-2">Unit Price</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon1">&#8358;</span>
                                        <input class="form-control" v-model="prod.sellin_price" readonly aria-describedby="basic-addon1">
                                    </div>
                                </div>
                                <div style="clear:both"></div>
                            </div>
                            <div class="form-group">
                                <label for="rcvd" class="control-label col-md-2">Packs Rcvd</label>
                                <div class="col-md-4">
                                    <input class="form-control" type="text" name="rcvd" v-model="newStock.packsRcvd" v-validate="'required|numeric'" data-vv-as="Packs received">
                                    <div v-show="errors.has('rcvd')">
                                        <div class="validation">
                                            {{ errors.first('rcvd') }}
                                        </div>
                                    </div>
                                </div>
                                <label for="unitspp" class="control-label col-md-2">Units in Pack</label>
                                <div class="col-md-4">
                                    <input class="form-control" type="text" name="unitspp" v-model="newStock.unitsPp" @blur="calcTotalUnits" v-validate="'required|numeric'" data-vv-as="Units per pack">
                                    <div v-show="errors.has('unitspp')">
                                        <div class="validation">
                                            {{ errors.first('unitspp') }}
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="totalUnits" class="control-label col-md-2">Total Units</label>
                                <div class="col-md-4">
                                    <input class="form-control" v-model="newStock.totalUnits" readonly @blur="calcTotalCost">
                                </div>
                                <label for="totalCost" class="control-label col-md-2">Total Cost</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon1">&#8358;</span>
                                        <input class="form-control" v-model="newStock.totalCost" readonly>
                                    </div>
                                </div>
                                <div style="clear:both"></div>
                            </div>
                            <div class="form-group">
                                <label for="srln" class="control-label col-md-2">Serial No</label>
                                <div class="col-md-4">
                                    <input class="form-control" name="srln" type="text" v-model="newStock.srln" v-validate="'required'" data-vv-as="serial number">
                                    <div v-show="errors.has('srln')">
                                        <div class="validation">
                                            {{ errors.first('srln') }}
                                        </div>
                                    </div>
                                </div>
                                <label for="colour" class="control-label col-md-2">Colour</label>
                                <div class="col-md-4">
                                    <input class="form-control" type="text" v-model="newStock.colour">
                                </div>
                                <div style="clear:both"></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2" for="mfg">Manuf Date</label>
                                <div class="col-md-4">
                                    <input type="date" class="form-control" v-model="newStock.mfg">
                                </div>
                                <label class="control-label col-md-2" for="exp">Expiry</label>
                                <div class="col-md-4">
                                    <input type="date" class="form-control" v-model="newStock.expiry">
                                </div>
                                <div style="clear:both"></div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-4 col-md-offset-4">
                                    <button class="btn btn-primary btn-block" :disabled="loading" @click.prevent="uploadStock">
                                    <i v-if="loading" class="fa fa-spin fa-spinner"></i>{{ loading ? ' Saving Stock...' : 'Save' }}</button>
                                </div>
                            </div>
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
            loading: false,
            id: this.$route.params.id,
            prod: [],
            newStock: {
                unitPrice: null,
                totalUnits: null,
                unitsPp: null,
                packsRcvd: null,
                totalCost: null,
                srln: '',
                colour: '',
                mfg: '',
                expiry: '',
                totalUnformatted: null,
                unitPriceUnformatted: null,
                name: ''
            },
        }
    },
    methods: {
       calcTotalUnits(){
            this.newStock.totalUnits = parseFloat(this.newStock.unitsPp) * parseFloat(this.newStock.packsRcvd)    
        },
        calcTotalCost(){
            // calc total cost
            let totalCost = this.newStock.totalUnits * parseFloat(this.prod.selling_price / 100)
            // format in currency format
            this.newStock.totalCost = totalCost.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&, ')
            this.newStock.totalUnformatted = totalCost
        },
        uploadStock(){
            this.$validator.validateAll().then(() =>{
                if(!this.errors.any()){
                    axios.post('/sup_add_new_stock/' + this.id, {
                        stock: this.newStock
                    }).then((res) => {
                        console.log(res.data)
                        this.$router.push({name: 'SupAllStocks'})
                        this.$toasted.show('New stock has been saved!',
                        {
                            type: 'success'
                        })
                    })
                }
            })
        },
    },
    mounted() {
        axios.get('/sup_getproduct/' + this.id).then((res) => {
            this.prod = res.data
            
            this.newStock.unitPrice = res.data.sellin_price
            this.newStock.unitPriceUnformatted = res.data.selling_price / 100
        })

        
    },
}
</script>

<style lang="scss" scoped>
    .sup_main{
       .top_strip{
            display: flex;
            justify-content: space-around;
            align-items: center;

            a{
                flex: 0 1 30%;
            }

            h4{
                flex: 1 1 50%;
            }
        } 
        .form_wrap{
            margin: 2rem auto 3rem auto;
            padding: 2.5rem;
            border: 1px solid #eaeaea;
            border-radius: 4px;
            background: #fff;
            box-shadow: 0px 0px 5px rgba(220,220,215,.8);

            .form-group:not(:last-child){
                margin-bottom: 2rem;
            }
            .form-group:last-child{
                margin-top: 3rem;
            }
        }
    }
    
</style>
