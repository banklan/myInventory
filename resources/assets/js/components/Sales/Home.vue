<template>
    <div class="sales">
        <div class="open_batch" v-if="openBatch">
            <div class="batch_form">
                <div class="form-group">
                    <div class="col-md-3">
                        <input type="text" class="form-control" v-model="today">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary" type="button" @click="openTodaysBatch">Open Batch</button>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="!openBatch">
            <!-- <sales-nav></sales-nav> -->
            <div class="items">
                <router-link :to="{name: 'FrontSales'}" class="btn btn-default">Process Sales</router-link>
                <h4>Batch: {{ todaysBatch }}</h4>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            openBatch: false,
            today: '',
            todaysBatch: ''
        }
    },
    methods: {
        openTodaysBatch(){
            axios.post('/user_openbatch').then((res) => {
                console.log(res.data)
                this.openBatch = false
                this.todaysBatch = this.getToday()
                this.$toasted.show('Batch was opened for today!',
                {
                    type: 'success'
                })
            })
        },
        getToday(){
            let today = new Date();
            let dd = String(today.getDate()).padStart(2, '0')
            let mm = String(today.getMonth() + 1).padStart(2, '0')
            let yy = today.getFullYear();
            return dd + '/' + mm + '/' + yy
        }
    },
    mounted() {
        // check if batch opened
        axios.get('/get_batchstatus').then((res) => {
            console.log(res.data)
            if(res.data === 0){
                this.openBatch = true
                this.today = this.getToday()
            }else{
                this.openBatch = false
                this.todaysBatch = this.getToday()
            }
        })
    },
}
</script>

<style>
    .items{
        margin: 2rem;
        display: flex;
        justify-content: space-around;
        align-items: center;
    }
    .items a{
        flex: 0 1 25%;
        background: transparent;
        padding: 8px 25px;
        border: 1px solid #b115ce;
        transition: all .4s;
    }
    .items a:hover{
        background: #b115ce;
        border: 1px solid #b115ce;
        color: #fff;
    }
</style>
