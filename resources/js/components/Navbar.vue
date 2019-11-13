<template>
<div class="col-md-12">
                <nav class="navbar navbar-dark bg-dark justify-content-between mb-2">
                  <a class="navbar-brand">Super Shop</a>
                  <form @submit.prevent="search" class="form-inline">
                    <input class="form-control mr-sm-2" @keyup="search" v-model="keyword" type="text" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                  </form>
                </nav>
 </div>
</template>

<script>
    export default {
        data(){
            return{
                keyword:''
            }
        },
        methods:{
            search(){
                console.log('search')
                this.$nextTick(() => {
        this.$emit('search',this.keyword)
      });
                
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
