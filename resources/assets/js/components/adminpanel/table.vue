<template>
    <div style="height: 500px;overflow-y: auto">
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <template v-for="header in headers ">
                        <th scope="col">{{header}}</th>
                    </template>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <template v-for="(data, index) in datas">
                    <tr>
                        <template v-for="item in data">
                            <td>{{item}}</td>
                        </template>
                        <td><button type="button" class="btn btn-sm btn-warning" @click="edit(index)"><i class="fa fa-edit"></i></button></td>
                    </tr>
                </template>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
    export default {
        name:'tableadmin',
        props:['headers', 'datas'],
        components:{},
        data(){
            return{

            }
        },
        methods:{
            edit(i)
            {
                this.$emit('selected', i)
            }
        },
        computed:{

        },
        mounted() {
        }

    }
</script>
<style>

</style>