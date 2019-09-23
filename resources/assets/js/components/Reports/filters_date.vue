<template>
    <div class="col">
        <div class="card border-primary mb-3" style="max-width: 100%;">
            <div class="card-body text-primary">
                <h5 class="card-title">Fecha</h5>
                <hr style=" background:#007bff;">
                <date-picker v-model="time3" range :shortcuts="shortcuts" :lang="lang" confirm @confirm="change" @input="change" @change="change"></date-picker>
            </div>
        </div>
    </div>
</template>
<script>
    // import Datepicker from 'vuejs-datepicker';
    import DatePicker from 'vue2-datepicker';
    export default {
        name:'filters_date',
        components:{DatePicker},
        data(){
            return{
                fechainicio:'',
                fechafin:'',
                time3: '',
                // custom lang
                lang: {
                    days: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
                    months: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dic'],
                    pickers: ['next 7 days', 'next 30 days', 'previous 7 days', 'previous 30 days'],
                    placeholder: {
                        date: 'Select Date',
                        dateRange: 'Select Date Range'
                    }
                },
                shortcuts: [
                    {
                        text: 'Hoy',
                        onClick: () => {
                            this.time3 = [ new Date(), new Date() ]
                        }
                    },
                    {
                        text: 'Ayer',
                        onClick: () => {
                            this.time3 = [ new Date(Date.now() - 864e5), new Date(Date.now() - 864e5)]
                        }
                    },
                    {
                        text: 'Semana Pasada',
                        onClick: () => {
                            this.time3 = [ new Date().setDate(new Date().getDate() - 7), new Date(Date.now() - 864e5)]
                        }
                    },
                    {
                        text: 'Mes',
                        onClick: () => {
                            var date = new Date();
                            this.time3 = [ new Date(date.getFullYear(), date.getMonth(), 1), new Date(date.getFullYear(), date.getMonth() + 1, 0)]
                        }
                    },
                    {
                        text: 'Mes Pasado',
                        onClick: () => {
                            var date = new Date();
                            this.time3 = [ new Date(date.getFullYear(), date.getMonth() - 1, 1), new Date(date.getFullYear(), date.getMonth() - 1  + 1, 0)]
                        }
                    }
                ],
            }
        },
        methods:{
            customFormatter(date) {
                return moment(date).format('D MMMM  YYYY');
            },
            change(){
                this.$emit("date_select", {date:this.time3});
            }
        },
        computed:{

        },
        watch:{
            time3()
            {
                this.$emit("date_select", {date:this.time3});
            }

        }

    }
</script>
<style>
    .inputdate{
        width: 150px;
    }
</style>