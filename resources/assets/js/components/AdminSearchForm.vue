<template>
    <div class="input-group">
        <input type="text" class="form-control" v-model="q" @keyup.enter="searchUser" placeholder="Type to search for any user..">
        <span class="input-group-btn">
            <button class="btn btn-primary" type="button" @click.prevent="searchUser"><i class="fa fa-search"></i></button>
        </span>
    </div>
</template>

<script>
export default {
    data() {
        return {
            q: ''
        }
    },
    methods: {
        searchUser(){
            // console.log(this.query)
            axios.post('/adminsearch_admin', {
                q: this.q
            }).then((res) => {
                let vm = this
                vm.$router.push({name: 'AdminUserSearchresult', query:{q: this.q}, params:{result: res.data}})
                // console.log(res.data)
                localStorage.setItem('searchResult', JSON.stringify(res.data))
            })
        }
    },
}
</script>

<style lang="scss" scoped>
    .search{
        display: flex;
        justify-content: space-around;
        align-items: center;

        input{
            width: 100%;
        }
        .fa{
            margin-left: -3.5rem;
            font-size: 18px;
            color: var(--pry-col-red)
        }
    }
</style>
